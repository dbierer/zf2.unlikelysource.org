<?php
namespace ViewTest;
use Zend\Mvc\MvcEvent;
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
    public function onBootstrap(MvcEvent $e)
    {
        $app = $e->getTarget();		// returns a Zend\Mvc\Application instance 
        $app->getEventManager()->attach(MvcEvent::EVENT_DISPATCH, array($this, 'onDispatch'), 100);
        $app->getEventManager()->attach(MvcEvent::EVENT_RENDER, array($this, 'onRender'), -100);
        Storage::$order[] = 'onBootstrap() $e->getTarget(): ' . get_class($app);
    }
    
    public function onDispatch(MvcEvent $e)
    {
        // alternate layout
    	$controller = $e->getRouteMatch()->getParam('controller');
		// NOTE: this only works if you code the module name into the service manager controller key
		if (stripos($controller, 'view-test') === 0) {
			$layout = $e->getViewModel();
			$layout->setTemplate('layout/view-test-layout');
		}
    }
    
    public function onRender(MvcEvent $e)
    {
        $app 	= $e->getTarget();			// returns a Zend\Mvc\Application instance
        $sm 	= $app->getServiceManager();
        $view   = $sm->get('View');	// returns a Zend\View\View instance
        
        // NOTE: use this technique if you want a *custom* rendering strategy
        $view->addRenderingStrategy(array($this, 'onRenderer'), 90);
        $view->addResponseStrategy(array($this, 'onResponse'), 90);
        
        // NOTE: use this if you only want to add pre-defined rendering strategies
        // 		 alternative approach, in module.config.php:
		// 		 'view_manager' => [ 'strategies' => [ 'ViewJsonStrategy', 'ViewFeedStrategy', etc. ], ]
        $jsonStrategy = $sm->get('ViewJsonStrategy');
        $view->getEventManager()->attach($jsonStrategy, 100);

        Storage::$order[] = 'onRender() $e->getTarget(): ' . get_class($app);
        Storage::$order[] = 'onRender() View: ' . get_class($view);
        
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
