<?php
namespace DoctrineDemo\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use DoctrineDemo\Entity\Attendee;
use Zend\Form\Annotation as ANO;

/**
 * @ORM\Entity("DoctrineDemo\Entity\Registration")
 * @ORM\Table("registration")
 */
class Registration
{
    /**
     * @ORM\Column(type="integer", length=11)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $first_name;
    
    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $last_name;
    
    /**
     * @ORM\Column(type="datetime")
     */
    protected $registration_time;
    
    /**
     * @ORM\OneToMany(targetEntity="DoctrineDemo\Entity\Attendee", indexBy="id", mappedBy="registration")
     */
    protected $attendees = array();
    
    /**
     * @ORM\ManyToOne(targetEntity="DoctrineDemo\Entity\Event")
     */
    protected $event;

    public function __construct()
    {
        $this->attendees = new ArrayCollection();
    }
	/**
	 * @return the $id
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @return the $first_name
	 */
	public function getFirst_name() {
		return $this->first_name;
	}

	/**
	 * @return the $last_name
	 */
	public function getLast_name() {
		return $this->last_name;
	}

	/**
	 * @return the $registration_time
	 */
	public function getRegistration_time() {
		return $this->registration_time;
	}

	/**
	 * @return the $attendees
	 */
	public function getAttendees() {
		return $this->attendees;
	}

	/**
	 * @return the $event
	 */
	public function getEvent() {
		return $this->event;
	}

	/**
	 * @param field_type $id
	 */
	public function setId($id) {
		$this->id = $id;
	}

	/**
	 * @param field_type $first_name
	 */
	public function setFirst_name($first_name) {
		$this->first_name = $first_name;
	}

	/**
	 * @param field_type $last_name
	 */
	public function setLast_name($last_name) {
		$this->last_name = $last_name;
	}

	/**
	 * @param field_type $registration_time
	 */
	public function setRegistration_time($registration_time = NULL) {
	    if ($registration_time == NULL) {
	        $registration_time = new \DateTime('now');
	    }
		$this->registration_time = $registration_time;
	}

	/**
	 * @param multitype: $attendees
	 */
	public function setAttendees(Attendee $attendee) {
		$this->attendees[] = $attendee;
	}

	/**
	 * @param field_type $event
	 */
	public function setEvent($event) {
		$this->event = $event;
	}

    
        
}