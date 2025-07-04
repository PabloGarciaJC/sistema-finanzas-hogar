<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixture extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $user1 = new User();
        $user1->setEmail('user1@user.com');
        $user1->setAlias('Verpa');
        $user1->setRoles(['ROLE_ADMIN']);
        $user1->setPassword(
            $this->passwordHasher->hashPassword($user1, 'password')
        );
        $manager->persist($user1);

        $user2 = new User();
        $user2->setEmail('user2@user.com');
        $user2->setAlias('Usuario2');
        $user2->setRoles(['ROLE_USER']);
        $user2->setPassword(
            $this->passwordHasher->hashPassword($user2, 'password')
        );
        $manager->persist($user2);

        $manager->flush();
        
    }
}
