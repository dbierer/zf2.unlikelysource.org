<?php
namespace Forum\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class NormalizeTopic extends AbstractPlugin
{
	public function __invoke($topic)
	{
		return substr($topic, 0, 128);
	}
}