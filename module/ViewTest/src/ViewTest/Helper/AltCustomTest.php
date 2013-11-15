<?php
namespace ViewTest\Helper;

use Zend\View\Helper\AbstractHelper;

class AltCustomTest extends AbstractHelper
{
	public function render($text)
	{
		return '<b style="color: blue; font-size: 16px;">' 
			   . htmlspecialchars($text)
			   . '</b>' . PHP_EOL;
	}
}