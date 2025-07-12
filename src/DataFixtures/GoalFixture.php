<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class GoalFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $em = $manager instanceof EntityManagerInterface ? $manager : null;

        if ($em === null) {
            throw new \RuntimeException('EntityManager no disponible');
        }

        $conn = $em->getConnection();

        $conn->executeStatement("
            INSERT INTO `goal` (`id`, `user_id`, `member_id`, `amount`, `description`, `status`) VALUES
            (1, 1, 1, 50.00, 'Compra de cuaderno extra', 1),
            (2, 1, 1, 80.00, 'Reparar llave que gotea', 1),
            (3, 1, 2, 75.00, 'Comprar focos de repuesto', 1),
            (4, 1, 2, 90.00, 'Pagar limpieza de ventana', 1),
            (5, 1, 1, 60.00, 'Comprar toallas nuevas', 1),
            (6, 1, 1, 70.00, 'Compra de escoba y recogedor', 1),
            (7, 1, 1, 95.00, 'Arreglo de enchufe suelto', 1),
            (8, 1, 2, 85.00, 'Comprar plantas pequeñas', 1),
            (9, 1, 2, 55.00, 'Cambio de bombillo de cocina', 1),
            (10, 1, 1, 65.00, 'Compra de jabones y detergente', 1);
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
