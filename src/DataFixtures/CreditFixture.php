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
            INSERT INTO `credit` (`id`, `user_id`, `member_id`, `bank_entity`, `total_amount`, `installment_amount`, `frequency`, `remaining_amount`, `status`) VALUES
            (1, 1, 1, 'BBVA', 8000.00, 50.00, 'Mensual', 8000.00, 1),
            (2, 1, 1, 'Santander', 6000.00, 50.00, 'Mensual', 6000.00, 1),
            (3, 1, 1, 'HSBC', 5000.00, 50.00, 'Mensual', 5000.00, 1),
            (4, 1, 1, 'Banorte', 7000.00, 50.00, 'Mensual', 7000.00, 1),
            (5, 1, 1, 'Scotiabank', 4500.00, 50.00, 'Mensual', 4500.00, 1),
            (6, 1, 1, 'BBVA', 9000.00, 50.00, 'Mensual', 9000.00, 1),
            (7, 1, 1, 'Santander', 5500.00, 50.00, 'Mensual', 5500.00, 1),
            (8, 1, 1, 'HSBC', 4000.00, 50.00, 'Mensual', 4000.00, 1),
            (9, 1, 1, 'Banorte', 6500.00, 50.00, 'Mensual', 6500.00, 1),
            (10, 1, 1, 'Scotiabank', 5000.00, 50.00, 'Mensual', 5000.00, 1),
            (11, 1, 2, 'Banco Uno', 5000.00, 60.00, 'Mensual', NULL, 1);
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
