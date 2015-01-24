<?php
namespace DoctrineDemo\Controller;

use DoctrineDemo\Repository\EventRepo;
use DoctrineDemo\Repository\AttendeeRepo;
use DoctrineDemo\Repository\RegistrationRepo;

interface RepoAwareInterface
{
    public function setEventRepo(EventRepo $repo);
    public function setAttendeeRepo(AttendeeRepo $repo);
    public function setRegistrationRepo(RegistrationRepo $repo);
}