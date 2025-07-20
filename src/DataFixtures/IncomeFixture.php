<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class IncomeFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $em = $manager instanceof EntityManagerInterface ? $manager : null;

        if ($em === null) {
            throw new \RuntimeException('EntityManager no disponible');
        }

        $conn = $em->getConnection();

        $conn->executeStatement("
            INSERT INTO `income` (`id`, `user_id`, `member_id`, `amount`, `month`, `year`, `status`, `is_default`) VALUES
            (21, 1, 1, 2500.00, 1, 1, 1, 1),
            (22, 1, 2, 2300.00, 1, 1, 1, 1),
            (29, 1, 1, 2500.00, 2, 1, 1, 0),
            (30, 1, 2, 3300.00, 2, 1, 1, 0),
            (31, 1, 1, 2000.00, 3, 1, 1, 0),
            (32, 1, 2, 3000.00, 3, 1, 1, 0),
            (33, 1, 1, 2500.00, 4, 1, 1, 0),
            (34, 1, 2, 2300.00, 4, 1, 1, 0),
            (35, 1, 1, 2500.00, 5, 1, 1, 0),
            (36, 1, 2, 2300.00, 5, 1, 1, 0),
            (37, 1, 1, 2500.00, 6, 1, 1, 0),
            (38, 1, 2, 2300.00, 6, 1, 1, 0),
            (39, 1, 1, 2500.00, 7, 1, 1, 0),
            (40, 1, 2, 2300.00, 7, 1, 1, 0),
            (41, 1, 1, 2500.00, 8, 1, 1, 0),
            (42, 1, 2, 2300.00, 8, 1, 1, 0),
            (43, 1, 1, 2500.00, 9, 1, 1, 0),
            (44, 1, 2, 2300.00, 9, 1, 1, 0),
            (45, 1, 1, 2500.00, 10, 1, 1, 0),
            (46, 1, 2, 2300.00, 10, 1, 1, 0),
            (47, 1, 1, 2500.00, 11, 1, 1, 0),
            (48, 1, 2, 2300.00, 11, 1, 1, 0),
            (49, 1, 1, 2500.00, 12, 1, 1, 0),
            (50, 1, 2, 2300.00, 12, 1, 1, 0);
        ");
    }

    public function getDependencies(): array
    {
        return [
            UserFixture::class,
            MemberFixture::class,
            MonthFixture::class,
            YearFixture::class,
        ];
    }
}
