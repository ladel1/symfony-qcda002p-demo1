<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Article>
 *
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

    public function add(Article $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Article $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function delete(int $pk):void{
        $article = $this->find($pk);
        $this->remove($article,true);
    }

    public function search($keyword){
        $em = $this->getEntityManager();
        $dql = "
                SELECT a FROM App\Entity\Article a
                WHERE a.name LIKE :name                
        ";
        $stmt = $em->createQuery($dql);
        $stmt->setParameters(
            array(
                ":name"=>"%$keyword%"
            ) );
        return $stmt->getResult();
    }


    public function searchByDesc($keyword){
        $qb = $this->createQueryBuilder("a");
        $qb->andWhere("a.description LIKE :keyword");
        $query = $qb->getQuery();
        $query->setParameter(":keyword","%$keyword%");
        return $query->getResult();
    }    

    public function searchBy($keyword,$type=0){
        $qb = $this->createQueryBuilder("a");
        if($type===0){
            $qb->andWhere("a.description LIKE :keyword OR a.name LIKE :keyword");
        }
        if($type===1){
            $qb->andWhere("a.name LIKE :keyword");
        }
        if($type===2){
            $qb->andWhere("a.description LIKE :keyword");
        }                
        $query = $qb->getQuery();
        $query->setParameter(":keyword","%$keyword%");
        return $query->getResult();
    }      

//    /**
//     * @return Article[] Returns an array of Article objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Article
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
