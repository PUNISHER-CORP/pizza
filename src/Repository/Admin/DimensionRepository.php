<?php

namespace App\Repository\Admin;

use App\Entity\Admin\Dimension;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Dimension|null find($id, $lockMode = null, $lockVersion = null)
 * @method Dimension|null findOneBy(array $criteria, array $orderBy = null)
 * @method Dimension[]    findAll()
 * @method Dimension[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DimensionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Dimension::class);
    }

    // /**
    //  * @return Dimension[] Returns an array of Dimension objects
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
    public function findOneBySomeField($value): ?Dimension
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
