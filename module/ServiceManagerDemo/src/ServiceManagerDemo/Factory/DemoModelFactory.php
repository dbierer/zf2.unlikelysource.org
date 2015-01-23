<?php
namespace ServiceManagerDemo\Factory;

use ServiceManagerDemo\Model\DemoModel;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class DemoModelFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $sm)
    {
        $model = new DemoModel();
        $model->setControl('INJECTED BY ' . __CLASS__);
        $model->setTest('INJECTED BY ' . __CLASS__);
        return $model;
    }
}
