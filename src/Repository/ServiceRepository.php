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
        $sql = 'SELECT SUM(amount) AS total_amount FROM services WHERE user_id = ' . $userId . ' AND status = 1';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();
        $row = $resultSet->fetchAssociative();
        $amount = $row['total_amount'] ?? 0;
        return (float) $amount;
    }

    public function getTotalServiceSqlByMonth($userId, $idMonth): float
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT SUM(amount) AS total_amount FROM services WHERE user_id = ' . $userId . ' AND month = ' . $idMonth . ' AND status = 1';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();
        $row = $resultSet->fetchAssociative();
        $amount = $row['total_amount'] ?? 0;
        return (float) $amount;
    }


    public function getAllServiceSql($userId): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT * FROM services WHERE user_id = ' . $userId . ' AND status = 1';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();
        $rows = $resultSet->fetchAllAssociative();
        return $rows;
    }

    public function getTotalServicesByMember($memberId, $userId, $idMonth): float
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT SUM(amount) AS total_amount FROM services WHERE member_id = ' . $memberId . ' AND user_id = ' . $userId . ' AND month = ' . $idMonth . ' AND status = 1';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();
        $row = $resultSet->fetchAssociative();
        $amount = $row['total_amount'] ?? 0;
        return (float) $amount;
    }

public function getTotalServicesGroupedByMonthAndMember($userId, $idMonth)
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = '
            SELECT 
                s.*, 
                m.name as member_name
            FROM services s
            LEFT JOIN member m ON m.id = s.member_id
            WHERE s.user_id = :userId 
            AND s.month = :idMonth 
            AND s.status = 1
            ORDER BY s.member_id ASC, s.description ASC
        ';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery([
            'userId' => (int)$userId,
            'idMonth' => (int)$idMonth
        ]);
        return $resultSet->fetchAllAssociative();
    }

}
