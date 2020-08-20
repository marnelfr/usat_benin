<?php

namespace App\Repository;

use App\Entity\Processing;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Security;

/**
 * @method Processing|null find($id, $lockMode = null, $lockVersion = null)
 * @method Processing|null findOneBy(array $criteria, array $orderBy = null)
 * @method Processing[]    findAll()
 * @method Processing[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProcessingRepository extends ServiceEntityRepository
{
    /**
     * @var Security
     */
    private $security;

    public function __construct(ManagerRegistry $registry, Security $security)
    {
        parent::__construct($registry, Processing::class);
        $this->security = $security;
    }

    /**
     * @param        $entity
     * @param string $entity_name
     * @param null   $verdict
     * @param string $reason
     *
     * @return Processing
     */
    public function add($entity, $entity_name = 'transfer', $verdict = null, $reason = ''): Processing
    {
        $p = new Processing();
        $p->setUser($this->security->getUser());
        if ($entity_name === 'transfer') {
            $p->setTransfer($entity);
        }
        if ($entity_name === 'removal') {
            $p->setRemoval($entity);
        }
        if ($verdict !== null) {
            $p->setVerdict($verdict)
                ->setReason($reason);
        }
        $this->_em->persist($p);
        return $p;
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
