<?php

return array(
    'default' => 'default_connection',
    'connections' => array(
        'default_connection' => array(
            'driver' => 'beanstalkd',
            'host'   => 'beanstalkd',
            'port'   => '11300',
            'queue'  => 'jobqueue',
        ),
    ),
);