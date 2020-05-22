<?php

namespace App\Repository;

use App\Entity\LikeP;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LikeP|null find($id, $lockMode = null, $lockVersion = null)
 * @method LikeP|null findOneBy(array $criteria, array $orderBy = null)
 * @method LikeP[]    findAll()
 * @method LikeP[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LikePRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LikeP::class);
    }

    // /**
    //  * @return LikeP[] Returns an array of LikeP objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LikeP
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
