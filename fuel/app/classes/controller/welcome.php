<?php
/**
 * Fuel is a fast, lightweight, community driven PHP 5.4+ framework.
 *
 * @package    Fuel
 * @version    1.9-dev
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2019 Fuel Development Team
 * @link       https://fuelphp.com
 */

/**
 * The Welcome Controller.
 *
 * A basic controller example.  Has examples of how to set the
 * response body and status.
 *
 * @package  app
 * @extends  Controller
 */
class Controller_Welcome extends Controller
{
    /**
     * @return mixed
     */
    public function action_index(): mixed
    {
        $query = \Model_Post::query()
            ->related('category')
            ->order_by('id', 'desc')
            ->limit(20);

        $category_id = \Input::get('category_id', null);

        if (!empty($category_id)) {
            $query->where('category_id', '=', (int)$category_id);
        }

        $posts = $query->get();

        $categories = Model_Category::find('all');

        return Response::forge(
            View::forge('welcome/index', [
                'posts' => $posts,
                'categories' => $categories
            ])
        );
    }

	/**
	 * A typical "Hello, Bob!" type example.  This uses a Presenter to
	 * show how to use them.
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_hello()
	{
		return Response::forge(Presenter::forge('welcome/hello'));
	}

	/**
	 * The 404 action for the application.
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_404()
	{
		return Response::forge(Presenter::forge('welcome/404'), 404);
	}
}
