<?php

namespace App\Repository\Admin;

use App\Entity\Admin\Dimension;
use App\Entity\Admin\DimensionsProducts;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DimensionsProducts|null find($id, $lockMode = null, $lockVersion = null)
 * @method DimensionsProducts|null findOneBy(array $criteria, array $orderBy = null)
 * @method DimensionsProducts[]    findAll()
 * @method DimensionsProducts[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DimensionsProductsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DimensionsProducts::class);
    }
}
