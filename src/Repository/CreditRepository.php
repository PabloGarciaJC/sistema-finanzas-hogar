<?php

namespace App\Repository;

use App\Entity\Credit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Credit>
 */
class CreditRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Credit::class);
    }

    public function getCreditTotalMemberOne(): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT SUM(monthly_payment) AS creditMemberOne FROM credit WHERE member_id = 1 AND status = "Activo"';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();
        $row = $resultSet->fetchAssociative();

        $amount = (float) ($row['creditMemberOne'] ?? 0);

        // Retorna un array simple para usar como opción por defecto (clave = valor)
        return [$amount => $amount];
    }

     public function getCreditTotalMemberTwo(): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT SUM(monthly_payment) AS creditMemberTwo FROM credit WHERE member_id = 2 AND status = "Activo"';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();
        $row = $resultSet->fetchAssociative();
        $amount = (float) ($row['creditMemberTwo'] ?? 0);
        // Retorna un array simple para usar como opción por defecto (clave = valor)
        return [$amount => $amount];
    }
}
