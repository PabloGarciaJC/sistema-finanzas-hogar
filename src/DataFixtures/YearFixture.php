<?php

namespace App\DataFixtures;

use App\Entity\Year;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class YearFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $currentYear = (int) date('Y');

        for ($year = 2015; $year <= 2035; $year++) {
            $yearEntity = new Year();
            $yearEntity->setYear($year);
            $yearEntity->setStatus($year === $currentYear ? 1 : 0);
            $manager->persist($yearEntity);
        }

        $manager->flush();
    }
}
