<?php

namespace QandA\Controller;

use QandA\Controller\IndexController;
use QandA\Model\Data;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class IndexControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $controllers)
    {
        $sm = $controllers->getServiceLocator();
        $controller = new IndexController();
        $controller->data = new Data($sm->get('Config'));
        return $controller;
    }
}
