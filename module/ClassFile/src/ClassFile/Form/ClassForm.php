<?php
namespace ClassFile\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Captcha;

class ClassForm extends Form
{
	public function prepareElements()
	{
		$class = new Element\Text('class');
		$class->setLabel('Class')
			 ->setAttribute('title', 'Enter a class code: i.e. zf2f-2013-02-25')
			 ->setAttribute('size', 16)
			 ->setAttribute('maxlength', 16);

		$title = new Element\Text('title');
		$title->setLabel('Title')
			 ->setAttribute('title', 'Enter a suitable title for this posting')
			 ->setAttribute('size', 40)
			 ->setAttribute('maxlength', 64);

		$body = new Element\Textarea('body');
		$body->setLabel('Body')
			->setAttribute('title', 'Enter the body for this posting')
			->setAttribute('rows', 4)
			->setAttribute('cols', 60);

		$captcha = new Element\Captcha('captcha');
		$captchaAdapter = new Captcha\Dumb();
		$captchaAdapter->setWordlen(4);
		$captcha->setCaptcha($captchaAdapter)
			    ->setAttribute('title', 'Help to prevent SPAM');
		
		$submit = new Element\Submit('submit');
		$submit->setAttribute('value', 'Post')
			   ->setAttribute('title', 'Click here when done');
		
		$this->add($class)
			 ->add($title)
			 ->add($body)
			 ->add($captcha)
			 ->add($submit);
	}
} 
