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
            (1, 1, 1, 10, 'BBVA', 8000.00, 50.00, 'Mensual', 1, 1, 8000.00, 1),
            (2, 1, 1, 10, 'Santander', 6000.00, 50.00, 'Mensual', 2, 1, 6000.00, 1),
            (3, 1, 1, 10, 'HSBC', 5000.00, 50.00, 'Mensual', 3, 1, 5000.00, 1),
            (4, 1, 1, 10, 'Banorte', 7000.00, 50.00, 'Mensual', 4, 1, 7000.00, 1),
            (5, 1, 1, 10, 'Scotiabank', 4500.00, 50.00, 'Mensual', 5, 1, 4500.00, 1),
            (6, 1, 1, 10, 'BBVA', 9000.00, 50.00, 'Mensual', 1, 1, 9000.00, 1),
            (7, 1, 1, 10, 'Santander', 5500.00, 50.00, 'Mensual', 2, 1, 5500.00, 1),
            (8, 1, 1, 10, 'HSBC', 4000.00, 50.00, 'Mensual', 3, 1, 4000.00, 1),
            (9, 1, 1, 10, 'Banorte', 6500.00, 50.00, 'Mensual', 4, 1, 6500.00, 1),
            (10, 1, 1, 10, 'Scotiabank', 5000.00, 50.00, 'Mensual', 5, 1, 5000.00, 1),
            (11, 1, 2, 1, 'Banco Uno', 5000.00, 60.00, 'Mensual', 1, 1, NULL, 1);
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
