<?php

namespace App\DataFixtures;

use App\Entity\Plane;
use App\Repository\CompanyRepository;
use App\Repository\PlaneModelRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class PlaneFixtures extends Fixture implements DependentFixtureInterface
{
    private $companyRepository;
    private $planeModelRepository;

    public function __construct(CompanyRepository $companyRepository, PlaneModelRepository $planeModelRepository)
    {
        $this->companyRepository = $companyRepository;
        $this->planeModelRepository = $planeModelRepository;
    }

    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr');

        $companies = $this->companyRepository->findAll();
        $models = $this->planeModelRepository->findAll();

        for ($i = 0; $i < 15; $i++) {
            $plane = new Plane();

            $plane->setRegistration(substr($faker->swiftBicNumber, 0, 8));
            $plane->setCompany($faker->randomElement($companies));
            $plane->setModel($faker->randomElement($models));

            $manager->persist($plane);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            PlaneModelFixtures::class,
            CompanyFixtures::class,
        ];
    }
}
