<?php
namespace ServiceManagerDemo\Factory;

use ServiceManagerDemo\Model\DemoModel;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;

class DemoFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $sm)
    {
        $model = new DemoModel();
        $model->setControl('INJECTED BY ' . __CLASS__);
        $model->setTest('INJECTED BY ' . __CLASS__);
        $model->setOutput('FACTORY CALLED: ' . date('Y-m-d H:i:s') . ' ' . microtime());
        return $model;
    }
}
