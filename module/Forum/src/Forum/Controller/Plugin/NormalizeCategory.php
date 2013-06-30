<?php
namespace Forum\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class NormalizeCategory extends AbstractPlugin
{
	public function __invoke($category)
	{
		return str_ireplace(	' ', '', substr($category, 0, 32));
	}
}