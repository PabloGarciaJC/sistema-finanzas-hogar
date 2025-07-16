<?php

namespace App\Repository;

use App\Entity\Goal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Goal>
 */
class GoalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Goal::class);
    }

    public function getGoalTotal($userId): float
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT SUM(amount) AS total_amount FROM goal WHERE user_id = ' . $userId . ' AND status = 1';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();
        $row = $resultSet->fetchAssociative();
        $amount = $row['total_amount'] ?? 0;
        return (float) $amount;
    }

    public function getGoalTotalByMonth($userId, $idMonth): float
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT SUM(amount) AS total_amount FROM goal WHERE user_id = ' . $userId . ' AND month = ' . $idMonth . ' AND status = 1';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();
        $row = $resultSet->fetchAssociative();
        $amount = $row['total_amount'] ?? 0;
        return (float) $amount;
    }

    public function getAllGoalSql($userId): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT * FROM goal WHERE user_id = ' . $userId . ' AND status = 1';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();
        $rows = $resultSet->fetchAllAssociative();
        return $rows;
    }

    public function getTotalGoalByMemberId($memberId, $userId, $idMonth): float
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT SUM(amount) AS total_amount FROM goal WHERE member_id = ' . $memberId . ' AND user_id = ' . $userId . ' AND month = ' . $idMonth . ' AND status = 1';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();
        $row = $resultSet->fetchAssociative();
        $amount = $row['total_amount'] ?? 0;
        return (float) $amount;
    }


 public function getGoalsGroupedByMonthAndMember($userId, $idMonth)
{
    $conn = $this->getEntityManager()->getConnection();

    $sql = '
        SELECT 
            g.*, 
            m.name as member_name
        FROM goal g
        LEFT JOIN member m ON m.id = g.member_id
        WHERE g.user_id = :userId 
          AND g.month = :idMonth 
          AND g.status = 1
        ORDER BY g.member_id ASC, g.description ASC
    ';

    $stmt = $conn->prepare($sql);
    $resultSet = $stmt->executeQuery([
        'userId' => (int)$userId,
        'idMonth' => (int)$idMonth
    ]);

    return $resultSet->fetchAllAssociative();
}

}
