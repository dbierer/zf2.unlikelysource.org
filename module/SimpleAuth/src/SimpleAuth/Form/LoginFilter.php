<?php
namespace SimpleAuth\Form;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Input;

class LoginFilter extends InputFilter
{
	public function prepareFilters()
	{
		$who = new Input('who');
		$who->getFilterChain()
			->attachByName('StripTags');
		$what = new Input('what');
		$who->getFilterChain()
		->attachByName('StripTags');
	}
}