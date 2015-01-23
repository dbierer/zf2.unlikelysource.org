<?php
$dir = realpath(__DIR__ . '/../../../data/cache');
return array(
    'navigation' => array(
        'default' => array(
    	   array('label' => 'CacheDemo', 'route' => 'cache-demo', 'order' => 1900),
        ),
    ),
    'service_manager' => array(
        'services' => array(
            'cache-demo-config' => array(
           		'adapter' => array(
       				'name'    => 'filesystem',
       				'options' => array('ttl' => 3600, 'cache_dir' => $dir),
           		),
           		'plugins' => array(
      				'exception_handler' => array('throw_exceptions' => TRUE),
           		),
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
    	   'cache-demo-controller-index' => 'CacheDemo\Controller\IndexController',
        ), 	
    ),
    'router' => array(
        'routes' => array(
            'cache-demo' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/cache-demo[/:action]',
                    'defaults' => array(
                        'controller'    => 'cache-demo-controller-index',
                        'action'        => 'index',
                    ),
                    'constraints' => array(
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'CacheDemo' => __DIR__ . '/../view',
        ),
    ),
);
