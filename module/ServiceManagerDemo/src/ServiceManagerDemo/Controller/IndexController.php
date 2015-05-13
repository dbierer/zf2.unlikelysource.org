<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ServiceManagerDemo for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace ServiceManagerDemo\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction() 
    {
        // 'service-manager-demo-test' is not defined: should use abstract factory
        $demoTest = $this->getServiceLocator()->get('service-manager-demo-test');
        // get logfile and send to view
        $logFn = $this->getServiceLocator()->get('service-manager-demo-logfile');
        $logInfo = file_get_contents($logFn);
        // clear for next time
        file_put_contents($logFn, '');
        $model = $this->getServiceLocator()->get('service-manager-demo-model');
        $viewModel = new ViewModel(array('model' => $model, 'log' => $logInfo));
        return $viewModel;
    }

    public function fooAction()
    {
        // This shows the :controller and :action parameters in default route
        // are working when you browse to /index/index/foo
        return array();
    }
}
