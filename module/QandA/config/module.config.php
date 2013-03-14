<?php
return [
	'controllers' => [
		'invokables' => [
			'qanda-controller-admin' => 'QandA\Controller\AdminController',
		],
	],
	'router' => [
		'routes' => [
			'admin-home' => [
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => [
                    'route'    => '/admin[/]',
                    'defaults' => [
                        'controller' => 'qanda-controller-admin',
                        'action'     => 'index',
                    ],
                ],
			]
		],
	],
    'view_manager' => [
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ],
];