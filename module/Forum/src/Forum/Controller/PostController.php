<?php
namespace Forum\Controller;

use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;

class PostController extends AbstractActionController
{
	
	public $forumTable;
	public $forumCatList;
	public $forumForm;
	public $messages = array();

	/**
	 * primary point of entry for this controller
	 * @todo need to generate docs 
	 * @see \Zend\Mvc\Controller\AbstractActionController::indexAction()
	 */
	public function indexAction()
	{
		$data = NULL;
    	if ($this->zfcUserAuthentication()->hasIdentity()) {
    		$user = $this->zfcUserAuthentication()->getIdentity();
    	} else {
	    	$this->flashMessenger()->addMessage('Please login before posting!');
	    	return $this->redirect()->toRoute('home');
	    }
		if ($this->flashMessenger()->hasMessages()) {
    		$this->messages = $this->flashMessenger()->getMessages();
    	}
		$category = $this->params()->fromRoute('category');
		$category = $this->normalizeCategory($category); 
    	if ($this->getRequest()->isPost()) {
    		$data = $this->params()->fromPost();
    		$author = $this->forumForm->get('author');
    		$author->setValue($user->getEmail());
    		if ($this->processForm('forum-post', $data)) {
    			\Zend\Debug\Debug::dump($data);
		    	if ($this->forumTable->add($data)) {
		    		$this->flashMessenger()->addMessage('Successfully Added Entry');
		    		return $this->redirect()->toUrl('/forum/' . $category);
		    	} else {
		    		$this->messages[] = 'Unable to add posting';
		    	}
    		} else {
    			$this->messages[] = 'Form not valid -- see messages';
    		}
	 	} else {
	 		$categoryElement = $this->forumForm->get('category');
	 		$categoryElement->setValue($category);
	 	}
    	$viewModel = new ViewModel(array('topicForm' => $this->forumForm, 
    									 'messages' => $this->messages, 
    									 'data' => $data));
		$viewModel->setTemplate('forum/post/index.phtml');
		return $viewModel;
    }
    
	/**
	 * @param string action = "action" attribute for the <form> tag
	 * @param array data
	 * @global array $this->messages
	 * @return boolean $valid
	 */
	 private function processForm($action, &$data) 
	 {
	 	$valid = FALSE;
    	$serviceManager = $this->getServiceLocator()->get('ServiceManager');
    	$this->forumFormFilter = $serviceManager->get('forum-form-filter');
    	$this->forumForm->setAttribute('action', $this->url()->fromRoute($action))
   						->setAttribute('method', 'POST')
   						->setInputFilter($this->forumFormFilter)
   						->setData($data);
    	if ($this->forumForm->isValid()) {
    		$valid = TRUE;
	    	$data = $this->forumForm->getData();
    		if (isset($data['selectCategory']) && $data['selectCategory'] != '---') {
    			$data['category'] = $data['selectCategory']; 
    		}
    	    if (isset($data['selectTopic']) && $data['selectTopic'] != '---') {
    			$data['topic'] = $data['selectTopic']; 
    		}
    		if (isset($data['category']) && isset($data['topic']) && $data['category'] && $data['topic']) {
    			$data['category'] = $this->normalizeCategory($data['category']);
    			$data['topic'] = $this->normalizeTopic($data['topic']);
    		} else {
    			$valid = FALSE;
    			$this->messages[] = 'Please fill in a category and topic, or choose from the list';
    		}
    	} else {
    		$valid = FALSE;    		
    		$this->messages[] = 'Please fill in a category and topic, or choose from the list';
    	}
    	return $valid;
	 }

    public function editAction()
    {
    	if ($this->zfcUserAuthentication()->hasIdentity()) {
    		$user = $this->zfcUserAuthentication()->getIdentity();
    	} else {
    		$this->flashMessenger()->addMessage('Please login before posting!');
    		return $this->redirect()->toRoute('home');
    	}
    	// lookup item
    	// check to see if $user = $item->user
    	// if OK populate form
    	 
    }
    
    public function deleteAction()
    {
    	if ($this->zfcUserAuthentication()->hasIdentity()) {
    		$user = $this->zfcUserAuthentication()->getIdentity();
    	} else {
    		$this->flashMessenger()->addMessage('Please login before posting!');
    		return $this->redirect()->toRoute('home');
    	}
    	// check to see if $user = $item->user
    	// if OK delete posting
    }
    
}