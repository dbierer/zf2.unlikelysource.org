<?php
use Forum\Form\ForumFormFilter;
use Forum\Form\ForumForm;
return [
    'navigation' => [
        'default' => [
    	   array('label' => 'Forum', 'route' => 'forum-home', 'order' => 1300),
        ],
    ],
    'controllers' => [
		'factories' => [
			'forum-controller-index' => 'Forum\Factory\IndexControllerFactory',
			'forum-controller-post' => 'Forum\Factory\PostControllerFactory',
		],
	],
	'service_manager' => [
		'factories' => [
			'forum-table' => 'Forum\Factory\ForumTableFactory',
			'forum-form' => function ($sm) {
				$forumTable = $sm->get('forum-table');
				$form = new ForumForm();
				$form->setInputFilter($sm->get('forum-form-filter'));
    			$form->prepareElements($forumTable->getDistinctTopics(),
    								   $forumTable->getDistinctCategories(),
									   $sm->get('forum-captcha-options'));
				return $form;
			},
			'forum-form-filter' => function ($sm) {
				$filter = new ForumFormFilter();
				$filter->prepareFilters();
				return $filter;
			},
		],
		'services' => [
		    'forum-captcha-options' => [
		    	'expiration' => 300,
		    	'font'		=> __DIR__ . '/../Fonts/FreeSansBold.ttf',
		    	'fontSize'	=> 24,
		    	'height'	=> 50,
		    	'width'		=> 200,
		    	'imgDir'	=> __DIR__ . '/../../public/captcha',
		    	'imgUrl'	=> '/captcha',
		    ],
		],
	],
	'controller_plugins' => [
		'invokables' => [
			'normalizeCategory' => 'Forum\Controller\Plugin\NormalizeCategory',
			'normalizeTopic' => 'Forum\Controller\Plugin\NormalizeTopic',
		]
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
                        'controller' => 'forum-controller-post',
                        'action'     => 'index',
                        'category'	 => 'zf2',
                    ],
                ],
			],
			'forum-edit' => [
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => [
                    'route'    => '/forum/edit[/:id]',
                    'defaults' => [
                        'controller' => 'forum-controller-post',
                        'action'     => 'edit',
                        'id'	 	 => 0,
                    ],
                ],
			],
			'forum-delete' => [
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => [
                    'route'    => '/forum/delete[/:id]',
                    'defaults' => [
                        'controller' => 'forum-controller-post',
                        'action'     => 'delete',
                        'id'	 	 => 0,
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