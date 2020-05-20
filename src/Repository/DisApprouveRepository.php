<?php

namespace App\Repository;

use App\Entity\DisApprouve;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DisApprouve|null find($id, $lockMode = null, $lockVersion = null)
 * @method DisApprouve|null findOneBy(array $criteria, array $orderBy = null)
 * @method DisApprouve[]    findAll()
 * @method DisApprouve[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DisApprouveRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DisApprouve::class);
    }

    // /**
    //  * @return DisApprouve[] Returns an array of DisApprouve objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DisApprouve
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
