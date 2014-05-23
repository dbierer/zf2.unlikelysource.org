<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/QandA for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace QandA\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\ArrayAdapter;
use Zend\Session\Container;

class IndexController extends AbstractActionController
{
    public $data;    // instance of QandA\Model\Data
    protected $itemsPerPage = 15;
    protected $pagesWithinRange = 4;
    
    public function indexAction()
    {
        $form = $this->getServiceLocator()->get('q-and-a-search-form');
        if ($this->getRequest()->isPost()) {
            $form->setData($this->params()->fromPost());
            if ($form->isValid()) {
                $data = $form->getData();
                $paginator = new Paginator(new ArrayAdapter($this->data->search($data['search'])));
                $paginator->setCurrentPageNumber(1);
                $paginator->setItemCountPerPage($this->itemsPerPage);
                $paginator->setPageRange($this->pagesWithinRange);
                $this->data->setSession($paginator);
                $this->redirect()->toUrl('/q-and-a/continue/1');
            }
        }
        $page      = (int) $this->params()->fromRoute('page');
        $paginator = new Paginator(new ArrayAdapter($this->data->getQuestions()));
        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage($this->itemsPerPage);
        $viewModel = new ViewModel(array('questions' => $paginator, 'searchForm' => $form, 'page' => 0));
        $viewModel->setTemplate('q-and-a/index/index.phtml');
        return $viewModel;
    }

    public function answerAction()
    {
        $page = (int) $this->params()->fromRoute('page');
        $question = $this->params('question');
        $viewModel = new ViewModel(array('answers' => $this->data->getAnswers($question), 'page' => $page));
        $viewModel->setTemplate('q-and-a/index/answer.phtml');
        return $viewModel;
    }

    public function continueAction()
    {
        $paginator = $this->data->getSession();
        if (!($paginator && $paginator instanceof Paginator)) {
            $this->redirect()->toRoute('q-and-a');
        }
        $page = (int) $this->params()->fromRoute('page');
        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage($this->itemsPerPage);
        $viewModel = new ViewModel(array('questions' => $paginator, 'page' => $page));
        $viewModel->setTemplate('q-and-a/index/continue.phtml');
        return $viewModel;
    }

}
