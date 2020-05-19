<?php

namespace App\Repository\Admin;

use App\Entity\Admin\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function getAllByLocale($locale = 'pl')
    {
        $qb = $this->createQueryBuilder('p');

        $qb
            ->innerJoin('p.productsCategories', 'ppc')
//            ->innerJoin('p.productsDimensions', 'ppd')
            ->innerJoin('ppc.category', 'ppcc')
//            ->innerJoin('ppd.dimension', 'ppdd')
            ->innerJoin('ppcc.translations', 'ppcct')
            ->where($qb->expr()->eq('ppcct.locale', ':locale'))
            ->setParameter('locale', $locale)
        ;

        return $qb->getQuery()->getResult();
    }

		public function getProductsByCategories()
		{
				$qb = $this->createQueryBuilder('p');

				$qb
						->innerJoin('p.productsCategories', 'ppc')
						->innerJoin('ppc.category', 'ppcc')
						->groupBy('ppc.category')
				;

				dd($qb->getQuery()->getResult());
				return $qb->getQuery()->getResult();
    }

    // /**
    //  * @return Product[] Returns an array of Product objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Product
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
