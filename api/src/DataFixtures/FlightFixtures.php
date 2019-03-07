<?php

namespace App\DataFixtures;

use App\Entity\Flight;
use App\Repository\PlaneRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class FlightFixtures extends Fixture implements DependentFixtureInterface
{
    private $planeRepository;

    public function __construct(PlaneRepository $planeRepository)
    {
        $this->planeRepository = $planeRepository;
    }

    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr');
        $planes = $this->planeRepository->findAll();

        for ($i = 0; $i < 12; $i++) {
            $flight = new Flight();

            $code = sprintf('%s%s%d', $faker->randomLetter, $faker->randomLetter, $faker->numberBetween(1000, 9999));

            $flight->setCode(strtoupper($code));
            $flight->setPlane($faker->randomElement($planes));
            $flight->setCrash(null);

            $manager->persist($flight);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            PlaneFixtures::class,
        ];
    }
}
