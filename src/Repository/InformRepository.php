<?php

namespace App\Repository;

use App\Entity\Inform;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Inform|null find($id, $lockMode = null, $lockVersion = null)
 * @method Inform|null findOneBy(array $criteria, array $orderBy = null)
 * @method Inform[]    findAll()
 * @method Inform[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InformRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Inform::class);
    }


    public function all() {
        $sansImages = $this->_em->createQuery(
            "select i.id, i.title, i.resume, i.createdAt, u.username, 0 idFile
            from App\Entity\Inform i
            inner join App\Entity\User u with i.user = u
            where i not in (
              select ii
              from App\Entity\DemandeFile d
              inner join App\Entity\Inform ii with d.inform = ii
            )
            order by i.createdAt desc"
        )->setMaxResults(2)
            ->getResult();
        $avecImages = $this->_em->createQuery(
            "select i.id, i.title, i.resume, i.createdAt, u.username, d.id idFile
            from App\Entity\Inform i
            inner join App\Entity\User u with i.user = u
            inner join App\Entity\DemandeFile d with d.inform = i
            order by i.createdAt desc"
        )->setMaxResults(2)
            ->getResult();
        return array_merge($sansImages, $avecImages);
    }

    // /**
    //  * @return Inform[] Returns an array of Inform objects
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
    public function findOneBySomeField($value): ?Inform
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
