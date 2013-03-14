<?php

namespace QandA\Factory;

use QandA\Controller\AdminController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AdminControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $controllerManager)
    {
        $allServices = $controllerManager->getServiceLocator();
        $sm = $allServices->get('ServiceManager');
        $controller = new AdminController();
        $controller->zfcUserAuth = $sm->get('zfcUserAuthentication');
        return $controller;
    }
}
