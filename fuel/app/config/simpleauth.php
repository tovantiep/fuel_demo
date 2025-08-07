<?php
return array(
    'remember_me' => array(
        'enabled' => true,
        'cookie_name' => 'rmcookie',
        'expiration' => 86400 * 31, // 31 ngày
    ),

    'groups' => array(
        1  => array('name' => 'Users', 'roles' => array('user')),
        100=> array('name' => 'Administrators', 'roles' => array('user', 'admin')),
    ),
);