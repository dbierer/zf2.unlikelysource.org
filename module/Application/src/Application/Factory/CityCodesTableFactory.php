<?php
namespace Application\Factory;

use Application\Model\CityCodesTable;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\Adapter\Adapter;

class CityCodesTableFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $sm)
    {
        $model = new CityCodesTable();
        $model->setAdapter($sm->get('general-adapter'));
        $model->setTableGateway();
        return $model;
    }
}
