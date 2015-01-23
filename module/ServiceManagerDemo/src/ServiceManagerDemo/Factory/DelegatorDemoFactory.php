<?php
namespace ServiceManagerDemo\Factory;

use Zend\ServiceManager\DelegatorFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class DelegatorDemoFactory implements DelegatorFactoryInterface
{
	public function createDelegatorWithName(ServiceLocatorInterface $sm, $name, $requestedName, $callback)
	{
		$model = call_user_func($callback);
		$model->setTest('INJECTED BY ' . __CLASS__);
		return $model;
	}
}