<?php
namespace DoctrineDemo\Repository;

use Doctrine\ORM\EntityRepository;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;
use DoctrineDemo\Entity\Attendee;

class AttendeeRepo extends EntityRepository implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;

    /**
     * @param DoctrineDemo\Entity\Registration $regEntity
     * @param string $nameOnTicket
     * @return DoctrineDemo\Entity\Attendee
     */
    public function persist($regEntity, $nameOnTicket)
    {
        $attendee = new Attendee();
        $attendee->setRegistration($regEntity);
        $attendee->setName_on_ticket($nameOnTicket);
        $em = $this->getEntityManager();
        $em->persist($attendee);
        $em->flush();
        return $attendee;
    }
} 