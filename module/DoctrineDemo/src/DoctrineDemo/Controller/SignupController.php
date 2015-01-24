<?php

namespace DoctrineDemo\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\Controller\Plugin\PostRedirectGet;
use Zend\Mvc\Controller\Plugin\Redirect;
use Zend\Mvc\InjectApplicationEventInterface;
use Zend\View\Model\ViewModel;

class SignupController extends AbstractActionController 
                       implements InjectApplicationEventInterface, RepoAwareInterface
{

    use RepoTrait;
    
    public function indexAction()
    {
        $eventId = (int) $this->params('event');

        if ($eventId) {
            return $this->eventSignup($eventId);
        }

        $events = $this->eventRepo->findAll();
        return new ViewModel(array('events' => $events));
    }

    public function thanksAction()
    {
        return new ViewModel();
    }

    protected function eventSignup($eventId)
    {
        $event = $this->eventRepo->findById($eventId);

        if (!$event) {
            // better 404 experience?
            return $this->notFoundAction();
        }

        if ($this->request->isPost()) {
            $this->processForm($this->params()->fromPost(), $event);
            return $this->redirect()->toUrl('/thank-you');
        }

        $vm = new ViewModel(array('event' => $event));
        $vm->setTemplate('application/signup/form.phtml');
        return $vm;
    }

    protected function processForm(array $formData, $event)
    {
        $reg = $this->registrationRepo->persist($event, 
                                                $formData['first_name'], 
                                                $formData['last_name']);

        $ticketData = $formData['ticket'];
        foreach ($ticketData as $nameOnTicket) {
            $attendee = $this->attendeeRepo->persist($reg, $nameOnTicket);
            $reg->setAttendees($attendee);
            $this->registrationRepo->update($reg);
        }
        
        return true;
    }

}
