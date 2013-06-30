<?php
namespace CheckOrder;
use Zend\EventManager\EventManager;

use CheckOrder\Entity\Storage;

class Module
{
	public function init($mm)
	{
        $eventManager = $mm->getEventManager();
		Storage::$order[] = '======== CheckOrder\Module::init() ===========================';
		Storage::$order[] = '....Event Manager Param: ' . get_class($mm);
		Storage::$order[] = '....Event Manager Class: ' . get_class($eventManager);
		// This is OK
        $eventManager->attach('loadModules.post', array($this, 'onLoadModulesPostFromInit'));
	    // NOTE: module manager $mm will only handle module events
	    $eventManager->attach('dispatch', array($this, 'onDispatchFromInit'));
	    // attach custom event listener using shared event manager
	    $sharedEventManager = $eventManager->getSharedManager();
	    $sharedEventManager->attach('sharedInit', 'customEventInit', function ($e) { 
			Storage::$order[] = '....------------ CheckOrder\Module::onLoadModulesPostFromInitShared() -------------------';
			Storage::$order[] = '....Param: ' . get_class($e);
		    });
	}
	public function onBootstrap($e)
	{
        $eventManager = $e->getApplication()->getEventManager();
		Storage::$order[] = '======== CheckOrder\Module::onBootstrap() ===================';
		Storage::$order[] = '....Event Manager Param: ' . get_class($e);
		Storage::$order[] = '....Event Manager Class: ' . get_class($eventManager);
		// NOTE: MvcEvent $e will only handle MVC events
	    $eventManager->attach('loadModules.post', array($this, 'onLoadModulesPostFromBootstrap'));
	    // This is OK
        $eventManager->attach('dispatch', array($this, 'onDispatchFromBootstrap'));
	    // attach custom event listener using shared event manager
        $sharedEventManager = $eventManager->getSharedManager();
	    $sharedEventManager->attach('sharedOnBootstrap', 'customEventBootstrap', function ($e) {
			Storage::$order[] = '....------------ CheckOrder\Module::onLoadModulesPostFromBootstrapShared() -------------------';
			Storage::$order[] = '....Param: ' . get_class($e);
		    });
	}
	
	public function onLoadModulesPostFromInit($e)
	{
		Storage::$order[] = '....------------ CheckOrder\Module::onLoadModulesPostFromInit() -------------------';
		Storage::$order[] = '....Param: ' . get_class($e);
		Storage::$order[] = '....Target: ' . get_class($e->getTarget());
		$this->customEvent(__FUNCTION__);
	}
	
	public function onDispatchFromInit($e)
	{
		Storage::$order[] = '....------------ CheckOrder\Module::onDispatchFromInit() -------------------';
		Storage::$order[] = '....Param: ' . get_class($e);
		Storage::$order[] = '....Target: ' . get_class($e->getTarget());
		$this->customEvent(__FUNCTION__);
	}
	
	public function onLoadModulesPostFromBootstrap($e)
	{
		Storage::$order[] = '....------------ CheckOrder\Module::onLoadModulesPostFromBootstrap() -------------------';
		Storage::$order[] = '....Param: ' . get_class($e);
		Storage::$order[] = '....Target: ' . get_class($e->getTarget());
		$this->customEvent(__FUNCTION__);
	}
	
	public function onDispatchFromBootstrap($e)
	{
		Storage::$order[] = '....------------ CheckOrder\Module::onDispatchFromBootstrap() -------------------';
		Storage::$order[] = '....Param: ' . get_class($e);
		Storage::$order[] = '....Target: ' . get_class($e->getTarget());
		$this->customEvent(__FUNCTION__);
	}
	
	private function customEvent($target) 
	{
		$em = new EventManager('sharedInit');
		$em->trigger('customEventInit', $target);
		$em = new EventManager('customEventBootstrap');
		$em->trigger('customEventBootstrap', $target);
	}

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
    
    public function getServiceConfig()
    {
    	return array(
    		'services' => array(
    			// comment out below and re-run http://zf2.unlikelysource.local/check
    			'check-test' => array('key' => 'FROM MODULE.PHP', 'Module.php:' . microtime()),
       		),
    	);
    }
}
