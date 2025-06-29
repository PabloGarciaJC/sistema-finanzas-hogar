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
            (1, 1, 120.00, '<div>Pago mensual de mantenimiento</div>', 1, 11, 5, 'Activo'),
            (1, 1, 80.00, '<div>Servicio de limpieza</div>', 2, 11, 10, 'Activo'),
            (1, 1, 50.00, '<div>Gasto de papelería</div>', 3, 11, 15, 'Activo'),
            (1, 2, 200.00, '<div>Renovación anual</div>', 4, 11, 20, 'Activo'),
            (1, 2, 75.00, '<div>Pago de internet</div>', 5, 11, 5, 'Activo'),
            (1, 1, 90.00, '<div>Servicio de jardinería</div>', 6, 11, 12, 'Activo'),
            (1, 2, 110.00, '<div>Servicio de vigilancia</div>', 7, 11, 18, 'Activo'),
            (1, 1, 60.00, '<div>Pago de electricidad</div>', 8, 11, 8, 'Activo'),
            (1, 2, 45.00, '<div>Pago de agua</div>', 9, 11, 22, 'Activo'),
            (1, 1, 55.00, '<div>Mantenimiento de equipos</div>', 10, 11, 17, 'Activo'),
            (1, 2, 125.00, '<div>Servicio de soporte</div>', 11, 11, 25, 'Activo'),
            (1, 1, 140.00, '<div>Pago de alquiler</div>', 12, 11, 30, 'Activo'),
            (1, 2, 95.00, '<div>Compra de insumos</div>', 1, 11, 15, 'Activo'),
            (1, 1, 85.00, '<div>Gasto de publicidad</div>', 2, 11, 28, 'Activo'),
            (1, 1, 150.50, '<div>Soporte técnico mensual</div>', 1, 11, 8, 'Activo'),
            (1, 2, 300.00, '<div>Consultoría empresarial</div>', 2, 11, 12, 'Activo'),
            (1, 2, 50.00, '<div>Gasto administrativo</div>', 3, 11, 20, 'Activo'),
            (1, 1, 100.00, '<div>Asesoría contable</div>', 4, 11, 10, 'Activo'),
            (1, 2, 90.00, '<div>Pago de hosting</div>', 5, 11, 5, 'Activo'),
            (1, 1, 120.00, '<div>Dominio web</div>', 6, 11, 18, 'Activo'),
            (1, 2, 60.00, '<div>Suscripción de software</div>', 7, 11, 9, 'Activo'),
            (1, 1, 80.00, '<div>Licencia de antivirus</div>', 8, 11, 14, 'Activo'),
            (1, 2, 70.00, '<div>Pago de mantenimiento</div>', 9, 11, 22, 'Activo'),
            (1, 1, 130.00, '<div>Soporte remoto</div>', 10, 11, 5, 'Activo'),
            (1, 2, 140.00, '<div>Servicio de capacitación</div>', 11, 11, 11, 'Activo')
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
