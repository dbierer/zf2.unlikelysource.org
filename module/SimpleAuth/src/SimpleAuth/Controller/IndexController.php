<?php
namespace SimpleAuth\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Session\Container;
use SimpleAuth\Model\User;

class IndexController extends AbstractActionController
{
    public function loginAction()
    {
    	$form = $this->getServiceLocator()->get('simple-auth-login-form');
    	$form->bind(new User());
    	if ($this->getRequest()->isPost()) {
			$user = new User($this->params()->fromPost());
    		$form->setData($user);
    		if ($form->isValid()) {
    			$incoming = $form->getData();
    			$valid    = new User($config['simple-auth']['credentials']);
    			$config = $this->getServiceLocator()->get('Config');
    			if ($incoming == $value) {
    				$sess = $this->getServiceLocator()->get('simple-auth-session');
    				$sess->auth = 1;
    				$this->redirect()->toRoute($config['simple-auth']['redirect']);
    			}
    		}
    	}
    	$viewModel = new ViewModel(array('form' => $form));
    	$viewModel->setTemplate('simple-auth/index/login');
        return $viewModel;
    }
}
