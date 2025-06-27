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
        $em = $manager instanceof EntityManagerInterface ? $manager : null;

        if ($em === null) {
            throw new \RuntimeException('EntityManager no disponible');
        }

        $conn = $em->getConnection();

        $conn->executeStatement("
            INSERT INTO credit (member_id, user_id, bank_entity, total_amount, installment_amount, installments, frequency, start_date, remaining_amount, status)
            VALUES 
                (1, 1, 'Banco Uno', 5000.00, 500.00, 10, 'Mensual', '2025-01-01', 5000.00, 'Activo'),
                (2, 1, 'Banco Dos', 3000.00, 300.00, 10, 'Mensual', '2025-02-01', 3000.00, 'Activo'),
                (3, 1, 'Banco Tres', 2000.00, 200.00, 10, 'Mensual', '2025-03-01', 2000.00, 'Activo'),
                (4, 1, 'Banco Cuatro', 1000.00, 100.00, 10, 'Mensual', '2025-04-01', 1000.00, 'Activo')
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
