<?php

namespace App\Repository;

use App\Entity\TouristRoutePhotoAlbumImage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method TouristRoutePhotoAlbumImage|null find($id, $lockMode = null, $lockVersion = null)
 * @method TouristRoutePhotoAlbumImage|null findOneBy(array $criteria, array $orderBy = null)
 * @method TouristRoutePhotoAlbumImage[]    findAll()
 * @method TouristRoutePhotoAlbumImage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TouristRoutePhotoAlbumImageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TouristRoutePhotoAlbumImage::class);
    }

    // /**
    //  * @return TouristRoutePhotoAlbumImage[] Returns an array of TouristRoutePhotoAlbumImage objects
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
    public function findOneBySomeField($value): ?TouristRoutePhotoAlbumImage
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
