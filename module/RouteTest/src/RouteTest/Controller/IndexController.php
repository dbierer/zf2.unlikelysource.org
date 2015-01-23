<?php
namespace RouteTest\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
	public function indexAction()
	{
		$viewModel = new ViewModel(array('name' => 'INDEX'));
		$viewModel->setTemplate('routetest/index/index.phtml');
		return $viewModel;
	}
	public function moduleTestAction()
	{
		$viewModel = new ViewModel(array('name' => 'MODULE TEST'));
		$viewModel->setTemplate('routetest/index/index.phtml');
		return $viewModel;
	}
	public function hostnameAction()
	{
		if (strpos($_SERVER['SERVER_ADDR'], '127.') === 0) {
			$url = 'http://zf2.unlikelysource.local/routetest';
		} else {
			$url = 'http://zf2.unlikelysource.org/routetest';
		}
    	$leftColumnStuff = array('<h4><a href="' . $url . '">&lt;&lt;BACK</a></h4>');
		$layout = $this->layout();
		$layout->setVariable('leftColumnStuff', $leftColumnStuff);
		$viewModel = new ViewModel(array('name' => 'HOSTNAME'));
		$viewModel->setTemplate('routetest/index/index.phtml');
		return $viewModel;
	}
	public function wildcardAction()
	{
		$params = array_merge($this->params()->fromQuery(), $this->params()->fromRoute());
		$viewModel = new ViewModel(array('name' => 'WILDCARD', 'params' => $params));
		$viewModel->setTemplate('routetest/index/show-params.phtml');
		return $viewModel;
	}
	public function postMethodAction()
	{
		$params = $this->params()->fromPost();
		$viewModel = new ViewModel(array('name' => 'METHOD - POST', 'params' => $params));
		$viewModel->setTemplate('routetest/index/show-params.phtml');
		return $viewModel;
	}
	public function getMethodAction()
	{
		$params = $this->params()->fromQuery();
		$viewModel = new ViewModel(array('name' => 'METHOD - GET', 'params' => $params));
		$viewModel->setTemplate('routetest/index/show-params.phtml');
		return $viewModel;
	}
	public function moduleXAction()
	{
	    $params = $this->params()->fromRoute();
	    $viewModel = new ViewModel(array('name' => 'MODULE.PHP - X', 'params' => $params));
	    $viewModel->setTemplate('routetest/index/show-params.phtml');
	    return $viewModel;	     
	}
	public function moduleYAction()
	{
	    $params = $this->params()->fromRoute();
	    $viewModel = new ViewModel(array('name' => 'MODULE.PHP - Y', 'params' => $params));
	    $viewModel->setTemplate('routetest/index/show-params.phtml');
	    return $viewModel;	     
	}
	public function moduleZAction()
	{
	    $params = $this->params()->fromRoute();
	    $viewModel = new ViewModel(array('name' => 'MODULE.PHP - Z', 'params' => $params));
	    $viewModel->setTemplate('routetest/index/show-params.phtml');
	    return $viewModel;	     
	}
}