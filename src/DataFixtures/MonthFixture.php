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
            ['Enero', 1],
            ['Febrero', 2],
            ['Marzo', 3],
            ['Abril', 4],
            ['Mayo', 5],
            ['Junio', 6],
            ['Julio', 7],
            ['Agosto', 8],
            ['Septiembre', 9],
            ['Octubre', 10],
            ['Noviembre', 11],
            ['Diciembre', 12],
        ];

        foreach ($months as [$name, $number]) {
            $month = new Month();
            $month->setName($name);
            $month->setNumber($number);
            $manager->persist($month);
        }

        $manager->flush();
    }
}
