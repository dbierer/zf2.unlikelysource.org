<?php
namespace FormDemo\Form;
use Zend\Form\Form;
use Zend\Form\Element\Select;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
class EditCityForm extends Form
{ 
    // TODO: need to create corresponding filter class
    public function __construct()
    {
        parent::__construct();
        $this->setAttribute('method', 'POST');

        $city = new Text('city');
        $city->setLabel('City')
             ->setAttribute('maxlength', 64);
        $this->add($city);
        
        $areaCode = new Text('area_code');
        $areaCode->setLabel('Area Code')
             ->setAttribute('maxlength', 6);
        $this->add($areaCode);
        
        $stateProv = new Text('state_province');
        $stateProv->setLabel('State / Province')
                  ->setAttribute('maxlength', 6);
        $this->add($stateProv);
        
        $countrySelect = new Select('ISO2');
        $countrySelect->setLabel('Country')
                   ->setAttribute('id', 'countrySelect')
                   ->setAttribute('placeholder', 'Please enter a country name');
        $this->add($countrySelect);

        $submit = new Submit('submit');
        $submit->setAttribute('value', 'Save');
        $this->add($submit);
        
    }
}