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
            INSERT INTO `cash_payment` (`id`, `user_id`, `member_id`, `amount`, `description`, `status`) VALUES
            (1, 1, 1, 150.00, 'Reparaciones del hogar', 1),
            (2, 1, 2, 85.00, 'Compra de materiales de limpieza', 1),
            (3, 1, 1, 220.00, 'Fontanería', 1),
            (4, 1, 2, 95.00, 'Jardinería', 1),
            (5, 1, 1, 60.00, 'Alimentos de emergencia', 1),
            (6, 1, 1, 180.00, 'Pintura de paredes', 1),
            (7, 1, 2, 130.00, 'Mano de obra doméstica', 1),
            (8, 1, 1, 90.00, 'Limpieza profunda', 1),
            (9, 1, 2, 110.00, 'Transporte de muebles', 1),
            (10, 1, 1, 75.00, 'Compra de utensilios', 1);
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
