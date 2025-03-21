<?php

namespace App\Repository;

use App\Entity\Remover;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
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

    public function totalRemover(?User $user = null, $debut = null, $fin = null) {
        try {
            $params = [];
            $wherePeriod = '';
            $whereUser = '';
            if ($user) {
                $params['user'] = $user;
                $whereUser = 'and r.agent = :user';
            }
            if ($debut && $fin) {
                $fin = new \DateTime($fin->format('Y-m-d 23:59:59'));
                $params['debut'] = $debut;
                $params['fin'] = $fin;
                $wherePeriod = 'and r.createdAt >= :debut and r.createdAt <= :fin';
            }
            $total = $this->_em->createQuery(
                "select count(r) nombre
                from App\Entity\Remover r
                where r.deleted = 0
                {$whereUser}
                {$wherePeriod}"
            )->setParameters($params)
                ->getOneOrNullResult()
            ;
            return $total['nombre'];
        } catch (NonUniqueResultException $e) {
            return 0;
        }
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
