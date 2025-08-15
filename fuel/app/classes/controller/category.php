<?php

use Util\AuthUtil;

class Controller_Category extends Controller_Template
{
    public function before()
    {
        parent::before();

        if (!\Auth::check()) {
            \Response::redirect('login/login');
            exit;
        }
    }

    public function action_index(): void
    {
        $query = \Model_Category::query();
        $total = $query->count();

        $per_page = (int)\Input::get('per_page', 10);
        if (!in_array($per_page, [10, 20, 50])) {
            $per_page = 10;
        }

        $current_page = (int)\Input::get('page', 1);

        $pagination = \Pagination::forge('category_pagination', [
            'pagination_url' => \Uri::create('category/index') . '?per_page=' . $per_page,
            'total_items' => $total,
            'per_page' => $per_page,
            'current_page' => $current_page,
            'uri_segment' => 'page',
            'show_first' => true,
            'show_last' => true,
        ]);

        $categories = $query
            ->rows_offset($pagination->offset)
            ->rows_limit($pagination->per_page)
            ->order_by('id', 'desc')
            ->get();

        $view = \View::forge('category/index');
        $view->set('categories', $categories, false);
        $view->set('pagination', $pagination->render(), false);
        $view->set('per_page', $per_page, false);

        $this->template->title = 'Categories';
        $this->template->content = $view;
    }

    public function action_create()
    {
        if (!\Util\AuthUtil::isAdmin()) {
            return Response::forge('Forbidden', 403);
        }
        if (\Input::method() === 'POST') {

            $val = $this->validate_category();

            if ($val->run()) {
                $category = Model_Category::forge([
                    'name' => \Input::post('name'),
                ]);

                if ($category->save()) {
                    \Response::redirect('category/index');
                } else {
                    \Session::set_flash('error', 'Không thể lưu Category.');
                }
            } else {
                \Session::set_flash('error', $val->error());
            }
        }
        $this->template->title = 'Post Create';
        $this->template->content = \View::forge('category/create');
    }


    public function action_update($id = null)
    {
        if (!\Util\AuthUtil::isAdmin()) {
            return Response::forge('Forbidden', 403);
        }
        $category = Model_Category::find($id);
        if (!$category) {
            \Session::set_flash('error', 'Category không tồn tại.');
            return \Response::redirect('category/index');
        }

        if (\Input::method() === 'POST' || \Input::method() === 'PUT') {
            $val = $this->validate_category();
            $input = \Input::method() === 'PUT' ? \Input::put() : \Input::post();

            if ($val->run($input)) {

                $category->name = $input['name'];

                if ($category->save()) {
                    return \Response::redirect('category/index');
                } else {
                    \Session::set_flash('error', 'Không thể cập nhật category.');
                }
            } else {
                \Session::set_flash('error', $val->error());
            }
        }

        $this->template->title = 'Edit Category';
        $this->template->content = \View::forge('category/edit', [
            'category' => $category
        ]);
    }

    public function action_delete($id = null)
    {
        if (!\Util\AuthUtil::isAdmin()) {
            return Response::forge('Forbidden', 403);
        }
        if (in_array($id, [1,2,3,4,5,6,7,8])) {
            return Response::forge(json_encode(['error' => 'Không thể xóa category mặc định']), 403);
        }
        $category = Model_Category::find($id);
        if (!$category) {
            return Response::forge(json_encode(['error' => 'Category not found']), 404);
        }
        $category->delete();
        return Response::redirect('category/index');
    }

    private function validate_category()
    {
        $val = Validation::forge();

        $val->add_field('name', 'Name', 'required|max_length[255]');
        return $val;
    }

}
