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
        $sql = 'SELECT SUM(amount) AS total_amount FROM cash_payment WHERE user_id = ' . $userId . ' AND status = "Activo"';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();
        $row = $resultSet->fetchAssociative();
        $amount = $row['total_amount'] ?? 0;
        return (float) $amount;
    }

    public function getTotalByMemberId(int $memberId): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT SUM(amount) AS totalAmount FROM cash_payment WHERE member_id = :memberId AND status = "Activo"';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['memberId' => $memberId]);
        $row = $resultSet->fetchAssociative();
        $amount = (float) ($row['totalAmount'] ?? 0);
        return [$amount => $amount];
    }
}
