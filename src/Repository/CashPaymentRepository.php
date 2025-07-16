<?php

namespace App\Repository;

use App\Entity\CashPayment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CashPayment>
 */
class CashPaymentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CashPayment::class);
    }

    public function getTotalCashPayment($userId): float
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT SUM(amount) AS total_amount FROM cash_payment WHERE user_id = ' . $userId . ' AND status = 1';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();
        $row = $resultSet->fetchAssociative();
        $amount = $row['total_amount'] ?? 0;
        return (float) $amount;
    }

    public function getTotalCashPaymentByMonth($userId, $idMonth): float
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT SUM(amount) AS total_amount FROM cash_payment WHERE user_id = ' . $userId . ' AND month = ' . $idMonth . ' AND status = 1';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();
        $row = $resultSet->fetchAssociative();
        $amount = $row['total_amount'] ?? 0;
        return (float) $amount;
    }

    public function getAllCashPaymentSql($userId): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT * FROM cash_payment WHERE user_id = ' . $userId . ' AND status = 1';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();
        $rows = $resultSet->fetchAllAssociative();
        return $rows;
    }

    public function getTotalByMemberId($memberId, $userId, $idMonth): float
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT SUM(amount) AS total_amount FROM cash_payment WHERE member_id = ' . $memberId . ' AND user_id = ' . $userId . ' AND month = ' . $idMonth . ' AND status = 1';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();
        $row = $resultSet->fetchAssociative();
        $amount = $row['total_amount'] ?? 0;
        return (float) $amount;
    }

    public function getCashPaymentsByMonthAndMember(int $userId, int $month): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = '
        SELECT 
            cp.*, 
            m.name AS member_name
        FROM cash_payment cp
        LEFT JOIN member m ON m.id = cp.member_id
        WHERE cp.user_id = :userId 
        AND cp.status = 1 
        AND cp.month = :month
        ORDER BY cp.member_id ASC, cp.description ASC
    ';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery([
            'userId' => $userId,
            'month' => $month,
        ]);
        return $resultSet->fetchAllAssociative();
    }
}
