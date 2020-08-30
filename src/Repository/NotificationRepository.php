<?php

namespace App\Repository;

use App\Entity\Notification;
use App\Entity\Processing;
use App\Entity\Removal;
use App\Entity\Transfer;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Security;

/**
 * @method Notification|null find($id, $lockMode = null, $lockVersion = null)
 * @method Notification|null findOneBy(array $criteria, array $orderBy = null)
 * @method Notification[]    findAll()
 * @method Notification[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NotificationRepository extends ServiceEntityRepository
{
    /**
     * @var Security
     */
    private $security;

    public function __construct(ManagerRegistry $registry, Security $security)
    {
        parent::__construct($registry, Notification::class);
        $this->security = $security;
    }

    public function transferNotif(Transfer $transfer) {
        return $this->add($transfer->getProcessing(), $transfer);
    }

    public function removalNotif(Removal $removal) {
        return $this->add($removal->getProcessing(), null, $removal);
    }

    public function add(Processing $processing, ?Transfer $transfer = null, ?Removal $removal = null) {
        try {
            $notif = new Notification();
            $content = 'Votre demande ';
            if ($transfer) {
                $content .= 'de transfert du véhicule de châssis ' . $transfer->getVehicle()->getChassis() . ' a été ';
                $notif->setTransfer($transfer);
                $notif->setUser($transfer->getManager());
            }
            if ($removal) {
                $content .= 'd\'enlèvement du véhicule de châssis ' . $removal->getVehicle()->getChassis() . ' a été ';
                $notif->setRemoval($removal);
                $notif->setUser($removal->getAgent());
            }
            if ($processing->getVerdict()) {
                $content .= 'approuvée';
                $notif->setType('success');
                $notif->setTitle('Demande acceptée');
            } else {
                $content .= 'rejetée <br><b><u>Raison</u>: ' . $processing->getReason() . '</b>';
                $notif->setType('danger');
                $notif->setTitle('Demande rejetée');
            }
            $notif->setContent($content);
            $notif->setCreator($this->security->getUser());

            $this->_em->persist($notif);

            return true;
        }catch (\Exception $e) {
            return false;
        }

    }

    // /**
    //  * @return Notification[] Returns an array of Notification objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Notification
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
