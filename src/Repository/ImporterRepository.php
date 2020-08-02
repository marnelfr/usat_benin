<?php

namespace App\Repository;

use App\Entity\Importer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Importer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Importer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Importer[]    findAll()
 * @method Importer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImporterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Importer::class);
    }

    // /**
    //  * @return Importer[] Returns an array of Importer objects
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
    public function findOneBySomeField($value): ?Importer
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
