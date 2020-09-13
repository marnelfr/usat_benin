<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    /**
     * @var Security
     */
    private $security;

    public function __construct(ManagerRegistry $registry, Security $security)
    {
        parent::__construct($registry, User::class);
        $this->security = $security;
    }

    public function all() {
        return $this->_em->createQuery(
            "select u
            from App\Entity\User u
            where u.username <> 'nel'"
        )->getResult();
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(UserInterface $user, string $newEncodedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newEncodedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    public function isMakingTreatement() {
        $totalTreatement = $this->_em->createQuery(
            'select count(p)
            from App\Entity\Processing p
            where p.verdict is null
            and p.user = :user'
        )->setParameter(
            'user', $this->security->getUser()
        )->getSingleScalarResult();
        return (int)$totalTreatement > 0;
    }

    public function totalUser(string $profile_name = 'Agent', ?User $user = null, $debut = null, $fin = null) {
        try {
            $params = ['profile' => $profile_name];
            $wherePeriod = '';
            $whereUser = '';
            if ($user) {
                $params['user'] = $user;
                $whereUser = 'and u.user = :user';
            }
            if ($debut && $fin) {
                $fin = new \DateTime($fin->format('Y-m-d 23:59:59'));
                $params['debut'] = $debut;
                $params['fin'] = $fin;
                $wherePeriod = 'and u.createdAt >= :debut and u.createdAt <= :fin';
            }
            $total = $this->_em->createQuery(
                "select count(u) nombre
                from App\Entity\User u
                inner join App\Entity\Profil p with u.profil = p
                where p.slug = :profile
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
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
