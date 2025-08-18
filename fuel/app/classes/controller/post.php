<?php

use Util\AuthUtil;

class Controller_Post extends \Fuel\Core\Controller_Hybrid
{
    public function before()
    {
        parent::before();

        if (!\Auth::check()) {
            \Response::redirect('login/login');
            exit;
        }
    }

    public function action_index()
    {
        $query = \Model_Post::query()->related('category');
        $categories = \Model_Category::find('all');

        $keyword = \Input::get('keyword');
        $category_id = \Input::get('category_id');

        if (!empty($keyword)) {
            $query->where_open()
                ->where('title', 'like', '%' . $keyword)
                ->or_where('description', 'like', '%' . $keyword)
                ->where_close();
        }

        if (!empty($category_id)) {
            $query->where('category_id', '=', (int)$category_id);
        }

        $total = $query->count();

        $per_page = (int)\Input::get('per_page', 10);
        if (!in_array($per_page, [10, 20, 50])) {
            $per_page = 10;
        }

        $current_page = (int)\Input::get('page', 1);

        $pagination = \Pagination::forge('post_pagination', [
            'pagination_url' => \Uri::create('post/index') . '?per_page=' . $per_page,
            'total_items'   => $total,
            'per_page'      => $per_page,
            'current_page'  => $current_page,
            'uri_segment'   => 'page',
            'show_first'    => true,
            'show_last'     => true,
        ]);

        $posts = $query
            ->rows_offset($pagination->offset)
            ->rows_limit($pagination->per_page)
            ->order_by('id', 'desc')
            ->get();

        if (\Input::is_ajax()) {
            $partial = \View::forge('post/_list');
            $partial->set('posts', $posts, false);
            $partial->set('pagination', $pagination->render(), false);
            return $partial;
        }

        $view = \View::forge('post/index');
        $view->set('posts', $posts, false);
        $view->set('categories', $categories, false);
        $view->set('pagination', $pagination->render(), false);
        $view->set('per_page', $per_page, false);
        $view->set('filters', [
            'keyword'     => $keyword,
            'category_id' => $category_id,
        ], false);

        $this->template->title   = 'Posts';
        $this->template->content = $view;
    }

    public function action_create()
    {
        if (!\Util\AuthUtil::isAdmin()) {
            return Response::forge('Forbidden', 403);
        }
        if (\Input::method() === 'POST') {

            $val = $this->validate_post();

            if ($val->run()) {
                $imagePath = null;

                if (isset($_FILES['image_link']) && $_FILES['image_link']['error'] === UPLOAD_ERR_OK) {
                    $uploadDir = DOCROOT . 'uploads/';
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0777, true);
                    }

                    $fileTmp = $_FILES['image_link']['tmp_name'];
                    $fileName = time() . '_' . basename($_FILES['image_link']['name']);
                    $filePath = $uploadDir . $fileName;

                    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                    if (in_array($_FILES['image_link']['type'], $allowedTypes)) {
                        if (move_uploaded_file($fileTmp, $filePath)) {
                            $imagePath = 'uploads/' . $fileName;
                        } else {
                            \Session::set_flash('error', 'Không thể upload ảnh.');
                        }
                    } else {
                        \Session::set_flash('error', 'Định dạng file không hợp lệ.');
                    }
                }

                $post = Model_Post::forge([
                    'title' => \Input::post('title'),
                    'description' => \Input::post('description'),
                    'category_id' => \Input::post('category_id'),
                    'image_link' => $imagePath,
                    'summary' => \Input::post('summary'),
                    'post_id' => time()
                ]);

                if ($post->save()) {
                    \Session::set_flash('success', 'Tạo bài viết thành công.');
                    \Response::redirect('post/index');
                } else {
                    \Session::set_flash('error', 'Không thể lưu bài viết.');
                }
            } else {
                \Session::set_flash('error', $val->error());
            }
        }

        $categories = Model_Category::find('all');
        $this->template->title = 'Post Create';
        $this->template->content = \View::forge('post/create', [
            'categories' => $categories
        ]);
    }


    public function action_update($id = null)
    {
        if (!\Util\AuthUtil::isAdmin()) {
            return Response::forge('Forbidden', 403);
        }
        $post = Model_Post::find($id);
        if (!$post) {
            \Session::set_flash('error', 'Bài viết không tồn tại.');
            return \Response::redirect('post/index');
        }

        if (\Input::method() === 'POST' || \Input::method() === 'PUT') {
            $val = $this->validate_post();
            $input = \Input::method() === 'PUT' ? \Input::put() : \Input::post();

            if ($val->run($input)) {
                $imagePath = $post->image_link;

                if (isset($_FILES['image_link']) && $_FILES['image_link']['error'] === UPLOAD_ERR_OK) {
                    $uploadDir = DOCROOT . 'uploads/';
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0777, true);
                    }

                    $fileTmp = $_FILES['image_link']['tmp_name'];
                    $fileName = time() . '_' . basename($_FILES['image_link']['name']);
                    $filePath = $uploadDir . $fileName;

                    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                    if (in_array($_FILES['image_link']['type'], $allowedTypes)) {
                        if (move_uploaded_file($fileTmp, $filePath)) {
                            $imagePath = 'uploads/' . $fileName;
                            if ($post->image_link && file_exists(DOCROOT . $post->image_link)) {
                                unlink(DOCROOT . $post->image_link);
                            }
                        } else {
                            \Session::set_flash('error', 'Không thể upload ảnh.');
                        }
                    } else {
                        \Session::set_flash('error', 'Định dạng file không hợp lệ.');
                    }
                }

                $post->title = $input['title'];
                $post->description = $input['description'];
                $post->category_id = $input['category_id'];
                $post->summary = $input['summary'];
                $post->image_link = $imagePath;

                if ($post->save()) {
                    \Session::set_flash('success', 'Cập nhật bài viết thành công.');
                    return \Response::redirect('post/index');
                } else {
                    \Session::set_flash('error', 'Không thể cập nhật bài viết.');
                }
            } else {
                \Session::set_flash('error', $val->error());
            }
        }

        $categories = Model_Category::find('all');
        $this->template->title = 'Edit Post';
        $this->template->content = \View::forge('post/edit', [
            'post' => $post,
            'categories' => $categories
        ]);
    }

    public function action_delete($id = null)
    {
        if (!\Util\AuthUtil::isAdmin()) {
            return Response::forge('Forbidden', 403);
        }
        $post = Model_Post::find($id);
        if (!$post) {
            return Response::forge(json_encode(['error' => 'Post not found']), 404);
        }
        $post->delete();
        $queryParams = \Input::get();

        $redirectUrl = 'post/index';
        if (!empty($queryParams)) {
            $redirectUrl .= '?' . http_build_query($queryParams);
        }

        return Response::redirect($redirectUrl);
    }

    private function validate_post()
    {
        $val = Validation::forge();

        $val->add_field('title', 'Title', 'required|trim|xss_clean|max_length[255]');
        $val->add_field('description', 'Description', 'required|trim|xss_clean');
        $val->add_field('category_id', 'Category', 'required|trim|xss_clean|valid_string[numeric]');
        $val->add_field('summary', 'Summary', 'trim|xss_clean');

        return $val;
    }

}
