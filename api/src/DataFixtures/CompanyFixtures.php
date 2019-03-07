<?php

namespace App\DataFixtures;

use App\Entity\Company;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CompanyFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr');

        for ($i = 0; $i < 8; $i++) {
            $company = new Company();

            $company->setName($faker->company);

            $manager->persist($company);
        }

        $manager->flush();
    }
}
