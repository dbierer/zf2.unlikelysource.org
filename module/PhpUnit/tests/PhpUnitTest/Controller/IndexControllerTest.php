<?php
/**
 * Standard controller test
 * @author doug
 *
 */
namespace PhpUnitTest\Controller;

use PhpUnit\Controller\IndexController;
use PHPUnit_Framework_TestCase as TestCase;
use Zend\EventManager\StaticEventManager;
use Zend\Http\Request;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;
// included for advanced test cases
use Zend\EventManager\SharedEventManager;
use Zend\Http\Response;
use Zend\Mvc\Controller\PluginManager;

class IndexControllerTest extends TestCase
{
    public $controller;
    public $event;
    public $request;
    public $response;

    public function setUp()
    {
        StaticEventManager::resetInstance();
        $this->controller = new IndexController();
        $this->request = new Request();
        $this->response = null;
        $this->routeMatch = new RouteMatch(array('controller' => 'php-unit-controller-index'));
        $this->event = new MvcEvent();
        $this->event->setRouteMatch($this->routeMatch);
        $this->controller->setEvent($this->event);
    }

    public function testDispatchInvokesNotFoundActionWhenInvalidActionPresentInRouteMatch()
    {
        $this->routeMatch->setParam('action', 'totally-made-up-action');
        $result = $this->controller->dispatch($this->request, $this->response);
        $response = $this->controller->getResponse();
        $this->assertEquals(404, $response->getStatusCode());
        $this->assertInstanceOf('Zend\View\Model\ModelInterface', $result);
        $this->assertEquals('content', $result->captureTo());
        $vars = $result->getVariables();
        $this->assertArrayHasKey('content', $vars, var_export($vars, 1));
        $this->assertContains('Page not found', $vars['content']);
    }

    public function testDispatchInvokesProvidedIndexActionWhenMethodExists()
    {
        $this->routeMatch->setParam('action', 'index');
        $result = $this->controller->dispatch($this->request, $this->response);
        $this->assertInstanceOf('Zend\View\Model\ViewModel', $result);
    }

}
