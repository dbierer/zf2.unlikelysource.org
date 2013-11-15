<?php
namespace Zf2f\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
	public $config;
	
    public function indexAction()
    {
    	$messages = array();
    	if ($this->flashMessenger()->hasMessages()) {
    		$messages = $this->flashMessenger()->getMessages();
    	}
    	$viewModel = new ViewModel(array('config' => $this->config, 
    									 'messages' => $messages));
    	$viewModel->setTemplate('zf2f/index');
    	return $viewModel;
    }
	public function classAction()
    {
    	// capture param
    	$class = $this->params()->fromRoute('class');
    	// validate
        if (!isset($this->config['class'][$class])) {
        	$this->flashMessenger()->addMessage('Class doesn\'t exist!');
    		return $this->redirect()->toRoute('zf2f-home');
    	}
    	// construct  view model
    	$viewModel = new ViewModel(array('classPartial' => 'zf2f/class/' . $class));
    	$viewModel->setTemplate('zf2f/class');
    	return $viewModel;
    }
    public function labAction()
    {
    	// capture params
    	$what = $this->params()->fromRoute('what'); // notes | solutions
    	$module = $this->params()->fromRoute('module');
    	// validate
    	$what = ($what == 'notes' | $what == 'solutions') ? $what : 'notes';
    	if (!preg_match('/^mod_\d{2}$/', $module)) {
    		$module = 'mod_01';
    	}
    	// construct view model
    	$viewModel = new ViewModel(array('classPartial' => 'zf2f/' . $what . '/' . $module));
    	$viewModel->setTemplate('zf2f/lab');
    	return $viewModel;
    }
    public function guestAction()
    {
    	$viewModel = new ViewModel(array('messages' => 'You need to be logged in!'));
    	$viewModel->setTemplate('zf2f/guest');
    	return $viewModel;
    }
}
