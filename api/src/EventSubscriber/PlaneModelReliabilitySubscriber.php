<?php

namespace App\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Crash;
use App\Repository\FlightRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class PlaneModelReliabilitySubscriber implements EventSubscriberInterface
{
    private $flightRepository;

    public function __construct(FlightRepository $flightRepository)
    {
        $this->flightRepository = $flightRepository;
    }

    public function onKernelView(GetResponseForControllerResultEvent $event)
    {
        $entity = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if (!$entity instanceof Crash || $method !== Request::METHOD_POST) {
            return;
        }

        $plane = $entity->getFlight()->getPlane();
        $planeModel = $plane->getModel();

        $query = $this->flightRepository->createQueryBuilder("f");
        $results = $query->join("f.plane", "p")
            ->join("p.model", "m")
            ->where("f.crash IS NOT NULL")
            ->andWhere("m.id = :model_id")
            ->setParameter("model_id", $planeModel->getId())
            ->getQuery()->getResult();

        $planeModel->setReliability(floor((count($results) * 100) / count($planeModel->getPlanes())));
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['onKernelView', EventPriorities::PRE_WRITE],
        ];
    }
}
