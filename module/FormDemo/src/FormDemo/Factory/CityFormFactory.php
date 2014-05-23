<?php
namespace FormDemo\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use FormDemo\Form\CityForm;
class CityFormFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $sm)
    {
        $form = new CityForm();
        $table = $sm->get('city-codes-table');
        $form->get('countrySelect')->setValueOptions($table->getCountries());
        $form->get('cityName')->setValueOptions($table->getListByFirstCountry());
        return $form;
    }
}