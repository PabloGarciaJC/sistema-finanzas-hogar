<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CreditFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // Obtener EntityManager a partir del ObjectManager
        $em = $manager instanceof EntityManagerInterface ? $manager : null;

        if ($em === null) {
            throw new \RuntimeException('EntityManager no disponible');
        }

        $conn = $em->getConnection();

        $conn->executeStatement("
            INSERT INTO `credit` (`id`, `user_id`, `member_id`, `installments`, `bank_entity`, `total_amount`, `installment_amount`, `frequency`, `month`, `year`, `remaining_amount`, `status`) VALUES
            (1, 1, 1, 10, 'BBVA', 8000.00, 50.00, 'Mensual', 1, 11, 8000.00, 'Activo'),
            (2, 1, 1, 10, 'Santander', 6000.00, 50.00, 'Mensual', 2, 11, 6000.00, 'Activo'),
            (3, 1, 1, 10, 'HSBC', 5000.00, 50.00, 'Mensual', 3, 11, 5000.00, 'Cancelado'),
            (4, 1, 1, 10, 'Banorte', 7000.00, 50.00, 'Mensual', 4, 11, 7000.00, 'Activo'),
            (5, 1, 1, 10, 'Scotiabank', 4500.00, 50.00, 'Mensual', 5, 11, 4500.00, 'Activo'),
            (6, 2, 1, 10, 'BBVA', 9000.00, 50.00, 'Mensual', 1, 11, 9000.00, 'Activo'),
            (7, 2, 1, 10, 'Santander', 5500.00, 50.00, 'Mensual', 2, 11, 5500.00, 'Activo'),
            (8, 2, 1, 10, 'HSBC', 4000.00, 50.00, 'Mensual', 3, 11, 4000.00, 'Activo'),
            (9, 2, 1, 10, 'Banorte', 6500.00, 50.00, 'Mensual', 4, 11, 6500.00, 'Activo'),
            (10, 2, 1, 10, 'Scotiabank', 5000.00, 50.00, 'Mensual', 5, 11, 5000.00, 'Activo'),
            (11, 1, 2, 1, 'Banco Uno', 5000.00, 60.00, 'Mensual', 1, 11, NULL, 'Activo');
        ");
    }

    public function getDependencies(): array
    {
        return [
            MemberFixture::class,
            UserFixture::class,
        ];
    }
}
