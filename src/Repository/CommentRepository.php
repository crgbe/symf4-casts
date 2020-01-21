<?php

namespace App\Repository;

use App\Entity\Comment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * @method Comment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comment[]    findAll()
 * @method Comment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comment::class);
    }

     /**
      * @param string|null $searchItem
      * @return QueryBuilder
      */

    public function getQueryBuilderWithSearch(?string $searchItem) : QueryBuilder
    {
        $qb = $this->createQueryBuilder('c')
            ->innerJoin('c.article', 'a')
            ->addSelect('a')
        ;

            return $qb->andWhere('c.content LIKE :searchItem OR c.authorName LIKE :searchItem OR a.title LIKE :searchItem')
            ->setParameter('searchItem', '%' . $searchItem . '%')
            ->orderBy('c.createdAt', 'DESC')
        ;
    }

    /*
    public function findOneBySomeField($value): ?Comment
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
