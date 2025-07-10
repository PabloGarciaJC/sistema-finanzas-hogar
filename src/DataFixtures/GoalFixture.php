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
            INSERT INTO `goal` (`id`, `user_id`, `member_id`, `amount`, `description`, `month`, `year`, `payment_day`, `status`) VALUES
            (1, 1, 1, 50.00, '<div>Compra de cuaderno extra</div>', 1, 11, 5, 'Activo'),
            (2, 1, 1, 80.00, '<div>Reparar llave que gotea</div>', 2, 11, 10, 'Activo'),
            (3, 1, 2, 75.00, '<div>Comprar focos de repuesto</div>', 3, 11, 15, 'Activo'),
            (4, 1, 2, 90.00, '<div>Pagar limpieza de ventana</div>', 4, 11, 20, 'Activo'),
            (5, 1, 1, 60.00, '<div>Comprar toallas nuevas</div>', 5, 11, 8, 'Activo'),
            (6, 2, 1, 70.00, 'Compra de escoba y recogedor', 1, 11, 5, 'Activo'),
            (7, 2, 1, 95.00, 'Arreglo de enchufe suelto', 2, 11, 10, 'Activo'),
            (8, 2, 2, 85.00, 'Comprar plantas pequeñas', 3, 11, 15, 'Activo'),
            (9, 2, 2, 55.00, 'Cambio de bombillo de cocina', 4, 11, 20, 'Activo'),
            (10, 2, 1, 65.00, 'Compra de jabones y detergente', 5, 11, 8, 'Activo');
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
