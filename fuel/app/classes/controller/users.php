<?php

use Util\AuthUtil;

class Controller_Users extends Controller_Template
{

    public function before()
    {
        parent::before();

        if (!\Auth::check()) {
            \Response::redirect('login/login');
            exit;
        }
    }

    /**
     * @return void
     */
    public function action_index(): void
    {
        $current_user_group = Auth::get('group');

        if (AuthUtil::isAdmin()) {
            $users = Model_User::find('all');
        } else {
            $users = Model_User::find('all', [
                'where' => [
                    ['group', '=', 1]
                ]
            ]);
        }
        $view = View::forge('users/index');
        $view->set('users', $users, false);

        $this->template->title = 'Users';
        $this->template->content = $view;
    }

    public function action_create()
    {
        $view = View::forge('users/create');
        $view->set('errors', [], false);

        if (Input::method() == 'POST') {
            $val = $this->validate_user(false);

            if ($val->run()) {
                try {
                    \Auth::create_user(
                        Input::post('username'),
                        Input::post('password'),
                        Input::post('email'),
                        1
                    );

                    return Response::redirect('users/index');
                } catch (\SimpleUserUpdateException $e) {
                    $view->set('errors', [$e->getMessage()], false);
                }
            } else {
                $view->set('errors', $val->error(), false);
            }
        }

        $this->template->title = 'Create User';
        $this->template->content = $view;
    }

    public function action_update($id = null)
    {
        $user = Model_User::find($id);
        if (!$user) {
            return Response::redirect('users/index');
        }

        $errors = [];
        if (Input::method() === 'POST' || Input::method() === 'PUT') {
            $val = $this->validate_user(true);
            $input = Input::method() === 'PUT' ? Input::put() : Input::post();

            if ($val->run($input)) {
                try {
                    $updateData = [
                        'username' => $input['username'],
                        'email' => $input['email'],
                    ];

                    if (!empty($input['password'])) {
                        $updateData['password'] = $input['password'];
                    }

                    \Auth::update_user($updateData, $user->username);

                    return Response::redirect('users/index');
                } catch (\SimpleUserUpdateException $e) {
                    $errors[] = $e->getMessage();
                }
            } else {
                $errors = $val->error();
            }
        }

        $view = View::forge('users/edit');
        $view->set('user', $user, false);
        $view->set('errors', $errors, false);
        $this->template->title = 'Edit User';
        $this->template->content = $view;
    }

    public function action_delete($id = null)
    {
        $user = Model_User::find($id);
        if (!$user) {
            return Response::forge(json_encode(['error' => 'User not found']), 404);
        }
        $user->delete();
        return Response::redirect('users/index');
    }

    private function validate_user($isUpdate = false)
    {
        $val = Validation::forge();

        $val->add_field('username', 'UserName', 'required|max_length[255]');
        $val->add_field('email', 'Email', 'required|valid_email|max_length[255]');

        if ($isUpdate) {
            $val->add_field('password', 'Password', 'min_length[6]');
        } else {
            $val->add_field('password', 'Password', 'required|min_length[6]');
        }

        return $val;
    }

}
