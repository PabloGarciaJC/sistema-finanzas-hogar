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

     public function getTotalServiceSql($userId): float
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT SUM(amount) AS total_debt FROM services WHERE user_id = ' . $userId . ' AND status = "Activo"';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();
        $row = $resultSet->fetchAssociative();
        $totalDebt = $row['total_debt'] ?? 0;
        return (float) $totalDebt;
    }

    public function getTotalServicesByMember(int $memberId): float
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT SUM(amount) AS totalAmount FROM services WHERE status = "Activo" AND member_id = :memberId';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['memberId' => $memberId]);
        $row = $resultSet->fetchAssociative();
        return (float) ($row['totalAmount'] ?? 0);
    }
}
