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
        $query = \Model_User::query();

        if (!\Util\AuthUtil::isAdmin()) {
            $query->where('group', '=', 1);
        }

        $total = $query->count();

        $per_page = (int)\Input::get('per_page', 10);
        if (!in_array($per_page, [10, 20, 50])) {
            $per_page = 10;
        }
        $current_page = (int)\Input::get('page', 1);

        $pagination = \Pagination::forge('user_pagination', [
            'pagination_url' => \Uri::create('users/index') . '?per_page=' . $per_page,
            'total_items' => $total,
            'per_page' => $per_page,
            'current_page' => $current_page,
        ]);

        $users = $query
            ->rows_offset($pagination->offset)
            ->rows_limit($pagination->per_page)
            ->get();

        $view = View::forge('users/index');
        $view->set('users', $users, false);
        $view->set('pagination', $pagination->render(), false);
        $view->set('per_page', $per_page, false);

        $this->template->title = 'Users';
        $this->template->content = $view;
    }


    public function action_create()
    {
        if (!\Util\AuthUtil::isAdmin()) {
            return Response::forge('Forbidden', 403);
        }
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
        if (!\Util\AuthUtil::isAdmin()) {
            return Response::forge('Forbidden', 403);
        }
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
        if (!\Util\AuthUtil::isAdmin()) {
            return Response::forge('Forbidden', 403);
        }

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

        $val->add_field('username', 'UserName', 'required|trim|xss_clean|max_length[255]');
        $val->add_field('email', 'Email', 'required|trim|xss_clean|valid_email|max_length[255]');
        $val->add_field('password', 'Password', ($isUpdate ? '' : 'required|') . 'trim|xss_clean|min_length[6]');

        return $val;
    }

}
