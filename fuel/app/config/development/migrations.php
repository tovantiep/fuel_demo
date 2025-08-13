<?php
return array (
  'version' => array(  
    'app' => array(    
      'default' => array(      
        0 => '001_create_users',
        1 => '002_create_admin_seed',
        2 => '003_create_posts',
        3 => '004_create_categories',
        4 => '005_add_default_category_to_categories',
      ),
    ),
    'module' => array(    
    ),
    'package' => array(    
    ),
  ),
  'folder' => 'migrations/',
  'table' => 'migration',
  'flush_cache' => false,
  'flag' => NULL,
);
