<?php

namespace App\Repository;

use App\Entity\CategorieForum;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CategorieForum|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategorieForum|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategorieForum[]    findAll()
 * @method CategorieForum[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategorieForumRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CategorieForum::class);
    }

    // /**
    //  * @return CategorieForum[] Returns an array of CategorieForum objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CategorieForum
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
