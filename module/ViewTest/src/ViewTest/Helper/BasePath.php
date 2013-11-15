<?php
namespace ViewTest\Helper;

use Zend\View\Helper\AbstractHelper;

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