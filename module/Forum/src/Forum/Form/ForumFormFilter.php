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
		$author = new Input('author');
		$author->getFilterChain()
			   ->attachByName('StripTags')
			   ->attachByName('StringTrim');

		$category = new Input('category');
		$category->getFilterChain()
			 ->attach(new Filter\StringToLower())
			 ->attachByName('StripTags');
		$category->setRequired(FALSE)
				 ->allowEmpty(TRUE);
		
		$selectCategory = new Input('selectCategory');
		$selectCategory->getFilterChain()
					 ->attach(new Filter\StringToLower())
					 ->attachByName('StripTags');
		
		$topic = new Input('topic');
		$topic->getFilterChain()
			 ->attach(new Filter\StringToLower())
			 ->attachByName('StripTags');
		$topic->setRequired(FALSE)
			  ->allowEmpty(TRUE);
		
		$selectTopic = new Input('selectTopic');
		$selectTopic->getFilterChain()
					 ->attach(new Filter\StringToLower())
					 ->attachByName('StripTags');
		
		$title = new Input('title');
		$title->getValidatorChain()
			 ->addByName('NotEmpty')
			 ->addByName('StringLength', array('min' => 1, 'max' => 254, 'encoding' => 'utf-8'));
		$title->getFilterChain()
			 ->attachByName('StripTags')
			 ->attachByName('StringTrim');

		$body = new Input('body');
		$body->getFilterChain()
		    ->attachByName('StringTrim');
		$body->getValidatorChain()
		    ->addByName('NotEmpty');
  
		$this->add($category)
			 ->add($selectCategory)
			 ->add($topic)
			 ->add($selectTopic)
			 ->add($title)
			 ->add($body);
	}
} 
