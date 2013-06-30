<?php
namespace Forum;

class Module
{
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
    
    // Does the same thing as the "controllers" key in module.config.php
    /*
    public function getControllerConfig()
    {
    	return array(
			'factories' => array(
				'forum-controller-index' => 'Forum\Factory\IndexControllerFactory',
				'forum-controller-post' => 'Forum\Factory\PostControllerFactory',
			),
    	);
    }
    */
    
}
