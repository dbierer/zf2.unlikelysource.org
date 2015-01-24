<?php
namespace DoctrineDemo\Repository;

use Doctrine\ORM\EntityRepository;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

class EventRepo extends EntityRepository implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;
    public function findById($eventId)
    {
        return $this->findOneBy(array('id' => $eventId));
    }
} 