<?php

namespace App\Repository;

use App\Entity\Income;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Income>
 */
class IncomeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Income::class);
    }
    /**
     * Devuelve un array con opciones para el select: [ 'Etiqueta' => valor, ... ]
     * @return array<string, float>
     */
    public function getIncomeOptions($userId): float
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT SUM(amount) AS total_amount FROM income WHERE user_id = ' . $userId . ' AND status = 1';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();
        $row = $resultSet->fetchAssociative();
        $amount = $row['total_amount'] ?? 0;
        return (float) $amount;
    }

    public function getIncomeOptionsByMonth($userId, $idMonth): float
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT SUM(amount) AS total_amount FROM income WHERE user_id = ' . $userId . ' AND month = ' . $idMonth . ' AND status = 1';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();
        $row = $resultSet->fetchAssociative();
        $amount = $row['total_amount'] ?? 0;
        return (float) $amount;
    }

    public function getCountMember($userId): float
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT COUNT(*) AS member_count FROM member WHERE user_id = ' . $userId;
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();
        $row = $resultSet->fetchAssociative();
        $count = $row['member_count'] ?? 0;
        return (float) $count;
    }

    public function getTotalIncomeGroupedByMonth($userId)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'SELECT month, year, SUM(amount) AS total_amount
            FROM income
            WHERE user_id = :userId
            GROUP BY month, year
            ORDER BY year, month';

        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['userId' => $userId]);

        return $resultSet->fetchAllAssociative();
    }
}
