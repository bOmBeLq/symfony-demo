<?php

namespace App\Repository;

use App\Entity\NewsComment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method NewsComment|null find($id, $lockMode = null, $lockVersion = null)
 * @method NewsComment|null findOneBy(array $criteria, array $orderBy = null)
 * @method NewsComment[]    findAll()
 * @method NewsComment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NewsCommentRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, NewsComment::class);
    }

    // /**
    //  * @return NewsComment[] Returns an array of NewsComment objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?NewsComment
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
