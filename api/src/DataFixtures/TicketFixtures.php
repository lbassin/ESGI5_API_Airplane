<?php

namespace App\DataFixtures;

use App\Entity\Flight;
use App\Entity\Ticket;
use App\Repository\FlightRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class TicketFixtures extends Fixture implements DependentFixtureInterface
{
    private $flightRepository;

    public function __construct(FlightRepository $flightRepository)
    {
        $this->flightRepository = $flightRepository;
    }

    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr');

        /** @var Flight $flight */
        foreach ($this->flightRepository->findAll() as $flight) {
            $places = $flight->getPlane()->getModel()->getPlaces();

            for ($i = 0; $i < $places; $i++) {
                $ticket = new Ticket();

                $ticket->setFlight($flight);
                $ticket->setPrice($faker->randomFloat(2, 35, 3000));

                $manager->persist($ticket);
            }

        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            FlightFixtures::class,
        ];
    }
}
