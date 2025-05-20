<?php

namespace App\Repository;

use App\Entity\Credit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Credit>
 */
class CreditRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Credit::class);
    }

    public function getCreditTotalMemberOne(): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT SUM(total_amount) AS creditMemberOne FROM credit WHERE member_id = 1 AND status = "Activo"';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();
        $row = $resultSet->fetchAssociative();

        $amount = (float) ($row['creditMemberOne'] ?? 0);

        // Retorna un array simple para usar como opción por defecto (clave = valor)
        return [$amount => $amount];
    }

     public function getCreditTotalMemberTwo(): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT SUM(total_amount) AS creditMemberTwo FROM credit WHERE member_id = 2 AND status = "Activo"';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();
        $row = $resultSet->fetchAssociative();
        $amount = (float) ($row['creditMemberTwo'] ?? 0);
        // Retorna un array simple para usar como opción por defecto (clave = valor)
        return [$amount => $amount];
    }

    //    /**
    //     * @return Credit[] Returns an array of Credit objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Credit
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
