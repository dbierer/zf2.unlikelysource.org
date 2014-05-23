<?php
namespace FormDemo\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use FormDemo\Form\EditCityForm;
class EditCityFormFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $sm)
    {
        $form = new EditCityForm();
        $table = $sm->get('city-codes-table');
        $form->get('ISO2')->setValueOptions($table->getCountries());
        // TODO: get filter from service manager
        // TODO: assign filter to form using $form->setInputFilter()
        return $form;
    }
}