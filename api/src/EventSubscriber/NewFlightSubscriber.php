<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Flight;
use App\Entity\Ticket;
use App\Repository\TicketRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class NewFlightSubscriber implements EventSubscriberInterface
{

    private $ticketRepository;

    public function __construct(TicketRepository $ticketRepository)
    {
        $this->ticketRepository = $ticketRepository;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['onFlightCreate', EventPriorities::POST_WRITE],
        ];
    }

    public function onFlightCreate(GetResponseForControllerResultEvent $event)
    {
        /** @var Flight $flight */
        $flight = $event->getControllerResult();

        if (!$flight instanceof Flight) {
            return;
        }

        if ($event->getRequest()->getMethod() === Request::METHOD_POST) {
            $this->createTickets($flight);

            return;
        }

        if ($event->getRequest()->getMethod() === Request::METHOD_DELETE) {
            $this->deleteTickets($flight);

            return;
        }
    }

    private function createTickets(Flight $flight): void
    {
        $places = $flight->getPlane()->getModel()->getPlaces();

        for ($i = 0; $i < $places; $i++) {
            $ticket = new Ticket();

            $ticket->setFlight($flight);
            $ticket->setPrice(350);

            $this->ticketRepository->save($ticket);
        }
    }

    private function deleteTickets(Flight $flight): void
    {
        $tickets = $this->ticketRepository->findBy(['flight' => $flight]);
        $this->ticketRepository->removeAll($tickets);
    }
}
