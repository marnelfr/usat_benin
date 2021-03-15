<?php

namespace App\Repository;

use App\Entity\DemandeFile;
use App\Entity\File;
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

    public function add(File $file, string $useFor, $entity, string $entity_name = 'removal') {
        $demandeFile = new DemandeFile();
        $demandeFile->setUsedFor($useFor);
        $demandeFile->setFile($file);
        $demandeFile = $this->fillEntity($demandeFile, $entity, $entity_name);
        $this->_em->persist($demandeFile);
        return $demandeFile;
    }

    public function edit(File $file, string $useFor, $entity, string $entity_name = 'removal') {
        $demandeFile = $this->findOneBy([
            $entity_name => $entity,
            'usedFor' => $useFor
        ]);
        if (!$demandeFile) {
            return $this->add($file, $useFor, $entity, $entity_name);
        }
        $demandeFile->setUsedFor($useFor);
        $demandeFile->setFile($file);
        $demandeFile = $this->fillEntity($demandeFile, $entity, $entity_name);
        $this->_em->persist($demandeFile);
        return $demandeFile;
    }


    /**
     * @param DemandeFile $demandeFile
     * @param             $entity
     * @param             $entity_name
     *
     * @return DemandeFile
     */
    private function fillEntity(DemandeFile $demandeFile, $entity, $entity_name): DemandeFile
    {
        if ($entity_name === 'removal') {
            $demandeFile->setRemoval($entity);
        } elseif ($entity_name === 'vehicle'){
            $demandeFile->setVehicle($entity);
        } elseif ($entity_name === 'remover'){
            $demandeFile->setRemover($entity);
        } elseif ($entity_name === 'inform'){
            $demandeFile->setInform($entity);
        } elseif ($entity_name === 'user'){
            $demandeFile->setUser($entity);
        } else {
            $demandeFile->setTransfer($entity);
        }
        return $demandeFile;
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
