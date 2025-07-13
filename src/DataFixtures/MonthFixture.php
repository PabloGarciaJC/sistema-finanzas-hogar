<?php

namespace App\DataFixtures;

use App\Entity\Month;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MonthFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $months = [
            'Enero',
            'Febrero',
            'Marzo',
            'Abril',
            'Mayo',
            'Junio',
            'Julio',
            'Agosto',
            'Septiembre',
            'Octubre',
            'Noviembre',
            'Diciembre',
        ];

        foreach ($months as $name) {
            $month = new Month();
            $month->setName($name);
            $month->setStatus(true);
            $manager->persist($month);
        }

        $manager->flush();
    }
}
