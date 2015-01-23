<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/DropDowns for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace FormDemo\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Stdlib\Hydrator\ObjectProperty;

class DropDownsController extends AbstractActionController
{
    public function indexAction()
    {
        $message = 'None';
        $form = $this->getServiceLocator()->get('form-demo-drop-downs-city-select-form');
        $data = $this->params()->fromPost();
        $form->setData($data);
        if ($this->getRequest()->isPost()) {
            if ($form->isValid()) {
                $message = 'VALID';
                $this->flashMessenger()->addMessage($message);
                $this->redirect()->toRoute('home');
            } else {
                $message = 'NOT VALID';
            }
        }
        $viewModel = new ViewModel(array('form' => $form, 'data' => $data, 'message' => $message));
        $viewModel->setTemplate('form-demo/drop-downs/index/index');
        return $viewModel;
    }

    public function fooAction()
    {
        // This shows the :controller and :action parameters in default route
        // are working when you browse to /index/index/foo
        $form = $this->getServiceLocator()->get('drop-downs-city-select-form');
        $viewModel = new ViewModel();
        return array();
    }

    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id');
        $table = $this->getServiceLocator()->get('city-codes-table');
        $data = $table->getCityById($id);
        $form = $this->getServiceLocator()->get('form-demo-drop-downs-edit-city-form');
        if ($data) {
            $form->setData($data);
        }
        // capture data and save
        if ($this->getRequest()->isPost()) {
            $postData = $this->params()->fromPost();
            // TODO: add validation
            // TODO: get the valid data and add/update the database
            // TODO: if successful: redirect to the list
            // TODO: if not, drop through and let them re-edit
        }
        $viewModel = new ViewModel(array('form' => $form, 'id' => $id));
        $viewModel->setTemplate('form-demo/drop-downs/index/edit');
        return $viewModel;
    }
    
    public function cityLookupAction()
    {
        $cityName = $this->params()->fromQuery('term');
        $table = $this->getServiceLocator()->get('city-codes-table');
        $result = $table->getCityLike($cityName);
        $jsonModel = new JsonModel($result);
        return $jsonModel;
    }

    public function cityFromCountryAction()
    {
        $country = strip_tags($this->params()->fromQuery('country'));
        $table = $this->getServiceLocator()->get('city-codes-table');
        $result = $table->getListByCountry($country);
        $jsonModel = new JsonModel($result);
        return $jsonModel;
    }
}
