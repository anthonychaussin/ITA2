<?php

namespace App\Repository;

use App\Entity\DisLikeP;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DisLikeP|null find($id, $lockMode = null, $lockVersion = null)
 * @method DisLikeP|null findOneBy(array $criteria, array $orderBy = null)
 * @method DisLikeP[]    findAll()
 * @method DisLikeP[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DisLikePRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DisLikeP::class);
    }

    // /**
    //  * @return DisLikeP[] Returns an array of DisLikeP objects
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
    public function findOneBySomeField($value): ?DisLikeP
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
