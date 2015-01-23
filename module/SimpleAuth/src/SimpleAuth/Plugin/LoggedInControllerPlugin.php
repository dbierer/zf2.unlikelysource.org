<?php
namespace SimpleAuth\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\Session\Container;

class LoggedInControllerPlugin extends AbstractPlugin
{
	public function __invoke()
	{
		$sess = new Container('simpleAuth');
		$loggedIn = FALSE;
		if (isset($sess->auth) && $sess->auth === 1) {
			$loggedIn = TRUE;
		}
		return $loggedIn;
	}
}