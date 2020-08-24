<?php

namespace App\Repository;

use App\Entity\Removal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Removal|null find($id, $lockMode = null, $lockVersion = null)
 * @method Removal|null findOneBy(array $criteria, array $orderBy = null)
 * @method Removal[]    findAll()
 * @method Removal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RemovalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Removal::class);
    }

    public function getWaitingRemoval() {
        return $this->_em->createQuery(
            "select r
            from App\Entity\Removal r
            left join App\Entity\Processing p with p.removal = r
            where ((r.status not in ('inprogress', 'finalized', 'rejected')) or (r.status = 'inprogress' and p.verdict is null))
            and r.deleted = 0"
        )->getResult();
    }

    public function getInProgressRemoval() {
        return $this->_em->createQuery(
            "select r
            from App\Entity\Removal r
            inner join App\Entity\Processing p with p.transfer = r
            where r.status = 'inprogress'
            and p.verdict is not null
            and r.deleted = 0"
        )->getResult();
    }


    // /**
    //  * @return Removal[] Returns an array of Removal objects
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
    public function findOneBySomeField($value): ?Removal
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
