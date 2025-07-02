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
            (1, 1, 150.00, 'Reparaciones del hogar', 1, 11, 5, 'Activo'),
            (1, 2, 85.00, 'Compra de materiales de limpieza', 1, 11, 8, 'Activo'),
            (1, 1, 220.00, 'Fontanería', 1, 11, 10, 'Activo'),
            (1, 2, 95.00, 'Jardinería', 1, 11, 12, 'Activo'),
            (1, 1, 60.00, 'Alimentos de emergencia', 1, 11, 15, 'Activo'),
            (2, 1, 180.00, 'Pintura de paredes', 1, 11, 18, 'Activo'),
            (2, 2, 130.00, 'Mano de obra doméstica', 1, 11, 20, 'Activo'),
            (2, 1, 90.00, 'Limpieza profunda', 1, 11, 22, 'Activo'),
            (2, 2, 110.00, 'Transporte de muebles', 1, 11, 24, 'Activo'),
            (2, 1, 75.00, 'Compra de utensilios', 1, 11, 26, 'Activo')
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
