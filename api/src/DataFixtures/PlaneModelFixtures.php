<?php

namespace App\DataFixtures;

use App\Entity\PlaneModel;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class PlaneModelFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr');

        for ($i = 0; $i < 5; $i++) {
            $model = new PlaneModel();

            $name = sprintf("%s%s", $faker->stateAbbr, $faker->buildingNumber);
            $model->setName($name);

            $model->setPlaces($faker->numberBetween(10, 250));
            $model->setGazoline($faker->numberBetween(1000, 5000));

            $manager->persist($model);
        }

        $manager->flush();
    }
}
