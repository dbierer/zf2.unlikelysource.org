<?php
namespace Forum\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class NormalizeCategory extends AbstractPlugin
{
	public function __invoke($category)
	{
		return str_ireplace(' ', '', substr($category, 0, 32));
	}
	public function render($category)
	{
	    return $this->__invoke($category);
	}
    public function getDefault()
    {
        return 'zf2';
	}

}