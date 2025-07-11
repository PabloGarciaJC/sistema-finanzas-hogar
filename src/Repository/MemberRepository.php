<?php

namespace App\Repository;

use App\Entity\Member;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Member>
 */
class MemberRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Member::class);
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
}
