<?php
namespace ViewTest;
use Zend\View\Strategy\JsonStrategy;

use ViewTest\Entity\Storage;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    public function onBootstrap($e)
    {
        $app = $e->getTarget();		// returns a Zend\Mvc\Application instance 
        $app->getEventManager()->attach('render', array($this, 'onRender'), -100);
		Storage::$order[] = 'onBootstrap() $e->getTarget(): ' . get_class($app);
    }

    public function onRender($e)
    {
        $app = $e->getTarget();			// returns a Zend\Mvc\Application instance
        $sm = $app->getServiceManager();
        $view     = $sm->get('View');	// returns a Zend\View\View instance
        
        // NOTE: use this technique if you want a *custom* rendering strategy
        $view->addRenderingStrategy(array($this, 'onRenderer'), 90);
        $view->addResponseStrategy(array($this, 'onResponse'), 90);
        
        // NOTE: use this if you only want to add pre-defined rendering strategies
        $jsonStrategy = $sm->get('ViewJsonStrategy');
        $view->getEventManager()->attach($jsonStrategy, 100);
        
        // NOTE: alternative approach, in module.config.php:
		// 'view_manager' => [ 'strategies' => [ 'ViewJsonStrategy', 'ViewFeedStrategy', etc. ], ]
		
        Storage::$order[] = 'onRoutePost() $e->getTarget(): ' . get_class($app);
        Storage::$order[] = 'onRoutePost() View: ' . get_class($view);
        
    }

    public function onRenderer(\Zend\View\ViewEvent $e)
    {
        /* ... */
    }

    public function onResponse(\Zend\View\ViewEvent $e)
    {
        /* ... */
    }

}
