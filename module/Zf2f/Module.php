<?php
namespace Zf2f;

use Zend\Mvc\MvcEvent;

class Module
{
	public function onBootStrap(MvcEvent $e)
	{
		$em = $e->getApplication()->getEventManager();
		$em->attach(MvcEvent::EVENT_DISPATCH, array($this, 'checkAuthentication'), 100);
	}

	public function checkAuthentication(MvcEvent $e)
	{
		$controller = $e->getRouteMatch()->getParam('controller');
		$action = $e->getRouteMatch()->getParam('action');
		if ($controller == 'zf2f-controller-index' && $action != 'guest') {
			$authService = $e->getApplication()->getServiceManager()->get('zfcuser_auth_service');
			if (!$authService->hasIdentity()) {
				$response = $e->getResponse();
				$response->getHeaders()->addHeaderLine('Location: /zf2f/guest');
				$response->setStatusCode(302);
				return $response;
			}
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
}
