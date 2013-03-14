<?php
use ClassFile\Form\ClassFormFilter;
use ClassFile\Form\ClassForm;
return [
	'controllers' => [
		'factories' => [
			'classfile-controller-index' => 'ClassFile\Factory\IndexControllerFactory',
		],
	],
	'service_manager' => [
		'factories' => [
			'classfile-table' => 'ClassFile\Factory\ClassFileTableFactory',
			'classfile-form' => function ($e) { 
				$form = new ClassForm();
				$form->prepareElements();
				return $form;
			},
			'classfile-form-filter' => function ($e) { 
				$filter = new ClassFormFilter();
				$filter->prepareFilters();
				return $filter;
			},
		],
	],
	'router' => [
		'routes' => [
			'classfile-home' => [
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => [
                    'route'    => '/classfile[/][:file]',
                    'defaults' => [
                        'controller' => 'classfile-controller-index',
                        'action'     => 'index',
                    ],
                ],
			],
			'classfile-class' => [
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => [
                    'route'    => '/for-class[/][:class]',
                    'defaults' => [
                        'controller' => 'classfile-controller-index',
                        'action'     => 'forClass',
                    ],
                ],
			],
			'classfile-post' => [
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => [
                    'route'    => '/post-class[/]',
                    'defaults' => [
                        'controller' => 'classfile-controller-index',
                        'action'     => 'postClass',
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