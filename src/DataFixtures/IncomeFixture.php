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
            INSERT INTO income (user_id, member_id, amount, date, status) VALUES
            (1, 1, 1500.00, '2025-01-15', 'Activo'),
            (1, 2, 2000.00, '2025-01-20', 'Activo'),
            (1, 3, 1800.00, '2025-02-10', 'Activo'),
            (1, 4, 2200.00, '2025-02-25', 'Cancelado'),
            (1, 1, 1600.00, '2025-03-05', 'Activo'),
            (1, 2, 1700.00, '2025-03-15', 'Activo')
        ");
    }

    public function getDependencies(): array
    {
        return [
            UserFixture::class,
            MemberFixture::class,
        ];
    }
}
