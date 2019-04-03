<?php

namespace App\Repository;

use App\Entity\CategorieMatiere;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CategorieMatiere|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategorieMatiere|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategorieMatiere[]    findAll()
 * @method CategorieMatiere[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategorieMatiereRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CategorieMatiere::class);
    }

    // /**
    //  * @return CategorieMatiere[] Returns an array of CategorieMatiere objects
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
    public function findOneBySomeField($value): ?CategorieMatiere
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
