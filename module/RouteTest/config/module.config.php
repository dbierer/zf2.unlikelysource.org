<?php
return [
	'controllers' => [
		'invokables' => [
			'route-test-controller-index' => 'RouteTest\Controller\IndexController',
		],
	],
	'router' => [
		'routes' => [
			'route-test-home' => [
				'type' => 'Zend\Mvc\Router\Http\Segment',
				'options' => [
					'route'    => '/route-test[/]',
					'defaults' => [
						'controller' => 'route-test-controller-index',
						'action'     => 'index',
					],
				],
			],
			'route-test-method-post' => [
				'type' => 'Zend\Mvc\Router\Http\Literal',
				'options' => [
					'route'    => '/route-test-post',
					'defaults' => [
						'controller' => 'route-test-controller-index',
						'action'     => 'method-post',
					],
				],
				'may_terminate' => true,
				'child_routes'  => [
					'type' => 'Zend\Mvc\Router\Http\Method',
					'options' => [
						'verb'    => 'post',
						'defaults' => [
							'controller' => 'route-test-controller-index',
							'action'     => 'method-post',
						],
					],
				],
			],
			'route-test-wildcard' => [
				'type' => 'Zend\Mvc\Router\Http\Literal',
				'options' => [
					'route'    => '/route-test-wildcard',
					'defaults' => [
						'controller' => 'route-test-controller-index',
						'action'     => 'wildcard',
					],
				],
				'may_terminate' => true,
				'child_routes'  => [
					'wildcard' => [
						'type' => 'Zend\Mvc\Router\Http\Wildcard',
					],
				],
			],
			'route-test-query' => [
				'type' => 'Zend\Mvc\Router\Http\Segment',
				'options' => [
					'route'    => '/route-test-query[/:a]',
					'defaults' => [
						'controller' => 'route-test-controller-index',
						'action'     => 'query',
					],
				],
				'may_terminate' => true,
				'child_routes'  => [
					'query' => [
						'type' => 'Query',
					],
				],
			],
			'route-test-hostname' => [
				'type' => 'Zend\Mvc\Router\Http\Hostname',
				'options' => [
					'route'    => 'route-test.unlikelysource.local',
					'defaults' => [
						'controller' => 'route-test-controller-index',
						'action'     => 'hostname',
					],
				],
			],
		],
	],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];