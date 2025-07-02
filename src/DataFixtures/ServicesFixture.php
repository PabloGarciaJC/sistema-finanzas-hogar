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
            INSERT INTO services (user_id, member_id, amount, description, month, year, payment_day, status) VALUES
            (1, 1, 120.00, '<div>Electricidad</div>', 1, 11, 5, 'Activo'),
            (1, 1, 80.00, '<div>Agua potable</div>', 1, 11, 10, 'Activo'),
            (1, 1, 50.00, '<div>Gas</div>', 1, 11, 15, 'Activo'),
            (1, 2, 75.00, '<div>Internet</div>', 1, 11, 20, 'Activo'),
            (1, 2, 60.00, '<div>Televisión por cable</div>', 1, 11, 5, 'Activo'),
            (1, 1, 90.00, '<div>Recolección de basura</div>', 1, 11, 12, 'Activo'),
            (1, 2, 110.00, '<div>Teléfono fijo</div>', 1, 11, 18, 'Activo'),
            (1, 1, 130.00, '<div>Mantenimiento de áreas comunes</div>', 1, 11, 8, 'Activo'),
            (1, 2, 140.00, '<div>Seguridad privada</div>', 1, 11, 22, 'Activo'),
            (1, 1, 500.00, '<div>Alquiler o hipoteca</div>', 1, 11, 17, 'Activo')
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
