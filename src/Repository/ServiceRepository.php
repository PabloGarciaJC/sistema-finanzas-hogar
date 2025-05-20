<?php

namespace App\Repository;

use App\Entity\Service;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Service>
 */
class ServiceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Service::class);
    }

    public function getTotalServiceSql(): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT SUM(amount) AS totalDebt FROM services';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();
        $row = $resultSet->fetchAssociative();

        $amount = (float) ($row['totalDebt'] ?? 0);

        // Retorna un array simple para usar como opción por defecto (clave = valor)
        return [$amount => $amount];
    }

    public function getTotalMemberOne(): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT SUM(amount) AS totalDebtMemberOne FROM services WHERE member_id = 1';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();
        $row = $resultSet->fetchAssociative();

        $amount = (float) ($row['totalDebtMemberOne'] ?? 0);

        // Retorna un array simple para usar como opción por defecto (clave = valor)
        return [$amount => $amount];
    }

      public function getTotalMemberTwo(): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT SUM(amount) AS totalDebtMemberTwo FROM services WHERE member_id = 2';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();
        $row = $resultSet->fetchAssociative();

        $amount = (float) ($row['totalDebtMemberTwo'] ?? 0);

        // Retorna un array simple para usar como opción por defecto (clave = valor)
        return [$amount => $amount];
    }
}
