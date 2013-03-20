<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\View\Strategy\JsonStrategy;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $e->getApplication()->getServiceManager()->get('translator');
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        //$eventManager->attach('dispatch', array($this, 'onDispatch'), 100);
        // test code matching ZF2F slide 8-12
        //$eventManager->attach('render', array($this, 'registerJsonStrategy'), 100);
    }

    // NOTE: not used right now
	public function onDispatch(MvcEvent $e)
	{
		// get template params
        $templateParams = $e->getApplication()->getServiceManager()->get('application-template-params');
		// get view model
	 	$vm = $e->getViewModel();
	 	// store search info in a variable
	 	$vm->setVariable('templateParams', $templateParams);
	}

    // NOTE: not used right now
	public function registerJsonStrategy(MvcEvent $e)
	{
		$locator = $e->getTarget()->getServiceManager();
		$view = $locator->get('Zend\View\View');
		$jsonStrategy = $locator->get('ViewJsonStrategy');
		$view->getEventManager()->attach($jsonStrategy, 100);
		// NOTE: alternative approach, in module.config.php:
		// 'view_manager' => [ 'strategies' => [ 'ViewJsonStrategy', 'ViewFeedStrategy', etc. ], ]
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
}
