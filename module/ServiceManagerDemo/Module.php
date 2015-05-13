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
use ServiceManagerDemo\Factory\DontInitializeMe;

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
            'services' => array(
                'service-manager-demo-logfile' => __DIR__ . '/../../data/logs/service-manager-demo.log',
            ),
            'invokables' => array(
                // see http://framework.zend.com/manual/2.2/en/modules/zend.service-manager.delegator-factories.html
                'service-manager-demo-delegator-factory' => 'ServiceManagerDemo\Factory\DelegatorDemoFactory',
            ),
            'factories' => array(
                'service-manager-demo-model' => 'ServiceManagerDemo\Factory\DemoFactory',
                /*
                'service-manager-demo-model' => function ($sm) {
                    $model = new DemoModel();
                    $model->setControl('INJECTED BY ' . __CLASS__);
                    $model->setTest('INJECTED BY ' . __CLASS__);
                    $model->setOutput('FACTORY CALLED: ' . date('Y-m-d H:i:s') . ' ' . microtime());
                    return $model;
                },
                */
            ),
            'abstract_factories' => array(
                'service-manager-demo-logfactory' => 'ServiceManagerDemo\Factory\DemoAbstractFactory',
            ),
            'initializers' => array(
                'service-manager-demo-example-initializer' =>
                    function ($instance, $sm) {
                        $log = $sm->get('service-manager-demo-logfile');
                        $this->logInfo($log, $instance, 'SERVICE');
                    },
            ),
            'delegators' => array(
                // NOTE: delegator key = an existing service manager key
                //       the value = an array() even if only 1 delegator factory
                'service-manager-demo-model' => array('service-manager-demo-delegator-factory'),
            ),
        );
    }
    
    public function getControllerConfig()
    {
        return array(
            'initializers' => array(
                'service-manager-demo-test-controller-initializer' => function ($instance, $cm) {
                    $log = $cm->getServiceLocator()->get('service-manager-demo-logfile');
                    $this->logInfo($log, $instance, 'CONTROLLER');
                },
            ),
        );
    }
    
    protected function logInfo($log, $instance, $type)
    {
        $message = 'INITIALIZER: ' . $type . ': ';
        if (is_object($instance)) {
            $message .= get_class($instance) . PHP_EOL;
        } elseif (is_string($instance)) {
            $message .= 'non-object data type' . PHP_EOL;
        } else {
            $message .= 'unknown data type' . PHP_EOL;
        }
        error_log($message, 3, $log);
    }
}
