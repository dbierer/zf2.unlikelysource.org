<?php

namespace Forum\Factory;

use Forum\Controller\IndexController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class IndexControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $controllers)
    {
        $allServices = $controllers->getServiceLocator();
        $sm = $allServices->get('ServiceManager');
        $controller = new IndexController();
        $controller->forumTable 	 = $sm->get('forum-table');
        $controller->forumCatList	 = $controller->forumTable->getDistinctCategories();
        return $controller;
    }
}
