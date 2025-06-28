<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CashPaymentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $em = $manager instanceof EntityManagerInterface ? $manager : null;

        if ($em === null) {
            throw new \RuntimeException('EntityManager no disponible');
        }

        $conn = $em->getConnection();

        $conn->executeStatement("
            INSERT INTO cash_payment (user_id, member_id, amount, description, month, year, payment_day, status) VALUES
            (1, 1, 150.00, 'Pago en efectivo por servicios varios', 6, 2025, 5, 'Activo'),
            (1, 2, 75.00, 'Pago en efectivo por materiales', 6, 2025, 10, 'Activo'),
            (2, 1, 200.00, 'Pago en efectivo soporte técnico', 6, 2025, 15, 'Activo'),
            (2, 2, 100.00, 'Pago en efectivo consultoría', 6, 2025, 20, 'Activo'),
            (1, 1, 50.00, 'Pago en efectivo extras', 6, 2025, 25, 'Activo')
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
