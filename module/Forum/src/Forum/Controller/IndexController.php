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

    public function topicAction()
    {
		$category 	= urldecode($this->params()->fromRoute('category'));
		$topic		= urldecode($this->params()->fromRoute('topic'));
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
    
}