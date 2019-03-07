<?php

namespace App\DataFixtures;

use App\Entity\Airport;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class AirportFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr');
        $user = [
            $this->getReference('manager_1'),
            $this->getReference('manager_2'),
        ];

        for ($i = 0; $i < 25; $i++) {
            $airport = new Airport();

            $code = sprintf("%s%s%s", $faker->randomLetter, $faker->randomLetter, $faker->randomLetter);
            $airport->setCode(strtoupper($code));

            $airport->setName($faker->company);
            $airport->setAddress($faker->address);
            $airport->setManager($faker->boolean ? $user[0] : $user[1]);

            $manager->persist($airport);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }
}
