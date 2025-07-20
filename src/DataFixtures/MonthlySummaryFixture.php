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
            INSERT INTO `monthly_summary` (`id`, `user_id`, `month`, `year`, `total_income`, `savings`, `debt_total`) VALUES
            (15, 1, 1, 1, 4800.00, 965.00, 3835.00),
            (16, 1, 2, 1, 5800.00, 1965.00, 3835.00),
            (17, 1, 3, 1, 5000.00, 1165.00, 3835.00),
            (18, 1, 4, 1, 4800.00, 965.00, 3835.00),
            (19, 1, 5, 1, 4800.00, 965.00, 3835.00),
            (20, 1, 6, 1, 4800.00, 965.00, 3835.00),
            (21, 1, 7, 1, 4800.00, 965.00, 3835.00),
            (22, 1, 8, 1, 4800.00, 965.00, 3835.00),
            (23, 1, 9, 1, 4800.00, 965.00, 3835.00),
            (24, 1, 10, 1, 4800.00, 965.00, 3835.00),
            (25, 1, 11, 1, 4800.00, 965.00, 3835.00),
            (26, 1, 12, 1, 4800.00, 965.00, 3835.00);
        ");
    }

    public function getDependencies(): array
    {
        return [
            UserFixture::class,
        ];
    }
}
