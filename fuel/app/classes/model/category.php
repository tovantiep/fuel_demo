<?php

use Orm\Model;

class Model_Category extends Model
{
    protected static $_table_name = 'categories';

    protected static $_primary_key = array('id');

    protected static $_properties = array(
        'id' => array(
            'label'        => 'ID',
            'data_type'    => 'int',
        ),
        'name' => array(
            'label'        => 'Name',
            'data_type'    => 'varchar',
        ),
        'created_at' => array(
            'label'        => 'Created At',
            'data_type'    => 'int',
        ),
        'updated_at' => array(
            'label'        => 'Updated At',
            'data_type'    => 'int',
        ),
    );

    protected static $_observers = array(
        'Orm\Observer_CreatedAt' => array(
            'events' => array('before_insert'),
            'mysql_timestamp' => false,
        ),
        'Orm\Observer_UpdatedAt' => array(
            'events' => array('before_update'),
            'mysql_timestamp' => false,
        ),
    );

    protected static $_has_many = array(
        'post' => array(
            'key_from' => 'id',
            'model_to' => 'Model_Post',
            'key_to' => 'category_id',
            'cascade_save' => true,
            'cascade_delete' => false,
        ),
    );
}
