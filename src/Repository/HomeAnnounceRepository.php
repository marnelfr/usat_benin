<?php

namespace App\Repository;

use App\Entity\HomeAnnounce;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method HomeAnnounce|null find($id, $lockMode = null, $lockVersion = null)
 * @method HomeAnnounce|null findOneBy(array $criteria, array $orderBy = null)
 * @method HomeAnnounce[]    findAll()
 * @method HomeAnnounce[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HomeAnnounceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HomeAnnounce::class);
    }

    // /**
    //  * @return HomeAnnounce[] Returns an array of HomeAnnounce objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?HomeAnnounce
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
