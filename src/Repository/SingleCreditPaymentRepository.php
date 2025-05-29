<?php

namespace App\Repository;

use App\Entity\SingleCreditPayment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SingleCreditPayment>
 */
class SingleCreditPaymentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SingleCreditPayment::class);
    }

    public function getTotalSingleCreditPayment(): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT SUM(amount) AS totalDebt FROM single_credit_payment WHERE status = "Activo"';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();
        $row = $resultSet->fetchAssociative();
        $amount = (float) ($row['totalDebt'] ?? 0);
        return [$amount => $amount];
    }

    public function getTotalByMemberId(int $memberId): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT SUM(amount) AS totalDebt FROM single_credit_payment WHERE member_id = :memberId AND status = "Activo"';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['memberId' => $memberId]);
        $row = $resultSet->fetchAssociative();
        $amount = (float) ($row['totalDebt'] ?? 0);
        return [$amount => $amount];
    }

    // Opcionales si los usás individualmente como en tu código original:
    public function getTotalMemberOne(): array
    {
        return $this->getTotalByMemberId(1);
    }

    public function getTotalMemberTwo(): array
    {
        return $this->getTotalByMemberId(2);
    }
}
