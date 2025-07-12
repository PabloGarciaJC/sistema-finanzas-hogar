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
            INSERT INTO `monthly_summary` 
                (`user_id`, `month`, `year`, `total_income`, `savings`, `debt_total`) 
            VALUES
                (1, 1, 1, 2500.00, 500.00, 1200.00),
                (1, 2, 1, 2600.00, 550.00, 1150.00),
                (1, 3, 1, 3000.00, 800.00, 1000.00)
        ");
    }

    public function getDependencies(): array
    {
        return [
            UserFixture::class,
        ];
    }
}
