<?php
class Controller_Login extends Controller
{
    public function get_register()
    {
        return Response::forge(View::forge('login/register'));
    }

    public function get_profile()
    {
        return Response::forge(View::forge('login/change_password'));
    }

    public function get_login()
    {
        return Response::forge(View::forge('login/index'));
    }

    public function post_login()
    {
        $vali = $this->vali_login();
        $checkVali = $vali->run();

        if ($checkVali) {
            $this->handle_login_event();
        } else {
            return $this->handle_failed_validate_response($vali);
        }
    }

    public function action_logout()
    {
        \Auth::dont_remember_me();
        \Auth::logout();

        \Response::redirect_back('login/login');
    }

    public function post_change_password()
    {
        if (!\Auth::check()) {
            \Response::redirect('login/login');
        }

        $old_password = \Input::post('old_password');
        $new_password = \Input::post('new_password');
        $confirm_password = \Input::post('confirm_password');

        if ($new_password !== $confirm_password) {
            \Session::set_flash('errorMessage', 'New password and confirmation do not match.');
            \Response::redirect('profile/index');
        }

        if (\Auth::change_password($old_password, $new_password)) {
            \Session::set_flash('successMessage', 'Password changed successfully.');
        } else {
            \Session::set_flash('errorMessage', 'Old password is incorrect.');
        }

        \Response::redirect('users/index');
    }

    private function vali_login()
    {
        $vali = Validation::forge();

        $vali->add_field('username', 'Your username', 'required');
        $vali->add_field('password', 'Your password', 'required|min_length[6]');

        return $vali;
    }

    private function login($username, $password)
    {
        return \Auth::instance()->login($username, $password);
    }

    private function handle_login_event()
    {
        $username = \Input::param('username');
        $password = \Input::param('password');

        $checkLogin = $this->login($username, $password);

        if ($checkLogin) {
            $this->handleRememberMe(\Input::param('remember', false));

            \Response::redirect_back('users/index');
        } else {
            $this->handleFailedLoginResponse();
        }
    }

    private function handle_failed_validate_response($vali)
    {
        $errors = $vali->error();
        $oldRequest = $vali->validated();
        $data = array(
            'errors' => $errors,
            'oldRequest' => $oldRequest,
        );

        return Response::forge(View::forge('login/index')->set($data));
    }
    private function handleFailedLoginResponse()
    {
        Session::set_flash('errorMessage', 'Username or password not right!');
        return Response::redirect('login/login');
    }
    private function handleRememberMe($remeberMe = true)
    {
        if ($remeberMe) {
            \Auth::remember_me();
        } else {
            \Auth::dont_remember_me();
        }

    }
}