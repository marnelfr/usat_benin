<?php

namespace App\Repository;

use App\Entity\Removal;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
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

    public function totalRemoval($status, ?User $user = null) {
        try {
            $params['status'] = $status;
            if ($user) {
                $params['user'] = $user;
                $whereUser = 'and r.agent = :user';
            } else {
                $whereUser = '';
            }
            $total = $this->_em->createQuery(
                "select count(r) nombre
                from App\Entity\Removal r
                where r.deleted = 0
                and r.status = :status
                {$whereUser}"
            )->setParameters($params)
                ->getOneOrNullResult()
            ;
            return $total['nombre'];
        } catch (NonUniqueResultException $e) {
            return 0;
        }
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

    public function getFinalizedRemoval() {
        return $this->_em->createQuery(
            "select r
            from App\Entity\Removal r
            inner join App\Entity\Processing p with p.removal = r
            where r.status = 'finalized'
            and p.verdict=1
            and r.deleted = 0"
        )->getResult();
    }

    public function getLastTwinty() {
        return $this->_em->createQuery(
            "select r
            from App\Entity\Removal r
            inner join App\Entity\Processing p with p.removal = r
            where r.status in ('inprogress', 'finalized', 'rejected')
            and r.deleted = 0
            order by p.createdAt desc"
        )->setMaxResults(20)
            ->getResult();
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
