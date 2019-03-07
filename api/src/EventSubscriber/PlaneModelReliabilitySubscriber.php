<?php

namespace App\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Crash;
use App\Entity\Plane;
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

        if ($method !== Request::METHOD_POST) {
            return;
        }

        if ($entity instanceof Crash) {
            $this->updateReliability($entity->getFlight()->getPlane(), false);
        }

        if ($entity instanceof Plane) {
            $this->updateReliability($entity, true);
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['onKernelView', EventPriorities::PRE_WRITE],
        ];
    }

    private function updateReliability(Plane $plane, bool $planeOrCrash)
    {
        $planeModel = $plane->getModel();
        $query = $this->flightRepository->createQueryBuilder("f");
        $results = $query->join("f.plane", "p")
            ->join("p.model", "m")
            ->where("f.crash IS NOT NULL")
            ->andWhere("m.id = :model_id")
            ->setParameter("model_id", $planeModel->getId())
            ->getQuery()->getResult();

        $planeNumber = count($planeModel->getPlanes()) + ($planeOrCrash ? 1 : 0);
        $planeModel->setReliability(floor((count($results) * 100) / $planeNumber));
    }
}
