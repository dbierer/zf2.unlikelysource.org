<?php
namespace RouteTest;
use RouteTest\Entity\Storage;
use Zend\ModuleManager\Feature\RouteProviderInterface;

class Module implements RouteProviderInterface
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
        	'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    /**
     * STILL NOT WORKING!!!
     * @see \Zend\ModuleManager\Feature\RouteProviderInterface::getRouteConfig()
     */
    public function getRouteConfig()
    {
        return array(
        	'routes' => [
        	   'routetest-module-test' => [
                    'type' => 'Zend\Mvc\Router\Http\Segment',
                    'options' => [
                        'route'    => '/routetest-module-test[/]',
                        'defaults' => [
                            'controller' => 'routetest-controller-index',
                            'action'     => 'module-test',
                        ],
                    ],
                ],
            ],
        );
    }
    public function onRoute()
    {
    	Storage::$value[] = 'onRoute';
    }
    public function onDispatch()
    {
    	Storage::$value[] = 'onDispatch';
    }
    public function onRender()
    {
    	Storage::$value[] = 'onRender';
    }
}
