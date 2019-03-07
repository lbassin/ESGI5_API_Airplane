<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setEmail('user@test.fr');
        $user->setPassword($this->passwordEncoder->encodePassword($user, 'test'));
        $user->setRoles(['ROLE_USER']);

        $manager->persist($user);

        $user = new User();
        $user->setEmail('manager1@test.fr');
        $user->setPassword($this->passwordEncoder->encodePassword($user, 'test'));
        $user->setRoles(['ROLE_USER', 'ROLE_MANAGER']);

        $this->setReference('manager_1', $user);
        $manager->persist($user);

        $user = new User();
        $user->setEmail('manager2@test.fr');
        $user->setPassword($this->passwordEncoder->encodePassword($user, 'test'));
        $user->setRoles(['ROLE_USER', 'ROLE_MANAGER']);

        $this->setReference('manager_2', $user);
        $manager->persist($user);

        $user = new User();
        $user->setEmail('admin@test.fr');
        $user->setPassword($this->passwordEncoder->encodePassword($user, 'test'));
        $user->setRoles(['ROLE_USER', 'ROLE_MANAGER', 'ROLE_ADMIN']);

        $manager->persist($user);

        $manager->flush();
    }
}
