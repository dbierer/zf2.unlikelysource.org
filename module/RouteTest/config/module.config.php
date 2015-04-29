<?php
return [
    'navigation' => [
        'default' => [
    	   array('label' => 'RouteTest', 'route' => 'routetest-home', 'resource' => 'routetest', 'order' => 1400),
        ],
    ],
    'controllers' => [
		'invokables' => [
			'routetest-controller-index' => 'RouteTest\Controller\IndexController',
			'routetest-controller-console-test' => 'RouteTest\Controller\ConsoleTestController',
        ],
	],
	'console' => [
        'router' => [
            'routes' => [
                'route-test-console' => [
                	'type' => 'Simple',
                    'options' => [
                        'route'    => 'console <id> <test1> <test2>',
                        'defaults' => [
                            'controller' => 'routetest-controller-console-test',
                            'action'     => 'index',
                        ],
                    ],
                ],
            ],
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
			'routetest-module-redirect' => [
				'type' => 'Zend\Mvc\Router\Http\Segment',
				'options' => [
					'route'    => '/route-test/module[/]',
					'defaults' => [
						'controller' => 'routetest-controller-index',
						// NOTE: there is no action called "module"
						'action'     => 'module',
					],
				],
			],
			// NOTE: this block is also a "Part" route
			'routetest-method-test' => [
				'type' => 'Zend\Mvc\Router\Http\Literal',
				'options' => [
					'route'    => '/route-test/method',
					'defaults' => [
						'controller' => 'routetest-controller-index',
						'action'     => 'index',
					],
				],
				// NOTE: you *must* set this to FALSE, otherwise method will not be evaluated
				'may_terminate' => FALSE,
				'child_routes'  => [
				    'routetest-method-post-child-1' => [
    					'type' => 'Zend\Mvc\Router\Http\Method',
    					'options' => [
    						'verb'    => 'get',
    						'defaults' => [
    							'action'     => 'get-method',
    						],
    					],
    				],
				    'routetest-method-post-child-2' => [
    					'type' => 'Zend\Mvc\Router\Http\Method',
    					'options' => [
    						'verb'    => 'post',
    						'defaults' => [
    							'action'     => 'post-method',
    						],
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
					'wildcard-key' => [
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
