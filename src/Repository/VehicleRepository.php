<?php

namespace App\Repository;

use App\Entity\Brand;
use App\Entity\User;
use App\Entity\Vehicle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * @method Vehicle|null find($id, $lockMode = null, $lockVersion = null)
 * @method Vehicle|null findOneBy(array $criteria, array $orderBy = null)
 * @method Vehicle[]    findAll()
 * @method Vehicle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VehicleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vehicle::class);
    }

    public function totalVehicle(?User $user = null, $debut = null, $fin = null) {
        try {
            $params = [];
            $wherePeriod = '';
            $whereUser = '';
            if ($user) {
                $params['user'] = $user;
                $whereUser = 'and v.user = :user';
            }
            if ($debut && $fin) {
                $fin = new \DateTime($fin->format('Y-m-d 23:59:59'));
                $params['debut'] = $debut;
                $params['fin'] = $fin;
                $wherePeriod = 'and v.createdAt >= :debut and v.createdAt <= :fin';
            }
            $total = $this->_em->createQuery(
                "select count(v) nombre
                from App\Entity\Vehicle v
                where v.deleted = 0
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


    public function checkVehicleForm(FormBuilderInterface $builder): FormInterface
    {
        return $builder
            ->add('brand', EntityType::class, [
                'class' => Brand::class,
                'required' => true,
                'label' => 'Marque',
                'placeholder' => 'Selectionnez une marque',
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez choisir une marque'])
                ]
            ])->add('chassis', TextType::class, [
                'label' => 'Châssis',
                'required' => true,
                'constraints' => [
                    new Length(17),
                    new NotBlank(['message' => 'Impossible de faire un traitement sans numéro châssis'])
                ]
            ])
            ->getForm()
        ;
    }

    // /**
    //  * @return Vehicle[] Returns an array of Vehicle objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Vehicle
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
