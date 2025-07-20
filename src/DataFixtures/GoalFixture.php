<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class GoalFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $em = $manager instanceof EntityManagerInterface ? $manager : null;

        if ($em === null) {
            throw new \RuntimeException('EntityManager no disponible');
        }

        $conn = $em->getConnection();

        $conn->executeStatement("
            INSERT INTO `goal` (`id`, `user_id`, `member_id`, `amount`, `description`, `month`, `year`, `payment_day`, `status`, `is_default`, `is_paid`) VALUES
            (1, 1, 1, 50.00, 'Compra de cuaderno extra', 1, 1, 5, 1, 1, 0),
            (2, 1, 1, 80.00, 'Reparar llave que gotea', 1, 1, 10, 1, 1, 0),
            (3, 1, 2, 75.00, 'Comprar focos de repuesto', 1, 1, 5, 1, 1, 0),
            (4, 1, 2, 90.00, 'Pagar limpieza de ventana', 1, 1, 15, 1, 1, 0),
            (5, 1, 1, 60.00, 'Comprar toallas nuevas', 1, 1, 4, 1, 1, 0),
            (6, 1, 1, 70.00, 'Compra de escoba y recogedor', 1, 1, 20, 1, 1, 0),
            (7, 1, 1, 95.00, 'Arreglo de enchufe suelto', 1, 1, 2, 1, 1, 0),
            (8, 1, 2, 85.00, 'Comprar plantas pequeñas', 1, 1, 25, 1, 1, 0),
            (9, 1, 2, 55.00, 'Cambio de bombillo de cocina', 1, 1, 8, 1, 1, 0),
            (10, 1, 1, 65.00, 'Compra de jabones y detergente', 1, 1, 30, 1, 1, 0),
            (51, 1, 1, 50.00, 'Compra de cuaderno extra', 2, 1, 5, 1, 0, 0),
            (52, 1, 1, 80.00, 'Reparar llave que gotea', 2, 1, 10, 1, 0, 0),
            (53, 1, 2, 75.00, 'Comprar focos de repuesto', 2, 1, 5, 1, 0, 0),
            (54, 1, 2, 90.00, 'Pagar limpieza de ventana', 2, 1, 15, 1, 0, 0),
            (55, 1, 1, 60.00, 'Comprar toallas nuevas', 2, 1, 4, 1, 0, 0),
            (56, 1, 1, 70.00, 'Compra de escoba y recogedor', 2, 1, 20, 1, 0, 0),
            (57, 1, 1, 95.00, 'Arreglo de enchufe suelto', 2, 1, 2, 1, 0, 0),
            (58, 1, 2, 85.00, 'Comprar plantas pequeñas', 2, 1, 25, 1, 0, 0),
            (59, 1, 2, 55.00, 'Cambio de bombillo de cocina', 2, 1, 8, 1, 0, 0),
            (60, 1, 1, 65.00, 'Compra de jabones y detergente', 2, 1, 30, 1, 0, 0),
            (61, 1, 1, 50.00, 'Compra de cuaderno extra', 3, 1, 5, 1, 0, 0),
            (62, 1, 1, 80.00, 'Reparar llave que gotea', 3, 1, 10, 1, 0, 0),
            (63, 1, 2, 75.00, 'Comprar focos de repuesto', 3, 1, 5, 1, 0, 0),
            (64, 1, 2, 90.00, 'Pagar limpieza de ventana', 3, 1, 15, 1, 0, 0),
            (65, 1, 1, 60.00, 'Comprar toallas nuevas', 3, 1, 4, 1, 0, 0),
            (66, 1, 1, 70.00, 'Compra de escoba y recogedor', 3, 1, 20, 1, 0, 0),
            (67, 1, 1, 95.00, 'Arreglo de enchufe suelto', 3, 1, 2, 1, 0, 0),
            (68, 1, 2, 85.00, 'Comprar plantas pequeñas', 3, 1, 25, 1, 0, 0),
            (69, 1, 2, 55.00, 'Cambio de bombillo de cocina', 3, 1, 8, 1, 0, 0),
            (70, 1, 1, 65.00, 'Compra de jabones y detergente', 3, 1, 30, 1, 0, 0),
            (71, 1, 1, 50.00, 'Compra de cuaderno extra', 4, 1, 5, 1, 0, 0),
            (72, 1, 1, 80.00, 'Reparar llave que gotea', 4, 1, 10, 1, 0, 0),
            (73, 1, 2, 75.00, 'Comprar focos de repuesto', 4, 1, 5, 1, 0, 0),
            (74, 1, 2, 90.00, 'Pagar limpieza de ventana', 4, 1, 15, 1, 0, 0),
            (75, 1, 1, 60.00, 'Comprar toallas nuevas', 4, 1, 4, 1, 0, 0),
            (76, 1, 1, 70.00, 'Compra de escoba y recogedor', 4, 1, 20, 1, 0, 0),
            (77, 1, 1, 95.00, 'Arreglo de enchufe suelto', 4, 1, 2, 1, 0, 0),
            (78, 1, 2, 85.00, 'Comprar plantas pequeñas', 4, 1, 25, 1, 0, 0),
            (79, 1, 2, 55.00, 'Cambio de bombillo de cocina', 4, 1, 8, 1, 0, 0),
            (80, 1, 1, 65.00, 'Compra de jabones y detergente', 4, 1, 30, 1, 0, 0),
            (81, 1, 1, 50.00, 'Compra de cuaderno extra', 5, 1, 5, 1, 0, 0),
            (82, 1, 1, 80.00, 'Reparar llave que gotea', 5, 1, 10, 1, 0, 0),
            (83, 1, 2, 75.00, 'Comprar focos de repuesto', 5, 1, 5, 1, 0, 0),
            (84, 1, 2, 90.00, 'Pagar limpieza de ventana', 5, 1, 15, 1, 0, 0),
            (85, 1, 1, 60.00, 'Comprar toallas nuevas', 5, 1, 4, 1, 0, 0),
            (86, 1, 1, 70.00, 'Compra de escoba y recogedor', 5, 1, 20, 1, 0, 0),
            (87, 1, 1, 95.00, 'Arreglo de enchufe suelto', 5, 1, 2, 1, 0, 0),
            (88, 1, 2, 85.00, 'Comprar plantas pequeñas', 5, 1, 25, 1, 0, 0),
            (89, 1, 2, 55.00, 'Cambio de bombillo de cocina', 5, 1, 8, 1, 0, 0),
            (90, 1, 1, 65.00, 'Compra de jabones y detergente', 5, 1, 30, 1, 0, 0),
            (91, 1, 1, 50.00, 'Compra de cuaderno extra', 6, 1, 5, 1, 0, 0),
            (92, 1, 1, 80.00, 'Reparar llave que gotea', 6, 1, 10, 1, 0, 0),
            (93, 1, 2, 75.00, 'Comprar focos de repuesto', 6, 1, 5, 1, 0, 0),
            (94, 1, 2, 90.00, 'Pagar limpieza de ventana', 6, 1, 15, 1, 0, 0),
            (95, 1, 1, 60.00, 'Comprar toallas nuevas', 6, 1, 4, 1, 0, 0),
            (96, 1, 1, 70.00, 'Compra de escoba y recogedor', 6, 1, 20, 1, 0, 0),
            (97, 1, 1, 95.00, 'Arreglo de enchufe suelto', 6, 1, 2, 1, 0, 0),
            (98, 1, 2, 85.00, 'Comprar plantas pequeñas', 6, 1, 25, 1, 0, 0),
            (99, 1, 2, 55.00, 'Cambio de bombillo de cocina', 6, 1, 8, 1, 0, 0),
            (100, 1, 1, 65.00, 'Compra de jabones y detergente', 6, 1, 30, 1, 0, 0),
            (101, 1, 1, 50.00, 'Compra de cuaderno extra', 7, 1, 5, 1, 0, 0),
            (102, 1, 1, 80.00, 'Reparar llave que gotea', 7, 1, 10, 1, 0, 0),
            (103, 1, 2, 75.00, 'Comprar focos de repuesto', 7, 1, 5, 1, 0, 0),
            (104, 1, 2, 90.00, 'Pagar limpieza de ventana', 7, 1, 15, 1, 0, 0),
            (105, 1, 1, 60.00, 'Comprar toallas nuevas', 7, 1, 4, 1, 0, 0),
            (106, 1, 1, 70.00, 'Compra de escoba y recogedor', 7, 1, 20, 1, 0, 0),
            (107, 1, 1, 95.00, 'Arreglo de enchufe suelto', 7, 1, 2, 1, 0, 0),
            (108, 1, 2, 85.00, 'Comprar plantas pequeñas', 7, 1, 25, 1, 0, 0),
            (109, 1, 2, 55.00, 'Cambio de bombillo de cocina', 7, 1, 8, 1, 0, 0),
            (110, 1, 1, 65.00, 'Compra de jabones y detergente', 7, 1, 30, 1, 0, 0),
            (111, 1, 1, 50.00, 'Compra de cuaderno extra', 8, 1, 5, 1, 0, 0),
            (112, 1, 1, 80.00, 'Reparar llave que gotea', 8, 1, 10, 1, 0, 0),
            (113, 1, 2, 75.00, 'Comprar focos de repuesto', 8, 1, 5, 1, 0, 0),
            (114, 1, 2, 90.00, 'Pagar limpieza de ventana', 8, 1, 15, 1, 0, 0),
            (115, 1, 1, 60.00, 'Comprar toallas nuevas', 8, 1, 4, 1, 0, 0),
            (116, 1, 1, 70.00, 'Compra de escoba y recogedor', 8, 1, 20, 1, 0, 0),
            (117, 1, 1, 95.00, 'Arreglo de enchufe suelto', 8, 1, 2, 1, 0, 0),
            (118, 1, 2, 85.00, 'Comprar plantas pequeñas', 8, 1, 25, 1, 0, 0),
            (119, 1, 2, 55.00, 'Cambio de bombillo de cocina', 8, 1, 8, 1, 0, 0),
            (120, 1, 1, 65.00, 'Compra de jabones y detergente', 8, 1, 30, 1, 0, 0),
            (121, 1, 1, 50.00, 'Compra de cuaderno extra', 9, 1, 5, 1, 0, 0),
            (122, 1, 1, 80.00, 'Reparar llave que gotea', 9, 1, 10, 1, 0, 0),
            (123, 1, 2, 75.00, 'Comprar focos de repuesto', 9, 1, 5, 1, 0, 0),
            (124, 1, 2, 90.00, 'Pagar limpieza de ventana', 9, 1, 15, 1, 0, 0),
            (125, 1, 1, 60.00, 'Comprar toallas nuevas', 9, 1, 4, 1, 0, 0),
            (126, 1, 1, 70.00, 'Compra de escoba y recogedor', 9, 1, 20, 1, 0, 0),
            (127, 1, 1, 95.00, 'Arreglo de enchufe suelto', 9, 1, 2, 1, 0, 0),
            (128, 1, 2, 85.00, 'Comprar plantas pequeñas', 9, 1, 25, 1, 0, 0),
            (129, 1, 2, 55.00, 'Cambio de bombillo de cocina', 9, 1, 8, 1, 0, 0),
            (130, 1, 1, 65.00, 'Compra de jabones y detergente', 9, 1, 30, 1, 0, 0),
            (131, 1, 1, 50.00, 'Compra de cuaderno extra', 10, 1, 5, 1, 0, 0),
            (132, 1, 1, 80.00, 'Reparar llave que gotea', 10, 1, 10, 1, 0, 0),
            (133, 1, 2, 75.00, 'Comprar focos de repuesto', 10, 1, 5, 1, 0, 0),
            (134, 1, 2, 90.00, 'Pagar limpieza de ventana', 10, 1, 15, 1, 0, 0),
            (135, 1, 1, 60.00, 'Comprar toallas nuevas', 10, 1, 4, 1, 0, 0),
            (136, 1, 1, 70.00, 'Compra de escoba y recogedor', 10, 1, 20, 1, 0, 0),
            (137, 1, 1, 95.00, 'Arreglo de enchufe suelto', 10, 1, 2, 1, 0, 0),
            (138, 1, 2, 85.00, 'Comprar plantas pequeñas', 10, 1, 25, 1, 0, 0),
            (139, 1, 2, 55.00, 'Cambio de bombillo de cocina', 10, 1, 8, 1, 0, 0),
            (140, 1, 1, 65.00, 'Compra de jabones y detergente', 10, 1, 30, 1, 0, 0),
            (141, 1, 1, 50.00, 'Compra de cuaderno extra', 11, 1, 5, 1, 0, 0),
            (142, 1, 1, 80.00, 'Reparar llave que gotea', 11, 1, 10, 1, 0, 0),
            (143, 1, 2, 75.00, 'Comprar focos de repuesto', 11, 1, 5, 1, 0, 0),
            (144, 1, 2, 90.00, 'Pagar limpieza de ventana', 11, 1, 15, 1, 0, 0),
            (145, 1, 1, 60.00, 'Comprar toallas nuevas', 11, 1, 4, 1, 0, 0),
            (146, 1, 1, 70.00, 'Compra de escoba y recogedor', 11, 1, 20, 1, 0, 0),
            (147, 1, 1, 95.00, 'Arreglo de enchufe suelto', 11, 1, 2, 1, 0, 0),
            (148, 1, 2, 85.00, 'Comprar plantas pequeñas', 11, 1, 25, 1, 0, 0),
            (149, 1, 2, 55.00, 'Cambio de bombillo de cocina', 11, 1, 8, 1, 0, 0),
            (150, 1, 1, 65.00, 'Compra de jabones y detergente', 11, 1, 30, 1, 0, 0),
            (151, 1, 1, 50.00, 'Compra de cuaderno extra', 12, 1, 5, 1, 0, 0),
            (152, 1, 1, 80.00, 'Reparar llave que gotea', 12, 1, 10, 1, 0, 0),
            (153, 1, 2, 75.00, 'Comprar focos de repuesto', 12, 1, 5, 1, 0, 0),
            (154, 1, 2, 90.00, 'Pagar limpieza de ventana', 12, 1, 15, 1, 0, 0),
            (155, 1, 1, 60.00, 'Comprar toallas nuevas', 12, 1, 4, 1, 0, 0),
            (156, 1, 1, 70.00, 'Compra de escoba y recogedor', 12, 1, 20, 1, 0, 0),
            (157, 1, 1, 95.00, 'Arreglo de enchufe suelto', 12, 1, 2, 1, 0, 0),
            (158, 1, 2, 85.00, 'Comprar plantas pequeñas', 12, 1, 25, 1, 0, 0),
            (159, 1, 2, 55.00, 'Cambio de bombillo de cocina', 12, 1, 8, 1, 0, 0),
            (160, 1, 1, 65.00, 'Compra de jabones y detergente', 12, 1, 30, 1, 0, 0);
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
