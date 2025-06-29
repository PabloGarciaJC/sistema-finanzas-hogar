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

    public function getGoalTotal(): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT SUM(amount) AS total_amount FROM goal WHERE status = "Activo"';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();
        $row = $resultSet->fetchAssociative();
        $amount = (float) ($row['target_amount'] ?? 0);
        return [$amount => $amount];
    }
}
