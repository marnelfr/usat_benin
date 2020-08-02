<?php

namespace App\Repository;

use App\Entity\Processing;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Processing|null find($id, $lockMode = null, $lockVersion = null)
 * @method Processing|null findOneBy(array $criteria, array $orderBy = null)
 * @method Processing[]    findAll()
 * @method Processing[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProcessingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Processing::class);
    }

    // /**
    //  * @return Processing[] Returns an array of Processing objects
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
    public function findOneBySomeField($value): ?Processing
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
