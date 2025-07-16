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

    public function getTotalCredit($userId): float
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT SUM(installment_amount) AS total_amount FROM credit WHERE user_id = ' . $userId . ' AND status = 1';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();
        $row = $resultSet->fetchAssociative();
        $amount = $row['total_amount'] ?? 0;
        return (float) $amount;
    }

    public function getTotalCreditByMonth($userId, $idMonth): float
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT SUM(installment_amount) AS total_amount FROM credit WHERE user_id = ' . $userId . ' AND month = ' . $idMonth . ' AND status = 1';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();
        $row = $resultSet->fetchAssociative();
        $amount = $row['total_amount'] ?? 0;
        return (float) $amount;
    }

    public function getAllCreditSql($userId): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT * FROM credit WHERE user_id = ' . $userId . ' AND status = 1';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();
        $rows = $resultSet->fetchAllAssociative();
        return $rows;
    }

    public function getTotalCreditByMemberId($memberId, $userId): float
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT SUM(installment_amount) AS total_amount FROM credit WHERE member_id = ' . $memberId . ' AND user_id = ' . $userId . ' AND status = 1';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();
        $row = $resultSet->fetchAssociative();
        $amount = $row['total_amount'] ?? 0;
        return (float) $amount;
    }

    public function getCreditsByUserAndMember(int $userId): array
{
    $conn = $this->getEntityManager()->getConnection();
    $sql = '
        SELECT 
            c.*, 
            m.name as member_name
        FROM credit c
        LEFT JOIN member m ON m.id = c.member_id
        WHERE c.user_id = :userId 
          AND c.status = 1
        ORDER BY c.member_id ASC, c.bank_entity ASC
    ';
    $stmt = $conn->prepare($sql);
    $resultSet = $stmt->executeQuery(['userId' => $userId]);
    return $resultSet->fetchAllAssociative();
}

}
