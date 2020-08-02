<?php

namespace App\Repository;

use App\Entity\DemandeFile;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DemandeFile|null find($id, $lockMode = null, $lockVersion = null)
 * @method DemandeFile|null findOneBy(array $criteria, array $orderBy = null)
 * @method DemandeFile[]    findAll()
 * @method DemandeFile[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DemandeFileRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DemandeFile::class);
    }

    // /**
    //  * @return DemandeFile[] Returns an array of DemandeFile objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DemandeFile
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
