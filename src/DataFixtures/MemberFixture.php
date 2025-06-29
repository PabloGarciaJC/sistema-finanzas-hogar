<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class MemberFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $em = $manager instanceof EntityManagerInterface ? $manager : null;

        if ($em === null) {
            throw new \RuntimeException('EntityManager no disponible');
        }

        $conn = $em->getConnection();

        $conn->executeStatement("
            INSERT INTO member (user_id, name, company) VALUES
            (1, 'Juan Pérez', 'Empresa ABC'),
            (1, 'María Gómez', 'Inversiones XYZ'),
            (2, 'Ana Martínez', 'Consultora LMN'),
            (2, 'Luis Rodríguez', 'Servicios OPQ')
        ");
    }

    public function getDependencies(): array
    {
        return [
            UserFixture::class,
        ];
    }
}
