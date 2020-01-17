<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\QueryBuilder;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

     /**
      * @return Article[] Returns an array of Article objects
      */
    public function findAllPublishedOrderedByNewest()
    {
         return  $this->addIsPublishedQueryBuilder()
//             ->addCriteria(self::createNonDeletedCriteria())
             ->orderBy('a.publishedAt', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findOneBySlug($slug): ?Article
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.slug = :val')
            ->setParameter('val', $slug)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    private function addIsPublishedQueryBuilder(QueryBuilder $qb=null){
        return $this->returnOrCreateQueryBuilder($qb)
            ->andWhere('a.publishedAt IS NOT NULL');
    }

    private function returnOrCreateQueryBuilder(QueryBuilder $qb=null){
        return $qb ?: $this->createQueryBuilder('a');
    }

    public static function createNonDeletedCriteria(){
        return Criteria::create()
            ->andWhere(Criteria::expr()->eq('isDeleted', false))
            ;
    }
}
