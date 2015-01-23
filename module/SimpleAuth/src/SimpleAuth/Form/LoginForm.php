<?php
namespace SimpleAuth\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Zend\Captcha\Dumb;
use Zend\Captcha\Image;

class LoginForm extends Form
{
	public function prepareElements($captchaOptions)
	{
		$this->add(array(
            'name' => 'who',
            'type'  => 'Text',
			'options' => array('label' => 'Login Name'),
        ));
		$this->add(array(
            'name' => 'what',
            'type'  => 'Password',
			'options' => array('label' => 'Password'),
        ));
		$this->add(array(
            'type' => 'Captcha',
            'name' => 'captcha',
            'options' => array(
                'label' => 'Help us to prevent SPAM!',
            	'attributes' => array('class' => 'captchaStyle'),
                'captcha' => new Image($captchaOptions),
            ),
        ));
		$this->add(new Element\Csrf('security'));
		$this->add(array(
            'name' => 'submit',
            'type'  => 'submit',
			'attributes' => array('value' => 'Login')
        ));
	}
}