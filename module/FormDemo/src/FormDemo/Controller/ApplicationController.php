<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace FormDemo\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use ZendPdf\PdfDocument;
use ZendPdf\Page;
use ZendPdf\Font;

class ApplicationController extends AbstractActionController
{
    public function indexAction()
    {
        $messages = array();
        if ($this->flashMessenger()->hasMessages()) {
            $messages = $this->flashMessenger()->getMessages();
        }
        $model = $this->getServiceLocator()->get('city-codes-table');
        $viewModel = new ViewModel(array('list' => $model->getListOfCitiesAndCountries(),
                                         'messages' => $messages,
        ));
        $viewModel->setTemplate('form-demo/application/index/application.phtml');
    }
    public function countryAction()
    {
        $service = $this->getServiceLocator()->get('form-demo-table-service');
        $viewModel = new ViewModel(array('list' => $service->getCountriesAndCitiesWithSums()));
        $viewModel->setTemplate('form-demo/application/index/country');
        return $viewModel;        
    }
    public function pdfAction()
    {
        $iso2 = $this->params()->fromRoute('iso2');
        $table = $this->getServiceLocator()->get('city-codes-table');
        $viewModel = new ViewModel(array('cityList' => $table->getListByCountry($iso2),
                                         'countryCode' => $iso2));
        $viewModel->setTemplate('form-demo/application/index/pdf-cities');
        $viewRender = $this->getServiceLocator()->get('ViewRenderer');
        $list = explode(PHP_EOL, $viewRender->render($viewModel));
        $font = Font::fontWithPath('/usr/share/fonts/truetype/freefont/FreeMono.ttf');
        $pdf = new PdfDocument();
		// top left 1" from top 1" from left
		$x = 72;
		$y = 720;
		$dec = 18;
		foreach ($list as $index => $row) { 
			if (substr($row, 0, 1) == '=' || $y <= 72) {
			    if ($index > 0) {
			        $pdf->pages[] = $page;
			    }
        		$page = new Page(Page::SIZE_LETTER);
        		$page->setFont($font, 12);
        		$y = 720;
			}
		    $page->drawText($row, $x, $y);
			$y -= $dec;
		}
		$pdf->pages[] = $page;
		// retrieve the response object
    	$response = $this->getResponse();
    	// set the header
    	$response->getHeaders()->addHeaders(array('Content-Type' => 'application/pdf'));
		$response->setContent($pdf->render());
		return $response;
    }
}
