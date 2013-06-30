<?php
return [
	'controllers' => [
		'invokables' => [
			'routetest-controller-index' => 'RouteTest\Controller\IndexController',
		],
	],
	'router' => [
		'routes' => [
			'routetest-home' => [
				'type' => 'Zend\Mvc\Router\Http\Segment',
				'options' => [
					'route'    => '/routetest[/]',
					'defaults' => [
						'controller' => 'routetest-controller-index',
						'action'     => 'index',
					],
				],
			],
			'routetest-method-post' => [
				'type' => 'Zend\Mvc\Router\Http\Literal',
				'options' => [
					'route'    => '/routetest-post',
					'defaults' => [
						'controller' => 'routetest-controller-index',
						'action'     => 'method-post',
					],
				],
				'may_terminate' => true,
				'child_routes'  => [
					'type' => 'Zend\Mvc\Router\Http\Method',
					'options' => [
						'verb'    => 'post',
						'defaults' => [
							'controller' => 'routetest-controller-index',
							'action'     => 'method-post',
						],
					],
				],
			],
			'routetest-wildcard' => [
				'type' => 'Zend\Mvc\Router\Http\Literal',
				'options' => [
					'route'    => '/routetest-wildcard',
					'defaults' => [
						'controller' => 'routetest-controller-index',
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
			// NOTE: this route type has been deprecated as of ZF 2.1.4!
			/*
			'routetest-query' => [
				'type' => 'Zend\Mvc\Router\Http\Segment',
				'options' => [
					'route'    => '/routetest-query[/:a]',
					'defaults' => [
						'controller' => 'routetest-controller-index',
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
			*/
			'routetest-hostname' => [
				'type' => 'Zend\Mvc\Router\Http\Hostname',
				'options' => [
					'route'    => 'route-test.unlikelysource.org',
					'defaults' => [
						'controller' => 'routetest-controller-index',
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