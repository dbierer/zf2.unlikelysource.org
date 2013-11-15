<?php
return [
    'navigation' => [
        'default' => [
    	   array('label' => 'ZF2F', 'route' => 'zf2f-home', 'order' => 1600),
        ],
    ],
    'controllers' => [
		'factories' => [
			'zf2f-controller-index' => function ($cm) {
				$controller = new Zf2f\Controller\IndexController();
				$controller->config = $cm->getServiceLocator()->get('zf2f-config');
				return $controller;
			},
		],
	],
	'view_helpers' => [
		'invokables' => [
			'listLinks' => 'Zf2f\Helper\ListLinks',
		],
	],
    'view_manager' => [
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ],
	'router' => [
		'routes' => [
			'zf2f-home' => [
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => [
                    'route'    => '/zf2f[/]',
                    'defaults' => [
                        'controller' => 'zf2f-controller-index',
                        'action'     => 'index',
                    ],
                ],
			],
			'zf2f-guest' => [
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => [
                    'route'    => '/zf2f/guest[/]',
                    'defaults' => [
                        'controller' => 'zf2f-controller-index',
                        'action'     => 'guest',
                    ],
                ],
			],
			'zf2f-class' => [
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => [
                    'route'    => '/zf2f/class[/:class]',
                    'defaults' => [
                        'controller' => 'zf2f-controller-index',
                        'action'     => 'class',
                    ],
                ],
			],
			'zf2f-labs' => [
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => [
                    'route'    => '/zf2f/lab[/:what[/:module]][/]',
                    'defaults' => [
                        'controller' => 'zf2f-controller-index',
                        'action'     => 'lab',
                        'what'		 => 'notes',		// notes | solutions
                        'module'	 => 'mod_01',
                    ],
                ],
			],
		],
	],
];