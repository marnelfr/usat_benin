<?php

namespace App\Repository;

use App\Entity\Imform;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Imform|null find($id, $lockMode = null, $lockVersion = null)
 * @method Imform|null findOneBy(array $criteria, array $orderBy = null)
 * @method Imform[]    findAll()
 * @method Imform[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImformRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Imform::class);
    }

    // /**
    //  * @return Imform[] Returns an array of Imform objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Imform
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
