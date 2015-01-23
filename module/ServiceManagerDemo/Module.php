<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ServiceManagerDemo for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace ServiceManagerDemo;

use ServiceManagerDemo\Model\DemoModel;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module implements AutoloaderProviderInterface
{
    public function getAutoloaderConfig()
    {
        return array('Zend\Loader\ClassMapAutoloader' => array(__DIR__ . '/autoload_classmap.php'));
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function onBootstrap(MvcEvent $e)
    {
        // You may not need to do this if you're doing it elsewhere in your
        // application
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    public function getServiceConfig()
    {
        return array(
            'invokables' => array(
                'service-manager-demo-delegator-factory' => 'ServiceManagerDemo\Factory\DelegatorDemoFactory',
            ),
            'factories' => array(
                'service-manager-demo-model' => 'ServiceManagerDemo\Factory\DemoModelFactory',
            ),
            'initializers' => array(
                'service-manager-demo-example-initializer' =>
                    function ($instance, $sm) {
                        $demoModel = $sm->get('service-manager-demo-model');
                        if (is_object($instance)) {
                            $demoModel->setOutput('Initializer Called for: ' . get_class($instance));
                        } else {
                            echo 'Initializer Called for: non-object data type';
                        }
                    },
            ),
            'delegators' => array(
                'service-manager-demo-model' => array('service-manager-demo-delegator-factory'),
            ),
        );
    }
}
