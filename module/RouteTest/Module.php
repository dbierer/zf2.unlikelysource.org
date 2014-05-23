<?php
namespace RouteTest;
use RouteTest\Entity\Storage;
use Zend\ModuleManager\Feature\RouteProviderInterface;
use Zend\Mvc\MvcEvent;

class Module implements RouteProviderInterface
{
    public function onBootstrap(MvcEvent $e)
    {
        $app = $e->getTarget();		// returns a Zend\Mvc\Application instance 
        $app->getEventManager()->attach(MvcEvent::EVENT_DISPATCH, array($this, 'xyRedirect'), 100);
    }
    // shows how you can perform redirection from a listener
    public function xyRedirect(MvcEvent $e)
    {
        // capture action param
        $candidates = array('x','y','z');
        $routeMatch = $e->getRouteMatch();
    	$action = $routeMatch->getParam('action');
		// NOTE: this only works if you code the module name into the service manager controller key
		if ($action === 'module') {
		    $param     = $candidates[rand(0,2)];
		    $newAction = 'module-' . $param;
		    $routeMatch->setParam('action', $newAction);
		    $routeMatch->setParam('redirect', 'REDIRECT ' . $param);
		}	    
    }    
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
