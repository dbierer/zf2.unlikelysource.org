<?php
return array(
	'service_manager' => array(
	),
    'controllers' => array(
    	'invokables' => array(
    		'view-test-controller' => 'ViewTest\Controller\IndexController',
    	),
    ),
    'router' => array(
        'routes' => array(
            'view-test' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/viewtest[/:action][/]',
                    'defaults' => array(
                        'controller'    => 'view-test-controller',
                        'action'        => 'index',
                    ),
                ),
            ),
        ),
    ),
	'view_helpers' => array(
		'invokables' => array(
			'customTest' => 'ViewTest\Helper\CustomTest',
			'altCustomTest' => 'ViewTest\Helper\AltCustomTest',
			// WARNING: this will override "basePath()" system wide!!!
			// Comment it out to revert back to the built in basePath()
//			'basePath'	 => 'ViewTest\Helper\BasePath', 
		),
	),
    'view_manager' => array(
        'template_path_stack' => array(
            'ViewTest' => __DIR__ . '/../view',
        ),
    ),
);
