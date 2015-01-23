<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return array(
    'navigation' => array(
        'default' => array(
    	   array('label' => 'Home', 'route' => 'home', 'order' => 1),
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'translator' => 'Zend\I18n\Translator\TranslatorServiceFactory',
            'navigation-main-menu' => 'Zend\Navigation\Service\DefaultNavigationFactory',
            'navigation-left-col' => function ($sm) {
                $factory = new Zend\Navigation\Service\ConstructedNavigationFactory($sm->get('navigation-config-left-col'));
                return $factory->createService($sm);
            },
        ),
        'services' => array(
           'application-test' => array(1,2,3),
    	   'navigation-config-left-col' => array(
    	       array('label' => 'login', 'route' => 'zfcuser','order' => 100),
    	       array('label' => 'zf1', 'uri' => 'http://zf.unlikelysource.net','order' => 200),
    	       array('label' => 'joomla', 'uri' => 'http://joomla.unlikelysource.org/','order' => 300),
    	       array('label' => 'unlikelysource', 'uri' => 'http://unlikelysource.com/','order' => 400),
    	       array('label' => 'zend', 'uri' => 'http://packages.zendframework.com/','order' => 500),
    	   ),
        ),
    ),
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'application-controller-index',
                        'action'     => 'index',
                    ),
                ),
            ),
        	// The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /application/:controller/:action
            'application' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/application',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),
            ),
            'application-login' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/login',
                    'defaults' => array(
                        'controller' => 'application-controller-login',
                        'action'     => 'user',
                    ),
                ),
            ),
        ),
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'application-controller-index' => 'Application\Controller\IndexController',
            'application-controller-login' => 'Application\Controller\LoginController'
        ),
    ),
    'view_helpers' => array(
    	'invokables' => array(
    		'elementToRow' 		=> 'Application\Helper\ElementToRow',
    		'radioElementToRow' => 'Application\Helper\RadioElementToRow',
    		'fileElementToRow' 	=> 'Application\Helper\FileElementToRow',
    		'leftLinks' 		=> 'Application\Helper\LeftLinks',
	    ),
    ),
    'view_manager' => array(
    	'strategies' => array('ViewJsonStrategy'),
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);
