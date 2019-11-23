<?php

namespace App\Repository;

use App\Entity\TouristRoute;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method TouristRoute|null find($id, $lockMode = null, $lockVersion = null)
 * @method TouristRoute|null findOneBy(array $criteria, array $orderBy = null)
 * @method TouristRoute[]    findAll()
 * @method TouristRoute[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TouristRouteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TouristRoute::class);
    }

    // /**
    //  * @return TouristRoute[] Returns an array of TouristRoute objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TouristRoute
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
