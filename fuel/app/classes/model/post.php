<?php

class Model_Post extends \Orm\Model
{
    protected static $_properties = array(
        'id' => array(
            'label' => 'ID',
            'data_type' => 'int',
        ),
        'category_id' => array(
            'label' => 'Category',
            'data_type' => 'int',
        ),
        'title' => array(
            'label' => 'Title',
            'data_type' => 'varchar',
        ),
        'description' => array(
            'label' => 'Description',
            'data_type' => 'text',
        ),
        'content_link' => array(
            'label' => 'Content',
            'data_type' => 'text',
        ),
        'image_link' => array(
            'label' => 'Image link',
            'data_type' => 'text',
        ),
        'post_id' => array(
            'label' => 'Post ID',
            'data_type' => 'varchar',
        ),
        'created_at' => array(
            'label' => 'Created at',
            'data_type' => 'int',
        ),
        'updated_at' => array(
            'label' => 'Updated at',
            'data_type' => 'int',
        ),
    );

    protected static $_observers = array(
        'Orm\Observer_CreatedAt' => array(
            'events' => array('before_insert'),
            'property' => 'created_at',
            'mysql_timestamp' => false,
        ),
        'Orm\Observer_UpdatedAt' => array(
            'events' => array('before_update'),
            'property' => 'updated_at',
            'mysql_timestamp' => false,
        ),
    );

    protected static $_belongs_to = array(
        'category' => array(
            'key_from' => 'category_id',
            'model_to' => 'Model_Category',
            'key_to' => 'id',
            'cascade_save' => true,
            'cascade_delete' => false,
        ),
    );

    protected static $_primary_key = array('id');

    protected static $_table_name = 'posts';
}
