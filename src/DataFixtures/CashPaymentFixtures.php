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
            INSERT INTO `cash_payment` (`id`, `user_id`, `member_id`, `amount`, `description`, `month`, `year`, `payment_day`, `status`, `is_default`, `is_paid`) VALUES
            (1, 1, 1, 150.00, 'Reparaciones del hogar', 1, 1, 5, 1, 1, 0),
            (2, 1, 2, 85.00, 'Compra de materiales de limpieza', 1, 1, 10, 1, 1, 0),
            (3, 1, 1, 220.00, 'Fontanería', 1, 1, 15, 1, 1, 0),
            (4, 1, 2, 95.00, 'Jardinería', 1, 1, 20, 1, 1, 0),
            (5, 1, 1, 60.00, 'Alimentos de emergencia', 1, 1, 8, 1, 1, 0),
            (6, 1, 1, 180.00, 'Pintura de paredes', 1, 1, 12, 1, 1, 0),
            (7, 1, 2, 130.00, 'Mano de obra doméstica', 1, 1, 18, 1, 1, 0),
            (8, 1, 1, 90.00, 'Limpieza profunda', 1, 1, 22, 1, 1, 0),
            (9, 1, 2, 110.00, 'Transporte de muebles', 1, 1, 25, 1, 1, 0),
            (10, 1, 1, 75.00, 'Compra de utensilios', 1, 1, 28, 1, 1, 0);
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
