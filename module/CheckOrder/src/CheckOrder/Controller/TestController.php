<?php
namespace CheckOrder\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class TestController extends AbstractActionController
{
	public function indexAction()
	{
		$controllerManager = $this->getServiceLocator();
		$serviceManager = $controllerManager->get('ServiceManager');
		return new ViewModel(array('checkTest' => $serviceManager->get('check-test')));
	}
}