<?php

namespace App\Repository;

use App\Entity\Remover;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Remover|null find($id, $lockMode = null, $lockVersion = null)
 * @method Remover|null findOneBy(array $criteria, array $orderBy = null)
 * @method Remover[]    findAll()
 * @method Remover[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RemoverRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Remover::class);
    }

    // /**
    //  * @return Remover[] Returns an array of Remover objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Remover
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
