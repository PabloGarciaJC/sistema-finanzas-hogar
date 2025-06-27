<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class IncomeFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $em = $manager instanceof EntityManagerInterface ? $manager : null;

        if ($em === null) {
            throw new \RuntimeException('EntityManager no disponible');
        }

        $conn = $em->getConnection();

        $conn->executeStatement("
            INSERT INTO income (user_id, member_id, amount, month, year, status) VALUES
            (1, 1, 1200.50, 1, 11, 'Activo'),
            (1, 2, 1500.00, 1, 11, 'Activo'),
            (1, 1, 1100.00, 2, 11, 'Activo'),
            (1, 3, 1300.75, 2, 11, 'Activo')
        ");
    }

    public function getDependencies(): array
    {
        return [
            UserFixture::class,
            MemberFixture::class, // si tienes esta entidad
            MonthFixture::class,
            YearFixture::class,
        ];
    }
}
