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
            INSERT INTO goal (user_id, member_id, description, target_amount, frequency, start_date, status) VALUES
            (1, 1, 'Meta de ahorro para vacaciones', 5000.00, 'Mensual', '2024-01-01', 'In progress'),
            (1, 2, 'Meta de inversión en negocio', 20000.00, 'Mensual', '2024-02-01', 'In progress'),
            (1, 3, 'Meta de compra de auto', 15000.00, 'Mensual', '2024-03-01', 'In progress'),
            (1, 4, 'Meta de educación hijos', 10000.00, 'Mensual', '2024-04-01', 'In progress')
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
