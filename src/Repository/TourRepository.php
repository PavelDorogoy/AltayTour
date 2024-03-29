<?php

namespace App\Repository;

use App\Entity\Tour;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Exception;

/**
 * @method Tour|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tour|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tour[]    findAll()
 * @method Tour[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TourRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tour::class);
    }

    /**
     * @return Tour[] Returns an array of Tour objects
     * @throws Exception
     */
    public function findCurrent()
    {
        $curDate = new \DateTime('now');
        $curDate->setTime(0, 0, 0);

        $qb = $this->createQueryBuilder('u');
        $qb->select('u')
            ->where('u.date >= :curDate')
            ->setParameter('curDate', $curDate);
        return $qb->getQuery()->getResult();
    }

    /**
     * @param int $routeID
     * @return Tour[] Returns an array of Tour objects
     * @throws Exception
     */
    public function findCurrentByRoute(int $routeID)
    {
        $curDate = new \DateTime('now');
        $curDate->setTime(0, 0, 0);

        $qb = $this->createQueryBuilder('u');
        $qb->select('u')
            ->where('u.date >= :curDate AND u.route = :routeID')
            ->setParameter('curDate', $curDate)
            ->setParameter('routeID', $routeID);
        return $qb->getQuery()->getResult();
    }

    /**
     * @param int $instructorID
     * @return Tour[] Returns an array of Tour objects
     * @throws Exception
     */
    public function findCurrentByInstructor(int $instructorID)
    {
        $curDate = new \DateTime('now');
        $curDate->setTime(0, 0, 0);

        $qb = $this->createQueryBuilder('u');
        $qb->select('u')
            ->where('u.date >= :curDate AND u.instructor = :instructorID')
            ->orderBy('u.date', 'ASC')
            ->setParameter('curDate', $curDate)
            ->setParameter('instructorID', $instructorID);
        return $qb->getQuery()->getResult();
    }

    // /**
    //  * @return Tour[] Returns an array of Tour objects
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
    public function findOneBySomeField($value): ?Tour
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
