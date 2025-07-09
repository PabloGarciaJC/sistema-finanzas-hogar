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
            INSERT INTO monthly_summary (
                user_id, 
                month, 
                year, 
                total_income, 
                savings, 
                debt_total, 
                bank_balance,
                services,
                cash_payment,
                credit,
                goal
            ) VALUES
            (
                1, 1, 11, 5000.00, 500.00, 2000.00,
                '[{\"memberName\":\"maria\",\"bankBalance\":1200.00},{\"memberName\":\"pepe\",\"bankBalance\":1500.00}]',
                '[{\"memberName\":\"maria\",\"services\":500.00},{\"memberName\":\"pepe\",\"services\":600.00}]',
                '[{\"memberName\":\"maria\",\"cashPayment\":200.00},{\"memberName\":\"pepe\",\"cashPayment\":250.00}]',
                '[{\"memberName\":\"maria\",\"credit\":300.00},{\"memberName\":\"pepe\",\"credit\":350.00}]',
                '[{\"memberName\":\"maria\",\"goal\":200.00},{\"memberName\":\"pepe\",\"goal\":300.00}]'
            ),
            (
                1, 2, 11, 5200.00, 600.00, 1800.00,
                '[{\"memberName\":\"maria\",\"bankBalance\":1300.00},{\"memberName\":\"pepe\",\"bankBalance\":1550.00}]',
                '[{\"memberName\":\"maria\",\"services\":550.00},{\"memberName\":\"pepe\",\"services\":650.00}]',
                '[{\"memberName\":\"maria\",\"cashPayment\":210.00},{\"memberName\":\"pepe\",\"cashPayment\":260.00}]',
                '[{\"memberName\":\"maria\",\"credit\":310.00},{\"memberName\":\"pepe\",\"credit\":360.00}]',
                '[{\"memberName\":\"maria\",\"goal\":230.00},{\"memberName\":\"pepe\",\"goal\":280.00}]'
            )
        ");
    }

    public function getDependencies(): array
    {
        return [
            UserFixture::class,
        ];
    }
}
