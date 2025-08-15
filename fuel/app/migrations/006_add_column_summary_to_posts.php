<?php

namespace Fuel\Migrations;

class Add_column_summary_to_posts
{
	public function up()
	{
		\DBUtil::add_fields('posts', array(
			'summary' => array('null' => true, 'type' => 'text'),
		));
	}

	public function down()
	{
		\DBUtil::drop_fields('posts', array(
			'summary'
		));
	}
}