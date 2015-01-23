<?php
// NOTE: you can check to see if a user is logged in as follows:
//       From a controller: if ($this->loggedIn()) { // OK }
//       From inside a view template: if ($this->loggedIn()) { // OK }
return array(
    'controllers' => array(
        'invokables' => array(
            'simple-auth-controller-index' => 'SimpleAuth\Controller\IndexController',
        ),
    ),
	'controller_plugins' => array(
		'invokables' => array(
        	'loggedIn' => 'SimpleAuth\Plugin\LoggedInControllerPlugin',
		),
    ),
	'view_helpers' => array(
        'invokables' => array(
			'loggedIn' => 'SimpleAuth\Plugin\LoggedInViewHelper',
		),
    ),
	'service_manager' => array(
		'invokables' => array(
			'simple-auth-login-filter' => 'SimpleAuth\Form\LoginFilter'
		),
		'factories' => array(
			'simple-auth-login-form' => function ($sm) {
				$form = new SimpleAuth\Form\LoginForm();
				$form->prepareElements($sm->get('simple-auth-captcha-options'));
				$form->setInputFilter($sm->get('simple-auth-login-filter'));
				return $form;
			},
			'simple-auth-session' => function ($sm) {
				return new Zend\Session\Container('simpleAuth');
			},
		),
	),
	'router' => array(
        'routes' => array(
            'simple-auth-login' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/login',
                    'defaults' => array(
                        'controller'    => 'simple-auth-controller-index',
                        'action'        => 'login',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'SimpleAuth' => __DIR__ . '/../view',
        ),
    ),
);
