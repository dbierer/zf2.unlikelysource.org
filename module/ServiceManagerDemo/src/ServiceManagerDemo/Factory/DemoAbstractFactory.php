<?php
namespace ServiceManagerDemo\Factory;

use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Log\Writer\Stream;
use Zend\Log\Logger;
use ServiceManagerDemo\Service\DemoTest;

/**
 * Creates a Zend\Log\Logger instance
 * 
 * @author db
 *
 */
class DemoAbstractFactory implements AbstractFactoryInterface, DontInitializeMe
{
    public function canCreateServiceWithName(
                            ServiceLocatorInterface $sm, 
                            $name, 
                            $requestedName) 
    {
        return (fnmatch('*test', $requestedName)) ? TRUE : FALSE;
    } 

    public function createServiceWithName(
                            ServiceLocatorInterface $sm, 
                            $name, 
                            $requestedName) 
    {
        return new DemoTest($sm->get('service-manager-demo-logfile'));
    }

}
