<?php

namespace ClassFile\Factory;

use ClassFile\Controller\IndexController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class IndexControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $controllers)
    {
        $allServices = $controllers->getServiceLocator();
        $sm = $allServices->get('ServiceManager');
        $controller = new IndexController();
        $controller->classFileTable 	 = $sm->get('classfile-table');
        $controller->classFileForm 		 = $sm->get('classfile-form');
        $controller->classFileFormFilter = $sm->get('classfile-form-filter');
        return $controller;
    }
}
