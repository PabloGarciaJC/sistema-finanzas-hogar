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
            INSERT INTO goal (user_id, member_id, amount, description, month, year, payment_day, status) VALUES
            (1, 1, 10000.00, '<div>Meta de ahorro anual</div>', 1, 11, 5, 'Activo'),
            (1, 1, 5000.00, '<div>Fondo de emergencia</div>', 2, 11, 10, 'Activo'),
            (1, 2, 3000.00, '<div>Ahorro vacaciones</div>', 3, 11, 15, 'Activo'),
            (1, 2, 8000.00, '<div>Compra de equipo</div>', 4, 11, 20, 'Activo')
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
