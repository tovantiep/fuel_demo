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

return array(
	/**
	 * -------------------------------------------------------------------------
	 *  Default route
	 * -------------------------------------------------------------------------
	 *
	 */

	'_root_' => 'welcome/index',
    'detail/(:num)' => 'welcome/detail/$1',

	/**
	 * -------------------------------------------------------------------------
	 *  Page not found
	 * -------------------------------------------------------------------------
	 *
	 */

	'_404_' => 'welcome/404',

	/**
	 * -------------------------------------------------------------------------
	 *  Example for Presenter
	 * -------------------------------------------------------------------------
	 *
	 *  A route for showing page using Presenter
	 *
	 */

	'hello(/:name)?' => array('welcome/hello', 'name' => 'hello'),

    'users/create'        => array('users/create'),
    'users/index'         => array('users/index'),
    'users/update/(:num)' => 'users/update/$1',
    'users/delete/(:num)' => 'users/delete/$1',

    'login' => 'login/login',
    'register' => 'login/register',
    'logout' => 'login/logout',
    'profile' => 'login/profile',
    'change_password' => 'login/change_password',

    'post/create'        => array('post/create'),
    'post/index'         => array('post/index'),
    'post/update/(:num)' => 'post/update/$1',
    'post/delete/(:num)' => 'post/delete/$1',

    'category/create'        => array('category/create'),
    'category/index'         => array('category/index'),
    'category/update/(:num)' => 'category/update/$1',
    'category/delete/(:num)' => 'category/delete/$1',

    'crawl/dantri' => 'crawl/dantri',
    'crawl/summary' => 'crawl/crawl_summary',
);
