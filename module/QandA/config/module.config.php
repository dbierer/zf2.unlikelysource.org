<?php
return array(
    'navigation' => array(
        'default' => array(
    	   array('label' => 'Q & A', 'route' => 'q-and-a', 'resource' => 'qanda', 'order' => 99999),
        ),
    ),
    'controllers' => array(
        'factories' => array(
            'q-and-a-controller-index' => 'QandA\Controller\IndexControllerFactory',
        ),
    ),
    'service_manager' => array(
        'invokables' => array(
    	   'q-and-a-search-filter' => 'QandA\Form\SearchFilter',
        ),
        'factories' => array(
            'q-and-a-search-form' => function ($sm) {
                $form = new QandA\Form\SearchForm();
                $form->setInputFilter($sm->get('q-and-a-search-filter'));
                return $form;
            },
        ),
    ),
    'router' => array(
        'routes' => array(
            'q-and-a' => array(
                'type'    => 'Segment',
                'options' => array(
                    // Change this to something specific to your module
                    'route'    => '/q-and-a[/:page]',
                    'defaults' => array(
                        'module'        => 'QandA',
                        'controller'    => 'q-and-a-controller-index',
                        'action'        => 'index',
                    ),
                ),
            ),
            'q-and-a-ans' => array(
                'type'    => 'Segment',
                'options' => array(
                    // Change this to something specific to your module
                    'route'    => '/q-and-a/ans[/:question][/:page]',
                    'defaults' => array(
                        'module'        => 'QandA',
                        'controller'    => 'q-and-a-controller-index',
                        'action'        => 'answer',
                    ),
                ),
            ),
            'q-and-a-search' => array(
                'type'    => 'Segment',
                'options' => array(
                    // Change this to something specific to your module
                    'route'    => '/q-and-a/search[/]',
                    'defaults' => array(
                        'module'        => 'QandA',
                        'controller'    => 'q-and-a-controller-index',
                        'action'        => 'search',
                    ),
                ),
            ),
            'q-and-a-continue' => array(
                'type'    => 'Segment',
                'options' => array(
                    // Change this to something specific to your module
                    'route'    => '/q-and-a/continue[/:page]',
                    'defaults' => array(
                        'module'        => 'QandA',
                        'controller'    => 'q-and-a-controller-index',
                        'action'        => 'continue',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'QandA' => __DIR__ . '/../view',
        ),
    ),
);
