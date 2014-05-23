<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ConsoleTest for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace RouteTest\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Console\Request as ConsoleRequest;

class ConsoleTestController extends AbstractActionController
{
    /**
     * NOTE: to test this run the following:
     * php /path/to/public/index.php console 12345 TEST1 TEST2
     * @see \Zend\Mvc\Controller\AbstractActionController::indexAction()
     */
    public function indexAction()
    {
		// make sure this is a console request
		$request = $this->getRequest();
		if (!$request instanceof ConsoleRequest){
			echo 'ERROR: Non-console request made';
			exit;
        }
        
        // init vars
		$input  = array();
		$output = array();
		
		// get input from request; security hash = [1]
		$input = $request->getParams();
		echo 'Inputs: ' . PHP_EOL;
		var_dump($input);
        exit;
    }

}
