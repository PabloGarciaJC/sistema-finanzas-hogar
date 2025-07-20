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
            INSERT INTO `services` (`id`, `user_id`, `member_id`, `amount`, `description`, `month`, `year`, `payment_day`, `status`, `is_default`, `is_paid`) VALUES
            (1, 1, 1, 120.00, 'Electricidad', 1, 1, 5, 1, 1, 0),
            (2, 1, 1, 80.00, 'Agua potable', 1, 1, 10, 1, 1, 0),
            (3, 1, 1, 50.00, 'Gas', 1, 1, 15, 1, 1, 0),
            (4, 1, 2, 75.00, 'Internet', 1, 1, 20, 1, 1, 0),
            (5, 1, 2, 60.00, 'Televisión por cable', 1, 1, 5, 1, 1, 0),
            (6, 1, 1, 90.00, 'Recolección de basura', 1, 1, 12, 1, 1, 0),
            (7, 1, 2, 110.00, 'Teléfono fijo', 1, 1, 18, 1, 1, 0),
            (8, 1, 1, 130.00, 'Mantenimiento de áreas comunes', 1, 1, 8, 1, 1, 0),
            (9, 1, 2, 140.00, 'Seguridad privada', 1, 1, 22, 1, 1, 0),
            (10, 1, 1, 500.00, 'Alquiler o hipoteca', 1, 1, 17, 1, 1, 0),
            (61, 1, 1, 120.00, 'Electricidad', 2, 1, 5, 1, 0, 0),
            (62, 1, 1, 80.00, 'Agua potable', 2, 1, 10, 1, 0, 0),
            (63, 1, 1, 50.00, 'Gas', 2, 1, 15, 1, 0, 0),
            (64, 1, 2, 75.00, 'Internet', 2, 1, 20, 1, 0, 0),
            (65, 1, 2, 60.00, 'Televisión por cable', 2, 1, 5, 1, 0, 0),
            (66, 1, 1, 90.00, 'Recolección de basura', 2, 1, 12, 1, 0, 0),
            (67, 1, 2, 110.00, 'Teléfono fijo', 2, 1, 18, 1, 0, 0),
            (68, 1, 1, 130.00, 'Mantenimiento de áreas comunes', 2, 1, 8, 1, 0, 0),
            (69, 1, 2, 140.00, 'Seguridad privada', 2, 1, 22, 1, 0, 0),
            (70, 1, 1, 500.00, 'Alquiler o hipoteca', 2, 1, 17, 1, 0, 0),
            (71, 1, 1, 120.00, 'Electricidad', 3, 1, 5, 1, 0, 0),
            (72, 1, 1, 80.00, 'Agua potable', 3, 1, 10, 1, 0, 0),
            (73, 1, 1, 50.00, 'Gas', 3, 1, 15, 1, 0, 0),
            (74, 1, 2, 75.00, 'Internet', 3, 1, 20, 1, 0, 0),
            (75, 1, 2, 60.00, 'Televisión por cable', 3, 1, 5, 1, 0, 0),
            (76, 1, 1, 90.00, 'Recolección de basura', 3, 1, 12, 1, 0, 0),
            (77, 1, 2, 110.00, 'Teléfono fijo', 3, 1, 18, 1, 0, 0),
            (78, 1, 1, 130.00, 'Mantenimiento de áreas comunes', 3, 1, 8, 1, 0, 0),
            (79, 1, 2, 140.00, 'Seguridad privada', 3, 1, 22, 1, 0, 0),
            (80, 1, 1, 500.00, 'Alquiler o hipoteca', 3, 1, 17, 1, 0, 0),
            (81, 1, 1, 120.00, 'Electricidad', 4, 1, 5, 1, 0, 0),
            (82, 1, 1, 80.00, 'Agua potable', 4, 1, 10, 1, 0, 0),
            (83, 1, 1, 50.00, 'Gas', 4, 1, 15, 1, 0, 0),
            (84, 1, 2, 75.00, 'Internet', 4, 1, 20, 1, 0, 0),
            (85, 1, 2, 60.00, 'Televisión por cable', 4, 1, 5, 1, 0, 0),
            (86, 1, 1, 90.00, 'Recolección de basura', 4, 1, 12, 1, 0, 0),
            (87, 1, 2, 110.00, 'Teléfono fijo', 4, 1, 18, 1, 0, 0),
            (88, 1, 1, 130.00, 'Mantenimiento de áreas comunes', 4, 1, 8, 1, 0, 0),
            (89, 1, 2, 140.00, 'Seguridad privada', 4, 1, 22, 1, 0, 0),
            (90, 1, 1, 500.00, 'Alquiler o hipoteca', 4, 1, 17, 1, 0, 0),
            (91, 1, 1, 120.00, 'Electricidad', 5, 1, 5, 1, 0, 0),
            (92, 1, 1, 80.00, 'Agua potable', 5, 1, 10, 1, 0, 0),
            (93, 1, 1, 50.00, 'Gas', 5, 1, 15, 1, 0, 0),
            (94, 1, 2, 75.00, 'Internet', 5, 1, 20, 1, 0, 0),
            (95, 1, 2, 60.00, 'Televisión por cable', 5, 1, 5, 1, 0, 0),
            (96, 1, 1, 90.00, 'Recolección de basura', 5, 1, 12, 1, 0, 0),
            (97, 1, 2, 110.00, 'Teléfono fijo', 5, 1, 18, 1, 0, 0),
            (98, 1, 1, 130.00, 'Mantenimiento de áreas comunes', 5, 1, 8, 1, 0, 0),
            (99, 1, 2, 140.00, 'Seguridad privada', 5, 1, 22, 1, 0, 0),
            (100, 1, 1, 500.00, 'Alquiler o hipoteca', 5, 1, 17, 1, 0, 0),
            (101, 1, 1, 120.00, 'Electricidad', 6, 1, 5, 1, 0, 0),
            (102, 1, 1, 80.00, 'Agua potable', 6, 1, 10, 1, 0, 0),
            (103, 1, 1, 50.00, 'Gas', 6, 1, 15, 1, 0, 0),
            (104, 1, 2, 75.00, 'Internet', 6, 1, 20, 1, 0, 0),
            (105, 1, 2, 60.00, 'Televisión por cable', 6, 1, 5, 1, 0, 0),
            (106, 1, 1, 90.00, 'Recolección de basura', 6, 1, 12, 1, 0, 0),
            (107, 1, 2, 110.00, 'Teléfono fijo', 6, 1, 18, 1, 0, 0),
            (108, 1, 1, 130.00, 'Mantenimiento de áreas comunes', 6, 1, 8, 1, 0, 0),
            (109, 1, 2, 140.00, 'Seguridad privada', 6, 1, 22, 1, 0, 0),
            (110, 1, 1, 500.00, 'Alquiler o hipoteca', 6, 1, 17, 1, 0, 0),
            (111, 1, 1, 120.00, 'Electricidad', 7, 1, 5, 1, 0, 0),
            (112, 1, 1, 80.00, 'Agua potable', 7, 1, 10, 1, 0, 0),
            (113, 1, 1, 50.00, 'Gas', 7, 1, 15, 1, 0, 0),
            (114, 1, 2, 75.00, 'Internet', 7, 1, 20, 1, 0, 0),
            (115, 1, 2, 60.00, 'Televisión por cable', 7, 1, 5, 1, 0, 0),
            (116, 1, 1, 90.00, 'Recolección de basura', 7, 1, 12, 1, 0, 0),
            (117, 1, 2, 110.00, 'Teléfono fijo', 7, 1, 18, 1, 0, 0),
            (118, 1, 1, 130.00, 'Mantenimiento de áreas comunes', 7, 1, 8, 1, 0, 0),
            (119, 1, 2, 140.00, 'Seguridad privada', 7, 1, 22, 1, 0, 0),
            (120, 1, 1, 500.00, 'Alquiler o hipoteca', 7, 1, 17, 1, 0, 0),
            (121, 1, 1, 120.00, 'Electricidad', 8, 1, 5, 1, 0, 0),
            (122, 1, 1, 80.00, 'Agua potable', 8, 1, 10, 1, 0, 0),
            (123, 1, 1, 50.00, 'Gas', 8, 1, 15, 1, 0, 0),
            (124, 1, 2, 75.00, 'Internet', 8, 1, 20, 1, 0, 0),
            (125, 1, 2, 60.00, 'Televisión por cable', 8, 1, 5, 1, 0, 0),
            (126, 1, 1, 90.00, 'Recolección de basura', 8, 1, 12, 1, 0, 0),
            (127, 1, 2, 110.00, 'Teléfono fijo', 8, 1, 18, 1, 0, 0),
            (128, 1, 1, 130.00, 'Mantenimiento de áreas comunes', 8, 1, 8, 1, 0, 0),
            (129, 1, 2, 140.00, 'Seguridad privada', 8, 1, 22, 1, 0, 0),
            (130, 1, 1, 500.00, 'Alquiler o hipoteca', 8, 1, 17, 1, 0, 0),
            (131, 1, 1, 120.00, 'Electricidad', 9, 1, 5, 1, 0, 0),
            (132, 1, 1, 80.00, 'Agua potable', 9, 1, 10, 1, 0, 0),
            (133, 1, 1, 50.00, 'Gas', 9, 1, 15, 1, 0, 0),
            (134, 1, 2, 75.00, 'Internet', 9, 1, 20, 1, 0, 0),
            (135, 1, 2, 60.00, 'Televisión por cable', 9, 1, 5, 1, 0, 0),
            (136, 1, 1, 90.00, 'Recolección de basura', 9, 1, 12, 1, 0, 0),
            (137, 1, 2, 110.00, 'Teléfono fijo', 9, 1, 18, 1, 0, 0),
            (138, 1, 1, 130.00, 'Mantenimiento de áreas comunes', 9, 1, 8, 1, 0, 0),
            (139, 1, 2, 140.00, 'Seguridad privada', 9, 1, 22, 1, 0, 0),
            (140, 1, 1, 500.00, 'Alquiler o hipoteca', 9, 1, 17, 1, 0, 0),
            (141, 1, 1, 120.00, 'Electricidad', 10, 1, 5, 1, 0, 0),
            (142, 1, 1, 80.00, 'Agua potable', 10, 1, 10, 1, 0, 0),
            (143, 1, 1, 50.00, 'Gas', 10, 1, 15, 1, 0, 0),
            (144, 1, 2, 75.00, 'Internet', 10, 1, 20, 1, 0, 0),
            (145, 1, 2, 60.00, 'Televisión por cable', 10, 1, 5, 1, 0, 0),
            (146, 1, 1, 90.00, 'Recolección de basura', 10, 1, 12, 1, 0, 0),
            (147, 1, 2, 110.00, 'Teléfono fijo', 10, 1, 18, 1, 0, 0),
            (148, 1, 1, 130.00, 'Mantenimiento de áreas comunes', 10, 1, 8, 1, 0, 0),
            (149, 1, 2, 140.00, 'Seguridad privada', 10, 1, 22, 1, 0, 0),
            (150, 1, 1, 500.00, 'Alquiler o hipoteca', 10, 1, 17, 1, 0, 0),
            (151, 1, 1, 120.00, 'Electricidad', 11, 1, 5, 1, 0, 0),
            (152, 1, 1, 80.00, 'Agua potable', 11, 1, 10, 1, 0, 0),
            (153, 1, 1, 50.00, 'Gas', 11, 1, 15, 1, 0, 0),
            (154, 1, 2, 75.00, 'Internet', 11, 1, 20, 1, 0, 0),
            (155, 1, 2, 60.00, 'Televisión por cable', 11, 1, 5, 1, 0, 0),
            (156, 1, 1, 90.00, 'Recolección de basura', 11, 1, 12, 1, 0, 0),
            (157, 1, 2, 110.00, 'Teléfono fijo', 11, 1, 18, 1, 0, 0),
            (158, 1, 1, 130.00, 'Mantenimiento de áreas comunes', 11, 1, 8, 1, 0, 0),
            (159, 1, 2, 140.00, 'Seguridad privada', 11, 1, 22, 1, 0, 0),
            (160, 1, 1, 500.00, 'Alquiler o hipoteca', 11, 1, 17, 1, 0, 0),
            (161, 1, 1, 120.00, 'Electricidad', 12, 1, 5, 1, 0, 0),
            (162, 1, 1, 80.00, 'Agua potable', 12, 1, 10, 1, 0, 0),
            (163, 1, 1, 50.00, 'Gas', 12, 1, 15, 1, 0, 0),
            (164, 1, 2, 75.00, 'Internet', 12, 1, 20, 1, 0, 0),
            (165, 1, 2, 60.00, 'Televisión por cable', 12, 1, 5, 1, 0, 0),
            (166, 1, 1, 90.00, 'Recolección de basura', 12, 1, 12, 1, 0, 0),
            (167, 1, 2, 110.00, 'Teléfono fijo', 12, 1, 18, 1, 0, 0),
            (168, 1, 1, 130.00, 'Mantenimiento de áreas comunes', 12, 1, 8, 1, 0, 0),
            (169, 1, 2, 140.00, 'Seguridad privada', 12, 1, 22, 1, 0, 0),
            (170, 1, 1, 500.00, 'Alquiler o hipoteca', 12, 1, 17, 1, 0, 0);
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
