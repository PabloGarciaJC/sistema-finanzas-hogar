<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CashPaymentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $em = $manager instanceof EntityManagerInterface ? $manager : null;

        if ($em === null) {
            throw new \RuntimeException('EntityManager no disponible');
        }

        $conn = $em->getConnection();

        $conn->executeStatement("
            INSERT INTO `cash_payment` (`id`, `user_id`, `member_id`, `amount`, `description`, `month`, `year`, `payment_day`, `status`, `is_default`, `is_paid`) VALUES
            (1, 1, 1, 150.00, 'Reparaciones del hogar', 1, 1, 5, 1, 1, 0),
            (2, 1, 2, 85.00, 'Compra de materiales de limpieza', 1, 1, 10, 1, 1, 0),
            (3, 1, 1, 220.00, 'Fontanería', 1, 1, 15, 1, 1, 0),
            (4, 1, 2, 95.00, 'Jardinería', 1, 1, 20, 1, 1, 0),
            (5, 1, 1, 60.00, 'Alimentos de emergencia', 1, 1, 8, 1, 1, 0),
            (6, 1, 1, 180.00, 'Pintura de paredes', 1, 1, 12, 1, 1, 0),
            (7, 1, 2, 130.00, 'Mano de obra doméstica', 1, 1, 18, 1, 1, 0),
            (8, 1, 1, 90.00, 'Limpieza profunda', 1, 1, 22, 1, 1, 0),
            (9, 1, 2, 110.00, 'Transporte de muebles', 1, 1, 25, 1, 1, 0),
            (10, 1, 1, 75.00, 'Compra de utensilios', 1, 1, 28, 1, 1, 0),
            (51, 1, 1, 150.00, 'Reparaciones del hogar', 2, 1, 5, 1, 0, 0),
            (52, 1, 2, 85.00, 'Compra de materiales de limpieza', 2, 1, 10, 1, 0, 0),
            (53, 1, 1, 220.00, 'Fontanería', 2, 1, 15, 1, 0, 0),
            (54, 1, 2, 95.00, 'Jardinería', 2, 1, 20, 1, 0, 0),
            (55, 1, 1, 60.00, 'Alimentos de emergencia', 2, 1, 8, 1, 0, 0),
            (56, 1, 1, 180.00, 'Pintura de paredes', 2, 1, 12, 1, 0, 0),
            (57, 1, 2, 130.00, 'Mano de obra doméstica', 2, 1, 18, 1, 0, 0),
            (58, 1, 1, 90.00, 'Limpieza profunda', 2, 1, 22, 1, 0, 0),
            (59, 1, 2, 110.00, 'Transporte de muebles', 2, 1, 25, 1, 0, 0),
            (60, 1, 1, 75.00, 'Compra de utensilios', 2, 1, 28, 1, 0, 0),
            (61, 1, 1, 150.00, 'Reparaciones del hogar', 3, 1, 5, 1, 0, 0),
            (62, 1, 2, 85.00, 'Compra de materiales de limpieza', 3, 1, 10, 1, 0, 0),
            (63, 1, 1, 220.00, 'Fontanería', 3, 1, 15, 1, 0, 0),
            (64, 1, 2, 95.00, 'Jardinería', 3, 1, 20, 1, 0, 0),
            (65, 1, 1, 60.00, 'Alimentos de emergencia', 3, 1, 8, 1, 0, 0),
            (66, 1, 1, 180.00, 'Pintura de paredes', 3, 1, 12, 1, 0, 0),
            (67, 1, 2, 130.00, 'Mano de obra doméstica', 3, 1, 18, 1, 0, 0),
            (68, 1, 1, 90.00, 'Limpieza profunda', 3, 1, 22, 1, 0, 0),
            (69, 1, 2, 110.00, 'Transporte de muebles', 3, 1, 25, 1, 0, 0),
            (70, 1, 1, 75.00, 'Compra de utensilios', 3, 1, 28, 1, 0, 0),
            (71, 1, 1, 150.00, 'Reparaciones del hogar', 4, 1, 5, 1, 0, 0),
            (72, 1, 2, 85.00, 'Compra de materiales de limpieza', 4, 1, 10, 1, 0, 0),
            (73, 1, 1, 220.00, 'Fontanería', 4, 1, 15, 1, 0, 0),
            (74, 1, 2, 95.00, 'Jardinería', 4, 1, 20, 1, 0, 0),
            (75, 1, 1, 60.00, 'Alimentos de emergencia', 4, 1, 8, 1, 0, 0),
            (76, 1, 1, 180.00, 'Pintura de paredes', 4, 1, 12, 1, 0, 0),
            (77, 1, 2, 130.00, 'Mano de obra doméstica', 4, 1, 18, 1, 0, 0),
            (78, 1, 1, 90.00, 'Limpieza profunda', 4, 1, 22, 1, 0, 0),
            (79, 1, 2, 110.00, 'Transporte de muebles', 4, 1, 25, 1, 0, 0),
            (80, 1, 1, 75.00, 'Compra de utensilios', 4, 1, 28, 1, 0, 0),
            (81, 1, 1, 150.00, 'Reparaciones del hogar', 5, 1, 5, 1, 0, 0),
            (82, 1, 2, 85.00, 'Compra de materiales de limpieza', 5, 1, 10, 1, 0, 0),
            (83, 1, 1, 220.00, 'Fontanería', 5, 1, 15, 1, 0, 0),
            (84, 1, 2, 95.00, 'Jardinería', 5, 1, 20, 1, 0, 0),
            (85, 1, 1, 60.00, 'Alimentos de emergencia', 5, 1, 8, 1, 0, 0),
            (86, 1, 1, 180.00, 'Pintura de paredes', 5, 1, 12, 1, 0, 0),
            (87, 1, 2, 130.00, 'Mano de obra doméstica', 5, 1, 18, 1, 0, 0),
            (88, 1, 1, 90.00, 'Limpieza profunda', 5, 1, 22, 1, 0, 0),
            (89, 1, 2, 110.00, 'Transporte de muebles', 5, 1, 25, 1, 0, 0),
            (90, 1, 1, 75.00, 'Compra de utensilios', 5, 1, 28, 1, 0, 0),
            (91, 1, 1, 150.00, 'Reparaciones del hogar', 6, 1, 5, 1, 0, 0),
            (92, 1, 2, 85.00, 'Compra de materiales de limpieza', 6, 1, 10, 1, 0, 0),
            (93, 1, 1, 220.00, 'Fontanería', 6, 1, 15, 1, 0, 0),
            (94, 1, 2, 95.00, 'Jardinería', 6, 1, 20, 1, 0, 0),
            (95, 1, 1, 60.00, 'Alimentos de emergencia', 6, 1, 8, 1, 0, 0),
            (96, 1, 1, 180.00, 'Pintura de paredes', 6, 1, 12, 1, 0, 0),
            (97, 1, 2, 130.00, 'Mano de obra doméstica', 6, 1, 18, 1, 0, 0),
            (98, 1, 1, 90.00, 'Limpieza profunda', 6, 1, 22, 1, 0, 0),
            (99, 1, 2, 110.00, 'Transporte de muebles', 6, 1, 25, 1, 0, 0),
            (100, 1, 1, 75.00, 'Compra de utensilios', 6, 1, 28, 1, 0, 0),
            (101, 1, 1, 150.00, 'Reparaciones del hogar', 7, 1, 5, 1, 0, 0),
            (102, 1, 2, 85.00, 'Compra de materiales de limpieza', 7, 1, 10, 1, 0, 0),
            (103, 1, 1, 220.00, 'Fontanería', 7, 1, 15, 1, 0, 0),
            (104, 1, 2, 95.00, 'Jardinería', 7, 1, 20, 1, 0, 0),
            (105, 1, 1, 60.00, 'Alimentos de emergencia', 7, 1, 8, 1, 0, 0),
            (106, 1, 1, 180.00, 'Pintura de paredes', 7, 1, 12, 1, 0, 0),
            (107, 1, 2, 130.00, 'Mano de obra doméstica', 7, 1, 18, 1, 0, 0),
            (108, 1, 1, 90.00, 'Limpieza profunda', 7, 1, 22, 1, 0, 0),
            (109, 1, 2, 110.00, 'Transporte de muebles', 7, 1, 25, 1, 0, 0),
            (110, 1, 1, 75.00, 'Compra de utensilios', 7, 1, 28, 1, 0, 0),
            (111, 1, 1, 150.00, 'Reparaciones del hogar', 8, 1, 5, 1, 0, 0),
            (112, 1, 2, 85.00, 'Compra de materiales de limpieza', 8, 1, 10, 1, 0, 0),
            (113, 1, 1, 220.00, 'Fontanería', 8, 1, 15, 1, 0, 0),
            (114, 1, 2, 95.00, 'Jardinería', 8, 1, 20, 1, 0, 0),
            (115, 1, 1, 60.00, 'Alimentos de emergencia', 8, 1, 8, 1, 0, 0),
            (116, 1, 1, 180.00, 'Pintura de paredes', 8, 1, 12, 1, 0, 0),
            (117, 1, 2, 130.00, 'Mano de obra doméstica', 8, 1, 18, 1, 0, 0),
            (118, 1, 1, 90.00, 'Limpieza profunda', 8, 1, 22, 1, 0, 0),
            (119, 1, 2, 110.00, 'Transporte de muebles', 8, 1, 25, 1, 0, 0),
            (120, 1, 1, 75.00, 'Compra de utensilios', 8, 1, 28, 1, 0, 0),
            (121, 1, 1, 150.00, 'Reparaciones del hogar', 9, 1, 5, 1, 0, 0),
            (122, 1, 2, 85.00, 'Compra de materiales de limpieza', 9, 1, 10, 1, 0, 0),
            (123, 1, 1, 220.00, 'Fontanería', 9, 1, 15, 1, 0, 0),
            (124, 1, 2, 95.00, 'Jardinería', 9, 1, 20, 1, 0, 0),
            (125, 1, 1, 60.00, 'Alimentos de emergencia', 9, 1, 8, 1, 0, 0),
            (126, 1, 1, 180.00, 'Pintura de paredes', 9, 1, 12, 1, 0, 0),
            (127, 1, 2, 130.00, 'Mano de obra doméstica', 9, 1, 18, 1, 0, 0),
            (128, 1, 1, 90.00, 'Limpieza profunda', 9, 1, 22, 1, 0, 0),
            (129, 1, 2, 110.00, 'Transporte de muebles', 9, 1, 25, 1, 0, 0),
            (130, 1, 1, 75.00, 'Compra de utensilios', 9, 1, 28, 1, 0, 0),
            (131, 1, 1, 150.00, 'Reparaciones del hogar', 10, 1, 5, 1, 0, 0),
            (132, 1, 2, 85.00, 'Compra de materiales de limpieza', 10, 1, 10, 1, 0, 0),
            (133, 1, 1, 220.00, 'Fontanería', 10, 1, 15, 1, 0, 0),
            (134, 1, 2, 95.00, 'Jardinería', 10, 1, 20, 1, 0, 0),
            (135, 1, 1, 60.00, 'Alimentos de emergencia', 10, 1, 8, 1, 0, 0),
            (136, 1, 1, 180.00, 'Pintura de paredes', 10, 1, 12, 1, 0, 0),
            (137, 1, 2, 130.00, 'Mano de obra doméstica', 10, 1, 18, 1, 0, 0),
            (138, 1, 1, 90.00, 'Limpieza profunda', 10, 1, 22, 1, 0, 0),
            (139, 1, 2, 110.00, 'Transporte de muebles', 10, 1, 25, 1, 0, 0),
            (140, 1, 1, 75.00, 'Compra de utensilios', 10, 1, 28, 1, 0, 0),
            (141, 1, 1, 150.00, 'Reparaciones del hogar', 11, 1, 5, 1, 0, 0),
            (142, 1, 2, 85.00, 'Compra de materiales de limpieza', 11, 1, 10, 1, 0, 0),
            (143, 1, 1, 220.00, 'Fontanería', 11, 1, 15, 1, 0, 0),
            (144, 1, 2, 95.00, 'Jardinería', 11, 1, 20, 1, 0, 0),
            (145, 1, 1, 60.00, 'Alimentos de emergencia', 11, 1, 8, 1, 0, 0),
            (146, 1, 1, 180.00, 'Pintura de paredes', 11, 1, 12, 1, 0, 0),
            (147, 1, 2, 130.00, 'Mano de obra doméstica', 11, 1, 18, 1, 0, 0),
            (148, 1, 1, 90.00, 'Limpieza profunda', 11, 1, 22, 1, 0, 0),
            (149, 1, 2, 110.00, 'Transporte de muebles', 11, 1, 25, 1, 0, 0),
            (150, 1, 1, 75.00, 'Compra de utensilios', 11, 1, 28, 1, 0, 0),
            (151, 1, 1, 150.00, 'Reparaciones del hogar', 12, 1, 5, 1, 0, 0),
            (152, 1, 2, 85.00, 'Compra de materiales de limpieza', 12, 1, 10, 1, 0, 0),
            (153, 1, 1, 220.00, 'Fontanería', 12, 1, 15, 1, 0, 0),
            (154, 1, 2, 95.00, 'Jardinería', 12, 1, 20, 1, 0, 0),
            (155, 1, 1, 60.00, 'Alimentos de emergencia', 12, 1, 8, 1, 0, 0),
            (156, 1, 1, 180.00, 'Pintura de paredes', 12, 1, 12, 1, 0, 0),
            (157, 1, 2, 130.00, 'Mano de obra doméstica', 12, 1, 18, 1, 0, 0),
            (158, 1, 1, 90.00, 'Limpieza profunda', 12, 1, 22, 1, 0, 0),
            (159, 1, 2, 110.00, 'Transporte de muebles', 12, 1, 25, 1, 0, 0),
            (160, 1, 1, 75.00, 'Compra de utensilios', 12, 1, 28, 1, 0, 0);
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
