<?php

namespace App\DataFixtures;

use App\Entity\Currency;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CurrencyFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $currencies = [
            ['USD', 'Dólar estadounidense', '$'],
            ['EUR', 'Euro', '€'],
            ['PEN', 'Sol peruano', 'S/.'],
            ['MXN', 'Peso mexicano', '$'],
            ['CLP', 'Peso chileno', '$'],
            ['COP', 'Peso colombiano', '$'],
            ['ARS', 'Peso argentino', '$'],
        ];

        foreach ($currencies as [$code, $name, $symbol]) {
            $currency = new Currency();
            $currency->setCode($code);
            $currency->setName($name);
            $currency->setSymbol($symbol);

            $manager->persist($currency);
        }

        $manager->flush();
    }
}
