<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Cache for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace CacheDemo;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Cache\Storage\ExceptionEvent;

class Module implements AutoloaderProviderInterface
{
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
		    // if we're in a namespace deeper than one level we need to fix the \ in the path
                    __NAMESPACE__ => __DIR__ . '/src/' . str_replace('\\', '/' , __NAMESPACE__),
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function onBootstrap(MvcEvent $e)
    {
        // You may not need to do this if you're doing it elsewhere in your
        // application
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        $eventManager->attach('getItem.exception', array($this, 'catchEvents'), 1000);
        $eventManager->attach('getItem.pre', array($this, 'catchEvents'), 1000);
        $sharedManager = $eventManager->getSharedManager();
        $sharedManager->attach('any', 'getItem.exception', array($this, 'catchEvents'), 1000);
        $sharedManager->attach('any', 'getItem.pre', array($this, 'catchEvents'), 1000);
    }
    
    public function catchEvents($e)
    {
        \Zend\Debug\Debug::dump($e);
        exit;
    }
    
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'cache-demo-cache' => function ($sm) {
                    return \Zend\Cache\StorageFactory::factory($sm->get('cache-demo-config'));
                },
            ),
        );
        
    }
}
