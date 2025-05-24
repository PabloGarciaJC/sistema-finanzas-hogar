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
    public function getIncomeOptions(): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT SUM(amount) AS total_amount FROM income WHERE status = "Activo"';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();
        $row = $resultSet->fetchAssociative();
        $amount = (float) ($row['total_amount'] ?? 0);
        return [$amount => $amount];
    }

    
}
