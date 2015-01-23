<?php
namespace FormDemo\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use FormDemo\Form\CityForm;
use FormDemo\Service\TableService;
class TableServiceFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $sm)
    {
        $service = new TableService();
        $service->setCityCodesTable($sm->get('city-codes-table'));
        $service->setListingsTable($sm->get('listings-table'));
        return $service;
    }
}