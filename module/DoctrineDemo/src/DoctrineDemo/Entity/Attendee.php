<?php
namespace DoctrineDemo\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation as ANO;

/**
 * @ORM\Entity("DoctrineDemo\Entity\Attendee")
 * @ORM\Table("attendee")
 */
class Attendee
{
    /**
     * @ORM\Column(type="integer", length=11)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="DoctrineDemo\Entity\Registration", inversedBy="attendees")
     */
    protected $registration;
    
    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $name_on_ticket;
	/**
	 * @return the $id
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @return the $registration
	 */
	public function getRegistration() {
		return $this->registration;
	}

	/**
	 * @return the $name_on_ticket
	 */
	public function getName_on_ticket() {
		return $this->name_on_ticket;
	}

	/**
	 * @param field_type $id
	 */
	public function setId($id) {
		$this->id = $id;
	}

	/**
	 * @param field_type $registration
	 */
	public function setRegistration(Registration $registration) {
		$this->registration = $registration;
	}

	/**
	 * @param field_type $name_on_ticket
	 */
	public function setName_on_ticket($name_on_ticket) {
		$this->name_on_ticket = $name_on_ticket;
	}

    
   
}