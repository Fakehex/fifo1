<?php

namespace App\Repository;

use App\Entity\Bracket;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Bracket|null find($id, $lockMode = null, $lockVersion = null)
 * @method Bracket|null findOneBy(array $criteria, array $orderBy = null)
 * @method Bracket[]    findAll()
 * @method Bracket[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BracketRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Bracket::class);
    }

    // /**
    //  * @return Inscrit[] Returns an array of Inscrit objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Inscrit
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
