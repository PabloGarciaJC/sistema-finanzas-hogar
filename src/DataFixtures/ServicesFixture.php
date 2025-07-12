<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ServicesFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $em = $manager instanceof EntityManagerInterface ? $manager : null;

        if ($em === null) {
            throw new \RuntimeException('EntityManager no disponible');
        }

        $conn = $em->getConnection();

        $conn->executeStatement("
            INSERT INTO `services` (`id`, `user_id`, `member_id`, `amount`, `description`, `status`) VALUES
            (1, 1, 1, 120.00, 'Electricidad', 1),
            (2, 1, 1, 80.00, 'Agua potable', 1),
            (3, 1, 1, 50.00, 'Gas', 1),
            (4, 1, 2, 75.00, 'Internet', 1),
            (5, 1, 2, 60.00, 'Televisión por cable', 1),
            (6, 1, 1, 90.00, 'Recolección de basura', 1),
            (7, 1, 2, 110.00, 'Teléfono fijo', 1),
            (8, 1, 1, 130.00, 'Mantenimiento de áreas comunes', 1),
            (9, 1, 2, 140.00, 'Seguridad privada', 1),
            (10, 1, 1, 500.00, 'Alquiler o hipoteca', 1);
        ");
    }

    public function getDependencies(): array
    {
        return [
            UserFixture::class,
            MemberFixture::class,
        ];
    }
}
