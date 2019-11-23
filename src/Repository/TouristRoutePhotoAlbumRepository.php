<?php

namespace App\Repository;

use App\Entity\TouristRoutePhotoAlbum;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method TouristRoutePhotoAlbum|null find($id, $lockMode = null, $lockVersion = null)
 * @method TouristRoutePhotoAlbum|null findOneBy(array $criteria, array $orderBy = null)
 * @method TouristRoutePhotoAlbum[]    findAll()
 * @method TouristRoutePhotoAlbum[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TouristRoutePhotoAlbumRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TouristRoutePhotoAlbum::class);
    }

    // /**
    //  * @return TouristRoutePhotoAlbum[] Returns an array of TouristRoutePhotoAlbum objects
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
    public function findOneBySomeField($value): ?TouristRoutePhotoAlbum
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
