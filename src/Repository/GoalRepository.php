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
        $sql = 'SELECT SUM(amount) AS total_amount FROM goal WHERE user_id = ' . $userId . ' AND status = "Activo"';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();
        $row = $resultSet->fetchAssociative();
        $amount = $row['total_amount'] ?? 0;
        return (float) $amount;
    }
}
