<?php

namespace App\Repository;

use App\Entity\TourEquipment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method TourEquipment|null find($id, $lockMode = null, $lockVersion = null)
 * @method TourEquipment|null findOneBy(array $criteria, array $orderBy = null)
 * @method TourEquipment[]    findAll()
 * @method TourEquipment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TourEquipmentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TourEquipment::class);
    }

    // /**
    //  * @return TourEquipment[] Returns an array of TourEquipment objects
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
    public function findOneBySomeField($value): ?TourEquipment
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
