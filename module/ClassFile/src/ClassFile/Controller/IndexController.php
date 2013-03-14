<?php
namespace ClassFile\Controller;

use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;

class IndexController extends AbstractActionController
{
	
	public $classFileTable;
	public $messages = array();
	public $classFileForm;
	public $classFileFormFilter;
	
	public function indexAction()
	{
		$leftColumnStuff[] = '<h3>Other Notes:</h3>';
		$leftColumnStuff[] = 'If you know the class code, enter the URL /for-class/class-code';
	    if ($this->zfcUserAuthentication()->hasIdentity()) {
			$leftColumnStuff[] = '<br />';
			$leftColumnStuff[] = '<h3><a href="' . $this->url()->fromRoute('classfile-post') . '">Post</a></h3>';
	    	$this->addForClasses ($leftColumnStuff);
	    }
		$layout = $this->layout();
		$layout->setVariable('leftColumnStuff', $leftColumnStuff);
    	if ($this->flashMessenger()->hasMessages()) {
    		$this->messages = $this->flashMessenger()->getMessages();
    	}
		$listing = $this->classFileTable->getLatestListing();
		$viewModel = new ViewModel(array('listing' => $listing, 'messages' => $this->messages));
		$viewModel->setTemplate('class-file/index/index.phtml');
		return $viewModel;
	}
	
	private function addForClasses(&$leftColumnStuff) {
		$classes = $this->classFileTable->getDistinctClasses();
		$leftColumnStuff[] = '<br /><form action="' . $this->url()->fromRoute('classfile-class') . '" method="GET" onClick="submit();">';
		$leftColumnStuff[] = '<select name="">';
		foreach ($classes as $item) {
			$leftColumnStuff[] = sprintf('<option value="%s">%s</option>', $item->offsetGet('Expression1'), $item->offsetGet('Expression1'));
		}
		$leftColumnStuff[] = '</select>';
		$leftColumnStuff[] = '</form>';
		return TRUE;
	}

    public function forClassAction()
    {
    	if ($this->flashMessenger()->hasMessages()) {
    		$this->messages = $this->flashMessenger()->getMessages();
    	}
    	if ($this->params()->fromRoute('class')) {
	    	$class = $this->params()->fromRoute('class');
    	} elseif ($this->params()->fromQuery('class')) {
    		$class = $this->params()->fromQuery('class');
    	} else {
    		$class = 'Listing Not Found';
    	}
		$listing = $this->classFileTable->getListingsByClass($class);
		$viewModel = new ViewModel(array('listing' => $listing, 'messages' => $this->messages));
		$viewModel->setTemplate('class-file/index/for-class.phtml');
		return $viewModel;
    }
    public function postClassAction()
    {
	    if (!$this->zfcUserAuthentication()->hasIdentity()) {
	    	$this->flashMessenger()->addMessage('Please login before posting!');
	    	return $this->redirect()->toRoute('home');
	    }
    	if ($this->flashMessenger()->hasMessages()) {
    		$this->messages = $this->flashMessenger()->getMessages();
    	}
    	if ($this->getRequest()->isPost()) {
    		$this->classFileForm->setAttribute('action', $this->url()->fromRoute('classfile-post'))
    							->setAttribute('method', 'POST')
    							->setInputFilter($this->classFileFormFilter)
    							->setData($this->params()->fromPost());
    		if ($this->classFileForm->isValid()) {
    			$this->classFileTable->add($this->classFileForm->getData());
    			$this->messages[] = 'Successfully Added Entry';
    		} else {
    			$this->messages[] = 'ERROR: Unable to add entry';
    		}
    	}
		$viewModel = new ViewModel(array('classForm' => $this->classFileForm, 'messages' => $this->messages));
		$viewModel->setTemplate('class-file/index/post-class.phtml');
		return $viewModel;
    }
}