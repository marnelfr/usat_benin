<?php

namespace App\Repository;

use App\Entity\Importer;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
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

    public function totalImporter(?User $user = null, $debut = null, $fin = null) {
        try {
            $params = [];
            $wherePeriod = '';
            $whereUser = '';
            if ($user) {
                $params['user'] = $user;
                $whereUser = 'and i.user = :user';
            }
            if ($debut && $fin) {
                $fin = new \DateTime($fin->format('Y-m-d 23:59:59'));
                $params['debut'] = $debut;
                $params['fin'] = $fin;
                $wherePeriod = 'and i.createdAt >= :debut and i.createdAt <= :fin';
            }
            $total = $this->_em->createQuery(
               "select count(i) nombre
                from App\Entity\Importer i
                where i.deleted = 0
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
