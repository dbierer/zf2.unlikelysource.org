<?php
namespace ViewTest\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
	protected $value = array('A' => 'Alpha', 'B' => 'Beta', 'D' => 'Delta');
	
	public function indexAction()
	{
	    // shows how to access the layout from a controller:
    	$leftColumnStuff = array('<h4><a href="/viewtest/test">&lt;&lt;TEST</a></h4>');
		$layout = $this->layout();
		$layout->setVariable('leftColumnStuff', $leftColumnStuff);
	    return new ViewModel();
	}
	public function phpAction()
	{
	    $response = $this->getResponse();
	    $response->setContent('SOME CONTENT');
	    return $response;
	    /*
		$viewModel = new ViewModel(array('value' => $this->value));
		$viewModel->setTerminal(TRUE);
		return $viewModel;
		*/
	}
	public function jsonAction()
	{
		return new JsonModel(array('value' => $this->value));
	}
	public function testAction()
	{
	    // shows how to access the layout from a controller:
    	$leftColumnStuff = array('<h4><a href="/viewtest">&lt;&lt;BACK</a></h4>');
		$layout = $this->layout();
		$layout->setVariable('leftColumnStuff', $leftColumnStuff);
	    $viewModel = new ViewModel(array('value' => $this->value));
	    return $viewModel; 
	}
}