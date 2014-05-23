<?php
namespace FormDemo\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * ReportController
 *
 * @author
 *
 * @version
 *
 */
class ReportController extends AbstractActionController
{

    /**
     * The default action - show the home page
     */
    public function indexAction ()
    {
        $service = $this->getServiceLocator()->get('form-demo-table-service');
        $viewModel = new ViewModel(array('sum' => $service->getCountriesAndCitiesWithSums()));
        $viewModel->setTemplate('form-demo/application/report/index');
        return $viewModel;
    }
}