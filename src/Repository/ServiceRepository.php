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

    public function getTotalServiceSql(): string
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT SUM(amount) as totalDebt FROM services';
        $stmt = $conn->executeQuery($sql);
        $result = $stmt->fetchAssociative();

        return number_format(($result['totalDebt'] ?? 0) / 100, 2, ',', '.');
    }
}
