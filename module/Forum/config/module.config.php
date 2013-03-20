<?php
use Forum\Form\ForumFormFilter;
use Forum\Form\ForumForm;
return [
	'controllers' => [
		'factories' => [
			'forum-controller-index' => 'Forum\Factory\IndexControllerFactory',
		],
	],
	'service_manager' => [
		'invokables' => [
			'forum-form' => 'Forum\Form\ForumForm', 
		],
		'factories' => [
			'forum-table' => 'Forum\Factory\ForumTableFactory',
			'forum-form-filter' => function ($e) { 
				$filter = new ForumFormFilter();
				$filter->prepareFilters();
				return $filter;
			},
		],
	],
	'router' => [
		'routes' => [
			'forum-home' => [
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => [
                    'route'    => '/forum[/]',
                    'defaults' => [
                        'controller' => 'forum-controller-index',
                        'action'     => 'index',
                        'category'	 => 'zf2',
                    ],
                ],
			],
			'forum-cat' => [
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => [
                    'route'    => '/forum[/:category]',
                    'defaults' => [
                        'controller' => 'forum-controller-index',
                        'action'     => 'index',
                        'category'	 => 'zf2',
                    ],
                ],
			],
			'forum-topic' => [
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => [
                    'route'    => '/forum/topic[/:category][/:topic]',
                    'defaults' => [
                        'controller' => 'forum-controller-index',
                        'action'     => 'topic',
                    ],
                ],
			],
			'forum-title' => [
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => [
                    'route'    => '/forum/title[/:id]',
                    'defaults' => [
                        'controller' => 'forum-controller-index',
                        'action'     => 'title',
                        'id'		 => 1,
                    ],
                ],
			],
			'forum-post' => [
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => [
                    'route'    => '/forum/post[/:category]',
                    'defaults' => [
                        'controller' => 'forum-controller-index',
                        'action'     => 'post',
                        'category'	 => 'zf2',
                    ],
                ],
			],
		],
	],
    'view_manager' => [
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ],
];