<?php
namespace ApplicationTest\Controller;

use Application\Controller\IndexController;
use ApplicationTest\Bootstrap;
use Zend\Http\PhpEnvironment\Request;
use Zend\Mvc\Router\RouteMatch;
use Zend\Mvc\MvcEvent;

/**
 * IndexController test case.
 * 
 * see: https://github.com/zendframework/zf2/tree/master/tests/ZendTest/Mvc/Controller/TestAsset
 *      for examples of controller tests
 */
class IndexControllerTest extends \PHPUnit_Framework_TestCase
{
	
	/**
	 *
	 * @var IndexController
	 */
	private $IndexController;
	
	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp ();
		$this->IndexController = new IndexController();
		$this->request = new Request();
		$this->response = null;
		$this->routeMatch = new RouteMatch(array('controller' => 'controller-sample'));
		$this->event = new MvcEvent();
		$this->event->setRouteMatch($this->routeMatch);
		$this->IndexController->setEvent($this->event);
	}
	
	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() {
		// TODO Auto-generated IndexControllerTest::tearDown()
		$this->IndexController = null;
		
		parent::tearDown ();
	}
	
	/**
	 * Constructs the test case.
	 */
	public function __construct() {
		// TODO Auto-generated constructor
	}
	
	public function testIndexAction()
	{
		$viewModel = $this->IndexController->indexAction();
		$this->assertInstanceof('Zend\View\Model\ViewModel', $viewModel);
	}
}
