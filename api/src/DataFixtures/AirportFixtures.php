<?php

namespace App\DataFixtures;

use App\Entity\Airport;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AirportFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr');

        for ($i = 0; $i < 25; $i++) {
            $airport = new Airport();

            $code = sprintf("%s%s%s", $faker->randomLetter, $faker->randomLetter, $faker->randomLetter);
            $airport->setCode(strtoupper($code));

            $airport->setName($faker->company);
            $airport->setAddress($faker->address);

            $manager->persist($airport);
        }

        $manager->flush();
    }
}
