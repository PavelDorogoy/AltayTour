<?php

namespace App\Repository;

use App\Entity\TouristRouteType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method TouristRouteType|null find($id, $lockMode = null, $lockVersion = null)
 * @method TouristRouteType|null findOneBy(array $criteria, array $orderBy = null)
 * @method TouristRouteType[]    findAll()
 * @method TouristRouteType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TouristRouteTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TouristRouteType::class);
    }

    // /**
    //  * @return TouristRouteType[] Returns an array of TouristRouteType objects
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
    public function findOneBySomeField($value): ?TouristRouteType
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
