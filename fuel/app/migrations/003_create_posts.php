<?php

namespace Fuel\Migrations;

class Create_posts
{
	public function up()
	{
		\DBUtil::create_table('post', array(
            'id' => array('type' => 'int', 'unsigned' => true, 'null' => false, 'auto_increment' => true, 'constraint' => '11'),
            'category_id' => array('type' => 'int','null' => true, 'constraint' => '11'),
            'title' => array('constraint' => '255', 'null' => false, 'type' => 'varchar'),
            'description' => array('null' => true, 'type' => 'text'),
            'content_link' => array('null' => true, 'type' => 'text'),
            'image_link' => array('null' => true, 'type' => 'text'),
            'post_id' => array('constraint' => '255', 'null' => false, 'type' => 'varchar'),
            'created_at' => array('constraint' => 11, 'null' => true, 'type' => 'int', 'unsigned' => true),
            'updated_at' => array('constraint' => 11, 'null' => true, 'type' => 'int', 'unsigned' => true),
		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('post');
	}
}