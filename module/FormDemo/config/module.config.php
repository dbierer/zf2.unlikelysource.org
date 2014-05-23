<?php
return array(
    'navigation' => array(
        'default' => array(
    	   array('label' => 'Forms', 'route' => 'form-demo', 'order' => 1800),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'form-demo-controller-index' => 'FormDemo\Controller\IndexController',
            'form-demo-controller-annotation' => 'FormDemo\Controller\AnnotationController',
            'form-demo-controller-jquery' => 'FormDemo\Controller\JqueryController',
            'form-demo-controller-application' => 'FormDemo\Controller\ApplicationController',
            'form-demo-controller-report' => 'FormDemo\Controller\ReportController',
            'form-demo-controller-drop-downs' => 'FormDemo\Controller\DropDownsController',
        ),
    ),
    'service_manager' => array(
        'invokables' => array(
            'form-demo-listings-entity' => 'FormDemo\Entity\ListingsEntity',    	
        ),
        'factories' => array(
            'form-demo-drop-downs-edit-city-form'   => 'FormDemo\Factory\EditCityFormFactory',
            'form-demo-drop-downs-city-select-form' => 'FormDemo\Factory\CityFormFactory',
            'form-demo-table-service'               => 'FormDemo\Factory\TableServiceFactory',
        ),
        'services' => array(
    		'form-demo-categories' => array(
				'barter',
				'beauty',
				'clothing',
				'computer',
				'entertainment',
				'free',
				'garden',
				'general',
				'health',
				'household',
				'phones',
				'property',
				'sporting',
				'tools',
				'transportation',
				'wanted',
			),
        ),
    ),
    'router' => array(
        'routes' => array(
            'form-demo' => array(
                'type'    => 'Literal',
                'options' => array(
                    // Change this to something specific to your module
                    'route'    => '/form-demo',
                    'defaults' => array(
                        'module'        => 'form-demo',
                        'controller'    => 'form-demo-controller-index',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/default[/:action]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'controller'    => 'form-demo-controller-index',
                                'action'        => 'index',
                            ),
                        ),
                    ),
                    'annotation' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/annotation[/:action]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'controller'    => 'form-demo-controller-annotation',
                                'action'        => 'index',
                            ),
                        ),
                    ),
                    'jquery' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/jquery[/:action]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'controller'    => 'form-demo-controller-jquery',
                                'action'        => 'index',
                            ),
                        ),
                    ),
                    'pdf' => array(
                        'type' => 'Zend\Mvc\Router\Http\Segment',
                        'options' => array(
                            'route'    => '/pdf[/:iso2]',
                            'defaults' => array(
                                'controller' => 'form-demo-controller-application',
                                'action'     => 'pdf',
                            ),
                            'constraints' => array(
                                'iso2' => '[A-Z]{2}',
                            ),
                        ),
                    ),
                    'country' => array(
                        'type' => 'Zend\Mvc\Router\Http\Literal',
                        'options' => array(
                            'route'    => '/country',
                            'defaults' => array(
                                'controller' => 'form-demo-controller-application',
                                'action'     => 'country',
                            ),
                        ),
                    ),
                    'reports' => array(
                        'type' => 'Zend\Mvc\Router\Http\Segment',
                        'options' => array(
                            'route'    => '/reports[/:action]',
                            'defaults' => array(
                                'controller' => 'form-demo-controller-report',
                                'action'     => 'index',
                            ),
                        ),
                    ),
                    'drop-downs' => array(
                        'type' => 'Zend\Mvc\Router\Http\Segment',
                        'options' => array(
                            'route'    => '/drop-downs[/:action]',
                            'defaults' => array(
                                'controller' => 'form-demo-controller-drop-downs',
                                'action'     => 'index',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_map' => array(
            'layout/form-demo'        => __DIR__ . '/../view/layout/cyborg_layout.phtml',
        ),
        'template_path_stack' => array(
            'FormDemo' => __DIR__ . '/../view',
        ),
    ),
);
