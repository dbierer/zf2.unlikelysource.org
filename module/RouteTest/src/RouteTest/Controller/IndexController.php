<?php
namespace RouteTest\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
	public function indexAction()
	{
		$viewModel = new ViewModel(array('name' => 'INDEX'));
		$viewModel->setTemplate('route-test/index/index.phtml');
		return $viewModel;
	}
	public function hostnameAction()
	{
		$viewModel = new ViewModel(array('name' => 'HOSTNAME'));
		$viewModel->setTemplate('route-test/index/index.phtml');
		return $viewModel;
	}
	public function queryAction()
	{
		$params = array_merge($this->params()->fromQuery(), $this->params()->fromRoute());
		$viewModel = new ViewModel(array('name' => 'QUERY', 'params' => $params));
		$viewModel->setTemplate('route-test/index/show-params.phtml');
		return $viewModel;
	}
	public function wildcardAction()
	{
		$params = array_merge($this->params()->fromQuery(), $this->params()->fromRoute());
		$viewModel = new ViewModel(array('name' => 'WILDCARD', 'params' => $params));
		$viewModel->setTemplate('route-test/index/show-params.phtml');
		return $viewModel;
	}
	public function methodGetAction()
	{
		$viewModel = new ViewModel(array('name' => 'METHOD - GET'));
		$viewModel->setTemplate('route-test/index/index.phtml');
		return $viewModel;
	}
	public function methodPostAction()
	{
		$params = array_merge($this->params()->fromPost());
		$viewModel = new ViewModel(array('name' => 'METHOD - POST', 'params' => $params));
		$viewModel->setTemplate('route-test/index/show-params.phtml');
		return $viewModel;
	}
}