<?php
namespace FormDemo\Form;
use Zend\Form\Form;
use Zend\Form\Element;

class CityForm extends Form
{
    public function __construct()
    {
        parent::__construct();
        $this->setAttribute('method', 'POST');

        // from the form factory:
        // initially populated with a list of countries
        $countrySelect = new Element\Select('countrySelect');
        $countrySelect->setLabel('Country')
                   ->setAttribute('id', 'countrySelect')
                   ->setAttribute('placeholder', 'Please enter a country name');
        $this->add($countrySelect);

        // from the form factory:
        // initially populated with a list of cities from the 1st country on the list
        $cityName = new Element\Select('cityName');
        $cityName->setAttribute('id', 'cityName')
                 ->setLabel('City Name');
        $this->add($cityName);

        // NOTE: 
        // 1. must set DOCTYPE to HTML5: <!DOCTYPE html>
        // 2. not consistently supported by all browsers
        // 3. need to run isValid() to see any results
        $range = new Element\Range('range');
        $range->setLabel('Range')
              ->setAttributes(array(
        		'min'  => '0',   // default minimum is 0
        		'max'  => '100', // default maximum is 100
        		'step' => '1',   // default interval is 1
        		// this is a new HTML5 attribute:
        		'required' => 'required',
                'onClick'  => 'displayNumber(this.value)',
                'onBlur'   => 'displayNumber(this.value)',
                'style'    => 'width: 100px',
        ));       
        $this->add($range);
        
        $rangeText = new Element\Text('rangeText');
        $rangeText->setAttribute('id', 'rangeText')
                  ->setAttribute('style', 'width: 30px; background-color: gray; color: white')
                  ->setAttribute('value', 50);
        $this->add($rangeText);

        $phone = new Element\Text('phone');
        $phone->setLabel('Phone')
                   ->setAttribute('id', 'phone')
        		   ->setAttribute('type', 'text')
        		   ->setAttribute('pattern', '^[0-9-()]+$')
        		   ->setAttribute('title', 'Phone number')
        		   ->setAttribute('placeholder', 'Enter phone numbers');
        $this->add($phone);
        
        $required = new Element\Text('required');
        $required->setLabel('Type Something')
                   ->setAttribute('id', 'required')
        		   ->setAttribute('required', 'required')
        		   ->setAttribute('pattern', '[0-9A-Z ]+')
        		   ->setAttribute('title', 'Must enter letters, numbers or spaces only')
        		   ->setAttribute('placeholder', 'required field');
        $this->add($required);

        $citySelect = new Element\Text('citySelect');
        $citySelect->setLabel('Search City')
                   ->setAttribute('id', 'citySelect')
                   ->setAttribute('placeholder', 'Please enter a city name');
        $this->add($citySelect);

        $submit = new Element\Submit('submit');
        $submit->setAttribute('value', 'Choose');
        $this->add($submit);
        
    }
}