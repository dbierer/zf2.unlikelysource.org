<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
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
    'service_manager' => array(
        'factories' => array(
            'translator' => 'Zend\I18n\Translator\TranslatorServiceFactory',
        ),
        'services' => array(
        	'application-template-params' => array(
				'margin' 			=> 30,
				'outermargin' 		=> 0,
				'title' 			=> 'zf2.unlikelysource.org',
				'logoText' 			=> 'zf2.unlikelysource.org',
				'slogan'			=> '',
				'logo'				=> '<img src="http://www.unlikelysource.com/assets/images/zf-zce-logo.gif" />',
				'banner'			=> '',
				'pageWidth'			=> 960,
				'rightColumnWidth'	=> 190,
				'leftColumnWidth'	=> 190,
				'logoWidth'			=> 500,
				'removeBanner' 		=> true,
				'searchWidth' 		=> 170,
				'searchHeight' 		=> 33,
				'showLeftColumn' 	=> true,
				'showRightColumn' 	=> true,
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
            'Application\Controller\Index' => 'Application\Controller\IndexController',
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
