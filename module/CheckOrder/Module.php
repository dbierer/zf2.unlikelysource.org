<?php
namespace CheckOrder;
use CheckOrder\Entity\Storage;

class Module
{
	public function init($mm)
	{
		Storage::$order[] = '======== CheckOrder\Module::init() ===========================';
		Storage::$order[] = '....Param: ' . get_class($mm);
        $eventManager = $mm->getEventManager();
	    $eventManager->attach('loadModules.post', array($this, 'onLoadModulesPostFromInit'));
	    $eventManager->attach('dispatch', array($this, 'onDispatchFromInit'));
	    $sharedEventManager = $eventManager->getSharedManager();
	    $sharedEventManager->attach('sharedInit1', 'loadModules.post', function ($e) { 
			Storage::$order[] = '....------------ CheckOrder\Module::onLoadModulesPostFromInitShared() -------------------';
			Storage::$order[] = '....Param: ' . get_class($e);
		    });
	    $sharedEventManager->attach('sharedInit2', 'dispatch', function ($e) {
	    	Storage::$order[] = '....------------ CheckOrder\Module::onLoadModulesPostFromInitShared() -------------------';
	    	Storage::$order[] = '....Param: ' . get_class($e);
		    });
	}
	public function onBootstrap($e)
	{
		Storage::$order[] = '======== CheckOrder\Module::onBootstrap() ===================';
		Storage::$order[] = '....Param: ' . get_class($e);
        $eventManager = $e->getApplication()->getEventManager();
	    $eventManager->attach('loadModules.post', array($this, 'onLoadModulesPostFromBootstrap'));
        $eventManager->attach('dispatch', array($this, 'onDispatchFromBootstrap'));
	    $sharedEventManager = $eventManager->getSharedManager();
	    $sharedEventManager->attach('sharedOnBootstrap1', 'loadModules.post', function ($e) {
			Storage::$order[] = '....------------ CheckOrder\Module::onLoadModulesPostFromBootstrapShared() -------------------';
			Storage::$order[] = '....Param: ' . get_class($e);
		    });
	    $sharedEventManager->attach('sharedOnBootstrap2', 'dispatch', function ($e) {
			Storage::$order[] = '....------------ CheckOrder\Module::onDispatchFromBootstrapShared() -------------------';
			Storage::$order[] = '....Param: ' . get_class($e);
		    });
	}
	
	public function onLoadModulesPostFromInit($e)
	{
		Storage::$order[] = '....------------ CheckOrder\Module::onLoadModulesPostFromInit() -------------------';
		Storage::$order[] = '....Param: ' . get_class($e);
	}
	
	public function onDispatchFromInit($e)
	{
		Storage::$order[] = '....------------ CheckOrder\Module::onDispatchFromInit() -------------------';
		Storage::$order[] = '....Param: ' . get_class($e);
	}
	
	public function onLoadModulesPostFromBootstrap($e)
	{
		Storage::$order[] = '....------------ CheckOrder\Module::onLoadModulesPostFromBootstrap() -------------------';
		Storage::$order[] = '....Param: ' . get_class($e);
	}
	
	public function onDispatchFromBootstrap($e)
	{
		Storage::$order[] = '....------------ CheckOrder\Module::onDispatchFromBootstrap() -------------------';
		Storage::$order[] = '....Param: ' . get_class($e);
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
