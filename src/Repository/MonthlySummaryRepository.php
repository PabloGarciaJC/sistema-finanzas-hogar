<?php

namespace App\Repository;

use App\Entity\MonthlySummary;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MonthlySummary>
 */
class MonthlySummaryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MonthlySummary::class);
    }

    public function getDebtsByMonth($userId, $month): float
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT debt_total FROM monthly_summary WHERE user_id = ' . $userId . ' AND month = :month';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['userId' => $userId, 'month' => $month]);
        $row = $resultSet->fetchAssociative();
        return (float) ($row['debt_total'] ?? 0);
    }
}
