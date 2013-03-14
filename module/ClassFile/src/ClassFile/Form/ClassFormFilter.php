<?php
namespace ClassFile\Form;

use Zend\InputFilter\Input;
use Zend\Validator;
use Zend\Filter;
use Zend\InputFilter\InputFilter;

class ClassFormFilter extends InputFilter
{
	public function prepareFilters()
	{
		$class = new Input('class');
		$class->getFilterChain()
			 ->attach(new Filter\StringToLower())
			 ->attachByName('StripTags');

		$title = new Input('title');
		$title->getFilterChain()
			 ->attachByName('StripTags')
			 ->attachByName('StringTrim');
		$title->getValidatorChain()
			 ->addByName('NotEmpty')
			 ->addByName('StringLength', array('min' => 1, 'max' => 64, 'encoding' => 'utf-8'));

		$body = new Input('body');
		$body->getFilterChain()
		    ->attachByName('StripTags')
		    ->attachByName('StringTrim');
		$body->getValidatorChain()
		    ->addByName('NotEmpty');
  
		$this->add($class)
			 ->add($title)
			 ->add($body);
	}
} 
