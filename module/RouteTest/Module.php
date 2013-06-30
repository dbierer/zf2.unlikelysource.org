<?php
namespace RouteTest;
use RouteTest\Entity\Storage;

class Module
{
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
    
    public function onRoute()
    {
    	Storage::$value[] = 'onRoute';
    }
    public function onDispatch()
    {
    	Storage::$value[] = 'onDispatch';
    }
    public function onRender()
    {
    	Storage::$value[] = 'onRender';
    }
}
