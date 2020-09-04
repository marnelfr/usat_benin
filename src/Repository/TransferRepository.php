<?php

namespace App\Repository;

use App\Entity\Transfer;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Transfer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Transfer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Transfer[]    findAll()
 * @method Transfer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TransferRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Transfer::class);
    }

    public function totalTransfer($status, ?User $user = null) {
        try {
            $params['status'] = $status;
            if ($user) {
                $params['user'] = $user;
                $whereUser = 'and t.manager = :user';
            } else {
                $whereUser = '';
            }
            $total = $this->_em->createQuery(
                "select count(t) nombre
                from App\Entity\Transfer t
                where t.deleted = 0
                and t.status = :status
                {$whereUser}"
            )->setParameters($params)
                ->getOneOrNullResult()
            ;
        } catch (NonUniqueResultException $e) {
            return 0;
        }
        return $total['nombre'];
    }

    public function getWaitingTransfer() {
        return $this->_em->createQuery(
            "select t
            from App\Entity\Transfer t
            left join App\Entity\Processing p with p.transfer = t
            where ((t.status not in ('inprogress', 'finalized', 'rejected')) or (t.status = 'inprogress' and p.verdict is null))
            and t.deleted = 0"
        )->getResult();
    }

    public function getInProgressTransfer() {
        return $this->_em->createQuery(
            "select t
            from App\Entity\Transfer t
            inner join App\Entity\Processing p with p.transfer = t
            where t.status = 'inprogress'
            and p.verdict is not null
            and t.deleted = 0"
        )->getResult();
    }

    public function getFinalizedTransfer() {
        return $this->_em->createQuery(
            "select t
            from App\Entity\Transfer t
            inner join App\Entity\Processing p with p.transfer = t
            where t.status = 'finalized'
            and p.verdict is not null
            and t.deleted = 0"
        )->getResult();
    }

    public function getLastTwinty() {
        return $this->_em->createQuery(
            "select t
            from App\Entity\Transfer t
            inner join App\Entity\Processing p with p.transfer = t
            where t.status in ('inprogress', 'finalized', 'rejected')
            and t.deleted = 0
            order by p.createdAt desc"
        )->setMaxResults(20)
            ->getResult();
    }

    // /**
    //  * @return Transfer[] Returns an array of Transfer objects
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
    public function findOneBySomeField($value): ?Transfer
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
