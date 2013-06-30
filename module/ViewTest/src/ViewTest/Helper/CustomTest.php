<?php
namespace ViewTest\Helper;

use Zend\Form\View\Helper\AbstractHelper;
use Zend\Form\Form;
use Zend\Form\View\Helper;
use Zend\Form\ElementInterface;

class CustomTest extends AbstractHelper
{
	public function render($text)
	{
		return '<b style="color: red; font-size: 16px;">' 
			   . htmlspecialchars($text)
			   . '</b>' . PHP_EOL;
	}
	public function __invoke($text)
	{
		return $this->render($text);
	}
}