<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace DoctrineDemo;

use DoctrineDemo\Repository\AttendeeRepo;
use DoctrineDemo\Repository\EventRepo;
use DoctrineDemo\Repository\RegistrationRepo;
use DoctrineDemo\Entity\Attendee;
use DoctrineDemo\Entity\Event;
use DoctrineDemo\Entity\Registration;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Doctrine\ORM\Mapping\ClassMetadata;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $e->getApplication()->getServiceManager()->get('translator');
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getControllerConfig()
    {
        return array(
          'initializers' => array(
              'application-inject-repos' => function ($instance, $cm) {
                  if ($instance instanceof \DoctrineDemo\Controller\RepoAwareInterface) {
                      $sm = $cm->getServiceLocator();
                      $instance->setEventRepo($sm->get('application-repo-event'));
                      $instance->setAttendeeRepo($sm->get('application-repo-attendee'));
                      $instance->setRegistrationRepo($sm->get('application-repo-registration'));
                  }
              }
          ),
          'invokables' => array(
            'DoctrineDemo\Controller\Index' => 'DoctrineDemo\Controller\IndexController',
            'DoctrineDemo\Controller\Signup' => 'DoctrineDemo\Controller\SignupController',
            'DoctrineDemo\Controller\Admin' => 'DoctrineDemo\Controller\AdminController',
          ),  
        );
    }
    // Add this method:
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'application-repo-attendee'    => function ($sm) {
                    return new AttendeeRepo($sm->get('doctrine.entitymanager.orm_default'),
                                            new ClassMetadata('DoctrineDemo\Entity\Attendee'));
                },
                'application-repo-event'       => function ($sm) {
                    return new EventRepo($sm->get('doctrine.entitymanager.orm_default'),
                                         new ClassMetadata('DoctrineDemo\Entity\Event'));
                },
                'application-repo-registration'=> function ($sm) {
                    return new RegistrationRepo($sm->get('doctrine.entitymanager.orm_default'),
                                                new ClassMetadata('DoctrineDemo\Entity\Registration'));
                },
            ),
        );
    }


}
