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
            INSERT INTO credit (
                member_id, user_id, bank_entity, total_amount, installment_amount, installments, frequency, month, year, remaining_amount, status
            ) VALUES 
                (1, 1, 'BBVA', 8000.00, 50.00, 10, 'Mensual', 1, 11, 8000.00, 'Activo'),
                (1, 1, 'Santander', 6000.00, 50.00, 10, 'Mensual', 2, 11, 6000.00, 'Activo'),
                (1, 1, 'HSBC', 5000.00, 50.00, 10, 'Mensual', 3, 11, 5000.00, 'Activo'),
                (1, 1, 'Banorte', 7000.00, 50.00, 10, 'Mensual', 4, 11, 7000.00, 'Activo'),
                (1, 1, 'Scotiabank', 4500.00, 50.00, 10, 'Mensual', 5, 11, 4500.00, 'Activo'),
                (1, 2, 'BBVA', 9000.00, 50.00, 10, 'Mensual', 1, 11, 9000.00, 'Activo'),
                (1, 2, 'Santander', 5500.00, 50.00, 10, 'Mensual', 2, 11, 5500.00, 'Activo'),
                (1, 2, 'HSBC', 4000.00, 50.00, 10, 'Mensual', 3, 11, 4000.00, 'Activo'),
                (1, 2, 'Banorte', 6500.00, 50.00, 10, 'Mensual', 4, 11, 6500.00, 'Activo'),
                (1, 2, 'Scotiabank', 5000.00, 50.00, 10, 'Mensual', 5, 11, 5000.00, 'Activo')
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
