<?php

namespace Forum\Factory;

use Forum\Controller\PostController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class PostControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $controllers)
    {
        $allServices = $controllers->getServiceLocator();
        $sm = $allServices->get('ServiceManager');
        $controller = new PostController();
        $controller->forumTable 	 = $sm->get('forum-table');
        $controller->forumCatList	 = $controller->forumTable->getDistinctCategories();
        $controller->forumForm		 = $sm->get('forum-form');
    	$controller->forumForm->prepareElements($controller->forumTable->getDistinctTopics(), 
    									  		$controller->forumTable->getDistinctCategories());
        return $controller;
    }
}
