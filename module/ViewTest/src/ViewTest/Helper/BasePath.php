<?php
namespace ViewTest\Helper;

use Zend\Form\View\Helper\AbstractHelper;
use Zend\Form\Form;
use Zend\Form\View\Helper;
use Zend\Form\ElementInterface;

class BasePath extends AbstractHelper
{
	public function render()
	{
		return 'http://' . strip_tags($_SERVER['HTTP_HOST']) . '/';
	}
	public function __invoke()
	{
		return $this->render();
	}
}