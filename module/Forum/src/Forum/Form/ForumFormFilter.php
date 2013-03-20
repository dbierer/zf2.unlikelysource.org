<?php
namespace Forum\Form;

use Zend\InputFilter\Input;
use Zend\Validator;
use Zend\Filter;
use Zend\InputFilter\InputFilter;

class ForumFormFilter extends InputFilter
{
	public function prepareFilters()
	{
		$category = new Input('category');
		$category->getFilterChain()
			 ->attach(new Filter\StringToLower())
			 ->attachByName('StripTags');
		$category->setRequired(FALSE);
		
		$topic = new Input('topic');
		$topic->getFilterChain()
			 ->attach(new Filter\StringToLower())
			 ->attachByName('StripTags');
		$topic->setRequired(FALSE);
		
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
  
		$this->add($category)
			 ->add($topic)
			 ->add($title)
			 ->add($body);
	}
} 
