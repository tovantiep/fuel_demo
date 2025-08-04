<?php

class Controller_Users extends Controller_Template
{

    public function action_index()
    {
        $users = Model_User::find('all');
        $view = View::forge('users/index');
        $view->set('users', $users, false);

        $this->template->title = 'Users';
        $this->template->content = $view;
    }

    public function action_create()
    {
        $view = View::forge('users/create');
        $view->set('errors', array(), false);

        if (Input::method() == 'POST') {
            $val = Validation::forge();
            $val->add_field('name', 'Name', 'required|max_length[255]');
            $val->add_field('email', 'Email', 'required|valid_email|max_length[255]');
            $val->add_field('password', 'Password', 'required|min_length[6]');

            if ($val->run()) {
                $user = new Model_User();
                $user->name = Input::post('name');
                $user->email = Input::post('email');
                $user->password = password_hash(Input::post('password'), PASSWORD_BCRYPT);

                if ($user->save()) {
                    return Response::redirect('users/index');
                } else {
                    $view->set('errors', array('Could not save user.'), false);
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

        $val = Validation::forge();
        $val->add_field('name', 'Name', 'required|max_length[255]');
        $val->add_field('email', 'Email', 'required|valid_email|max_length[255]');
        $val->add_field('password', 'Password', 'min_length[6]');

        $input = Input::method() === 'PUT' ? Input::put() : Input::post();

        if ($val->run($input)) {
            $user->name = $input['name'];
            $user->email = $input['email'];
            if (!empty($input['password'])) {
                $user->password = password_hash($input['password'], PASSWORD_BCRYPT);
            }
            if ($user->save()) {
                return Response::redirect('users/index');
            } else {
                $errors = ['Could not update user.'];
            }
        } else {
            $errors = $val->error();
        }

        $view = View::forge('users/edit');
        $view->set('user', $user, false);
        $view->set('errors', isset($errors) ? $errors : [], false);
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
        if (Input::is_ajax()) {
            return Response::forge(json_encode(['success' => true, 'message' => 'User deleted']), 200);
        }
        return Response::redirect('users/index');
    }

}
