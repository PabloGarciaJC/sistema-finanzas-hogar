<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class MonthlySummaryFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $em = $manager instanceof EntityManagerInterface ? $manager : null;

        if ($em === null) {
            throw new \RuntimeException('EntityManager no disponible');
        }

        $conn = $em->getConnection();

        $conn->executeStatement("
            INSERT INTO monthly_summary (user_id, month, year, total_income, savings, debt_total) VALUES
            (1, 1, 11, 5000.00, 500.00, 2000.00),
            (1, 2, 11, 5200.00, 600.00, 1800.00),
            (1, 1, 11, 4500.00, 400.00, 1500.00),
            (1, 2, 11, 4700.00, 450.00, 1600.00)
        ");
    }

    public function getDependencies(): array
    {
        return [
            UserFixture::class,
        ];
    }
}
