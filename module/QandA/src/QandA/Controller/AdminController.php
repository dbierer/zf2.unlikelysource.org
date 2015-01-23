<?php
namespace QandA\Controller;

use Zend\View\Model\ViewModel;

use Zend\Mvc\Controller\AbstractActionController;

class AdminController extends AbstractActionController
{
	public $zfcUserAuth;
	public function indexAction()
	{
		$viewModel = new ViewModel();		
		$viewModel->setTemplate('q-and-a/admin/index.phtml');
		return $viewModel;
	}
}