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
     * @return string
     */
    public function getTotalIncomeSql(): string
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT SUM(amount) as total FROM income';
        $stmt = $conn->executeQuery($sql);
        $result = $stmt->fetchAssociative();

        return number_format(($result['total'] ?? 0) / 100, 2, ',', '.');
    }
}
