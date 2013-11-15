<?php
return array(
    'service_manager' => array(
        'factories' => array(
    	   'cache' => 'Zend\Cache\StorageFactory',
        ),    	
    ),
    // example use case in module/QandA/src/QandA/Controller/IndexController
    'cache' => array(
        'adapter' => array(
    		'name'    => 'filesystem',
    		'options' => array('ttl' => 3600, 'cacheDir' => realpath(__DIR__ . '/../../../data/cache')),
        ),
        'plugins' => array(
       		'exception_handler' => array('throw_exceptions' => false),
        ),
    ),
);
