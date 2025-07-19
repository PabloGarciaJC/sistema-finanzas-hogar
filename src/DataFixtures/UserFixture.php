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
        // Usuario admin existente
        $user1 = new User();
        $user1->setEmail('user1@user.com');
        $user1->setAlias('Sánchez');
        $user1->setRoles(['ROLE_ADMIN']);
        $user1->setPassword(
            $this->passwordHasher->hashPassword($user1, 'password')
        );
        $manager->persist($user1);

        // Nuevo usuario superadmin
        $superadmin = new User();
        $superadmin->setEmail('superadmin@superadmin.com');
        $superadmin->setAlias('Super Admin');
        $superadmin->setRoles(['ROLE_SUPER']);
        $superadmin->setPassword(
            $this->passwordHasher->hashPassword($superadmin, 'password')
        );
        $manager->persist($superadmin);

        $manager->flush();
    }
}
