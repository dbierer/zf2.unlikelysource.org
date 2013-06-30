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
	// NOTE: the "query" route type has been deprecated as of 2.1.4!
	/*
	public function queryAction()
	{
    	$leftColumnStuff = array('<h4><a href="' . $this->url()->fromRoute('routetest-home') . '">&lt;&lt;BACK</a></h4>');
		$layout = $this->layout();
		$layout->setVariable('leftColumnStuff', $leftColumnStuff);
		$params = array_merge($this->params()->fromQuery(), $this->params()->fromRoute());
		$viewModel = new ViewModel(array('name' => 'QUERY', 'params' => $params));
		$viewModel->setTemplate('routetest/index/show-params.phtml');
		return $viewModel;
	}
	*/
	public function wildcardAction()
	{
    	$leftColumnStuff = array('<h4><a href="' . $this->url()->fromRoute('routetest-home') . '">&lt;&lt;BACK</a></h4>');
		$layout = $this->layout();
		$layout->setVariable('leftColumnStuff', $leftColumnStuff);
		$params = array_merge($this->params()->fromQuery(), $this->params()->fromRoute());
		$viewModel = new ViewModel(array('name' => 'WILDCARD', 'params' => $params));
		$viewModel->setTemplate('routetest/index/show-params.phtml');
		return $viewModel;
	}
	public function methodPostAction()
	{
    	$leftColumnStuff = array('<h4><a href="' . $this->url()->fromRoute('routetest-home') . '">&lt;&lt;BACK</a></h4>');
		$layout = $this->layout();
		$layout->setVariable('leftColumnStuff', $leftColumnStuff);
		$params = array_merge($this->params()->fromPost());
		$viewModel = new ViewModel(array('name' => 'METHOD - POST', 'params' => $params));
		$viewModel->setTemplate('routetest/index/show-params.phtml');
		return $viewModel;
	}
}