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

        $yearEntity = new Year();
        $yearEntity->setYear($currentYear);
        $yearEntity->setStatus(1); // Activo

        $manager->persist($yearEntity);

        $manager->flush();
    }
}
