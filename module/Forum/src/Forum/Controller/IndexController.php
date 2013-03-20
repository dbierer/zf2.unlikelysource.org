<?php
namespace Forum\Controller;

use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;

class IndexController extends AbstractActionController
{
	
	public $forumTable;
	public $forumCatList;
	public $messages = array();
	
	public function indexAction()
	{
		$category = '';
		$leftColumnStuff[] = '<h3>Other Notes:</h3>';
		$leftColumnStuff[] = 'If you know the category, enter the URL /forum/category';
	    if ($this->zfcUserAuthentication()->hasIdentity()) {
			$category = $this->params()->fromQuery('category');
			if (!$category) {
				$category = $this->params()->fromRoute('category');
				if (!$category) {
					$category = $this->forumCatList[0];
				}
			}
			$category = $this->normalizeCategory($category); 
			$topics = $this->forumTable->getDistinctTopicsByCategory($category);
			$this->addForTopics($leftColumnStuff, $category);
	    } else {
	    	$topics = NULL;
	    }
		$layout = $this->layout();
		$layout->setVariable('leftColumnStuff', $leftColumnStuff);
    	if ($this->flashMessenger()->hasMessages()) {
    		$this->messages = $this->flashMessenger()->getMessages();
    		$this->flashMessenger()->clearMessages();
    	}
		$viewModel = new ViewModel(array('category' => $category, 'topics' => $topics, 'messages' => $this->messages));
		$viewModel->setTemplate('forum/index/index.phtml');
		return $viewModel;
	}
	
	private function addForTopics(&$leftColumnStuff, $category) 
	{
		$leftColumnStuff[] = '<br />';
		$leftColumnStuff[] = '<h3><a href="/forum/post/' . $category . '">Post</a></h3>';
		$leftColumnStuff[] = '<br /><form action="' 
							. $this->url()->fromRoute('forum-home') 
							. '" method="GET" onClick="submit();">';
		$leftColumnStuff[] = '<select name="category" id="forum-category-select">';
		foreach ($this->forumCatList as $item) {
			$leftColumnStuff[] = sprintf('<option value="%s">%s</option>', $item->item, $item->item);
		}
		$leftColumnStuff[] = '</select>';
		$leftColumnStuff[] = '</form>';
		return TRUE;
	}

	private function normalizeCategory($category)
	{
		return strtolower(str_ireplace(	' ', '', strip_tags($category)));
	}
	
    public function topicAction()
    {
		$category 	= $this->params()->fromRoute('category');
		$topic		= $this->params()->fromRoute('topic');
		if (!$category) {
			$this->flashMessenger()->addMessage('Please specify a category');
			return $this->redirect()->toRoute('forum-home');
		}
		$category = $this->normalizeCategory($category); 
		if (!$topic) {
			$listing = $this->forumTable->getTopicsByCategory($category);
		} else {
			$listing = $this->forumTable->getListingsByCategoryAndTopic($category, $topic);
		}
		$leftColumnStuff = array('<h4><a href="/forum/' . $category . '">&lt;&lt;BACK</a></h4>');
		$layout = $this->layout();
		$layout->setVariable('leftColumnStuff', $leftColumnStuff);
    	if ($this->flashMessenger()->hasMessages()) {
    		$this->messages = $this->flashMessenger()->getMessages();
    	}
		$viewModel = new ViewModel(array('listing' => $listing, 'messages' => $this->messages));
		$viewModel->setTemplate('forum/index/topic.phtml');
		return $viewModel;
    }
    
    public function postAction()
    {
    	$data = 'No Data';
    	$serviceManager = $this->getServiceLocator()->get('ServiceManager');
    	$forumForm = $serviceManager->get('forum-form');
    	$forumForm->prepareElements($this->forumTable->getDistinctTopics(), $this->forumTable->getDistinctCategories());
    	if ($this->zfcUserAuthentication()->hasIdentity()) {
    		$user = $this->zfcUserAuthentication()->getIdentity();
    	} else {
	    	$this->flashMessenger()->addMessage('Please login before posting!');
	    	return $this->redirect()->toRoute('home');
	    }
		$category 	= $this->params()->fromRoute('category');
		if (!$category) {
			$this->flashMessenger()->addMessage('Please specify a category');
			return $this->redirect()->toRoute('forum-home');
		}
		$category = $this->normalizeCategory($category); 
		if ($this->flashMessenger()->hasMessages()) {
    		$this->messages = $this->flashMessenger()->getMessages();
    	}
    	if ($this->getRequest()->isPost()) {
    		$errMessage = 'ERROR: Unable to add entry';
    		$data = $this->params()->fromPost();
    		$forumFormFilter = $serviceManager->get('forum-form-filter');
    		$forumForm->setAttribute('action', $this->url()->fromRoute('forum-post'))
    							->setAttribute('method', 'POST')
    							->setInputFilter($forumFormFilter)
    							->setData($data);
    		if ($forumForm->isValid()) {
	    		$data = $forumForm->getData();
    			if (isset($data['categorySelect']) && $data['categorySelect'] != '---') {
    				$data['category'] = $data['categorySelect']; 
    			}
    		    if (isset($data['topicSelect']) && $data['topicSelect'] != '---') {
    				$data['topic'] = $data['topicSelect']; 
    			}
    			if (isset($data['category']) && isset($data['topic']) && $data['category'] && $data['topic']) {
    				$category = $this->normalizeCategory($data['category']);
    				$data['category'] = $category;
	    			$data['author'] = $user->getEmail();
	    			if ($this->forumTable->add($data)) {
	    				$this->flashMessenger()->addMessage('Successfully Added Entry');
	    				$this->redirect()->toUrl('/forum/' . $category);
	    			}
    			} else {
    				$this->messages[] = 'Please fill in a category and topic, or choose from the list';
    			}
       		}
    		$this->messages[] = $errMessage;
    	}
    	$viewModel = new ViewModel(array('topicForm' => $forumForm, 
    									 'messages' => $this->messages, 
    									 'data' => $data));
		$viewModel->setTemplate('forum/index/post.phtml');
		return $viewModel;
    }

}