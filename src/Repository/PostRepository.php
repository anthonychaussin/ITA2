<?php

namespace App\Repository;

use App\Entity\Post;
use DateInterval;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Exception;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    /**
     * @return Post[] Returns an array of Post objects
     */
    public function findAll()
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.Date', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @param int $limit
     * @param int $page
     * @return Post[] Returns an array of Post objects
     */
    public function findAllP(int $limit, int $page)
    {
        return $this->createQueryBuilder('p')
            ->setFirstResult($page)
            ->setMaxResults($limit)
            ->orderBy('p.Date', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @param int $limit
     * @param int $page
     * @return Post[] Returns an array of Post objects
     */
    public function finMostLoved(int $limit, int $page)
    {
        $posts = $this->createQueryBuilder('p')
            ->leftJoin("App\Entity\LikeP", 'l')
            ->getQuery()
            ->getResult();
        usort($posts, function (Post $element1, Post $element2) {
            return $element1->getLikePs()->count() > $element2->getLikePs()->count();
        });
        return array_chunk($posts, $limit)[$page];
    }

    /**
     * @param DateTime $dateTime
     * @return Post[] Returns an array of Post objects
     * @throws Exception
     */
    public function findFromMonth(DateTime $dateTime = null)
    {
        if ($dateTime == null) {
            $dateTime = new DateTime();
        }
        return $this->createQueryBuilder('p')
            ->where("p.Date > :start")
            ->andWhere("p.Date < :end")
            ->setParameter('start', $dateTime->format("Y-m-d"))
            ->setParameter('end', (clone($dateTime))->add(new DateInterval("P" . ((\date("t", strtotime($dateTime->format("Y-m-d")))) - 1) . "D"))->format("Y-m-d"))
            ->orderBy("p.Date")
            ->getQuery()
            ->getResult();
    }

}
