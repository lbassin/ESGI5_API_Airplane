<?php

namespace App\DataFixtures;

use App\Entity\Passenger;
use App\Entity\Ticket;
use App\Repository\TicketRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class PassengerFixtures extends Fixture implements DependentFixtureInterface
{
    private $ticketRepository;

    public function __construct(TicketRepository $ticketRepository)
    {
        $this->ticketRepository = $ticketRepository;
    }

    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr');
        $tickets = $this->ticketRepository->findAll();

        $index = 0;

        /** @var Ticket $ticket */
        foreach ($tickets as $ticket) {
            if ($faker->boolean) {
                continue;
            }

            $passenger = new Passenger();

            $passenger->setFirstname($faker->firstName);
            $passenger->setLastname($faker->lastName);
            $passenger->setAddress($faker->address);
            $passenger->setBirthday($faker->dateTimeBetween("-80 years", "-6 years"));

            $manager->persist($passenger);

            $ticket->setPassenger($passenger);

            if ($index % 250 === 0) {
                $manager->flush();
            }
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            TicketFixtures::class,
        ];
    }
}
