<?php
namespace DoctrineDemo\Controller;

use DoctrineDemo\Repository\EventRepo;
use DoctrineDemo\Repository\AttendeeRepo;
use DoctrineDemo\Repository\RegistrationRepo;

trait RepoTrait
{
    protected $eventRepo;
    protected $attendeeRepo;
    protected $registrationRepo;
    
    public function setEventRepo(EventRepo $repo) {
        $this->eventRepo = $repo;
    }
    public function setAttendeeRepo(AttendeeRepo $repo) {
        $this->attendeeRepo = $repo;
    }
    public function setRegistrationRepo(RegistrationRepo $repo) {
        $this->registrationRepo = $repo;
    }
}