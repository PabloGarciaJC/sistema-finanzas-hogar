<?php

namespace App\DataFixtures;

use App\Entity\Service;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ServicesFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // // Usar getReference con 2 argumentos: nombre y clase
        // $user = $this->getReference('user_1', \App\Entity\User::class);

        // for ($i = 1; $i <= 10; $i++) {
        //     $service = new Service();

        //     $service->setUser($user);

        //     // También pasar el segundo argumento para member
        //     $service->setMember($this->getReference('member_' . $i, \App\Entity\Member::class));

        //     $service->setAmount((string)(mt_rand(1000, 10000) / 100));
        //     $service->setDescription('Servicio de ejemplo #' . $i);
        //     $service->setDate(new \DateTime("-{$i} days"));
        //     $service->setStatus('Activo');

        //     $manager->persist($service);
        // }

        // $manager->flush();
    }
}
