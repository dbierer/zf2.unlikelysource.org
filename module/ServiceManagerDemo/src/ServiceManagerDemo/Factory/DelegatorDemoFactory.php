<?php
namespace ServiceManagerDemo\Factory;

use ServiceManagerDemo\Service\DelegatorDemoService;
use Zend\ServiceManager\DelegatorFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class DelegatorDemoFactory implements DelegatorFactoryInterface
{
	public function createDelegatorWithName(ServiceLocatorInterface $sm, $name, $requestedName, $callback)
	{
		$realBuzzer   = call_user_func($callback);
		$eventManager = $sm->get('EventManager');

		$eventManager->attach('buzz', function () { echo "Stare at the art!\n"; });

		return new DelegatorDemoService($realBuzzer, $eventManager);
	}
}