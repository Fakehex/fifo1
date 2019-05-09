<?php

namespace App\Repository;

use App\Entity\BracketDouble;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method BracketDouble|null find($id, $lockMode = null, $lockVersion = null)
 * @method BracketDouble|null findOneBy(array $criteria, array $orderBy = null)
 * @method BracketDouble[]    findAll()
 * @method BracketDouble[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BracketDoubleRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, BracketDouble::class);
    }

    // /**
    //  * @return BracketDouble[] Returns an array of BracketDouble objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BracketDouble
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
