<?php
return array(
	'service_manager' => array(
		'services' => array(
			// try commenting this out and then re-run http://zf2.unlikelysource.local/check
    		'check-test' => array('key' => 'FROM MODULE.CONFIG.PHP', 'module.config.php:' . microtime()),
		),
	),
    'controllers' => array(
    	'invokables' => array(
            // test controller has no dependencies
    		'check-order-test-controller' => 'CheckOrder\Controller\TestController',
    	),
    ),
    'router' => array(
        'routes' => array(
            'check-order' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/check',
                    'defaults' => array(
                        'controller'    => 'check-order-test-controller',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:action]',
                            'constraints' => array(
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'Search' => __DIR__ . '/../view',
        ),
    ),
);
