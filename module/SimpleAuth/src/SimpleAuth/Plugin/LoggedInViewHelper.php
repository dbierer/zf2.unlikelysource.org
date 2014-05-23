<?php
namespace SimpleAuth\Plugin;

use Zend\Session\Container;
use Zend\Form\View\Helper\AbstractHelper;

class LoggedInViewHelper extends AbstractHelper
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