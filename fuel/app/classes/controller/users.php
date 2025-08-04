<?php

class Controller_Users extends Controller_Template
{

	public function action_index()
	{
		$data["subnav"] = array('index'=> 'active' );
		$this->template->title = 'Users &raquo; Index';
		$this->template->content = View::forge('users/index', $data);
	}

	public function action_view()
	{
		$data["subnav"] = array('view'=> 'active' );
		$this->template->title = 'Users &raquo; View';
		$this->template->content = View::forge('users/view', $data);
	}

	public function action_create()
	{
		$data["subnav"] = array('create'=> 'active' );
		$this->template->title = 'Users &raquo; Create';
		$this->template->content = View::forge('users/create', $data);
	}

	public function action_edit()
	{
		$data["subnav"] = array('edit'=> 'active' );
		$this->template->title = 'Users &raquo; Edit';
		$this->template->content = View::forge('users/edit', $data);
	}

	public function action_delete()
	{
		$data["subnav"] = array('delete'=> 'active' );
		$this->template->title = 'Users &raquo; Delete';
		$this->template->content = View::forge('users/delete', $data);
	}

}
