<?php

namespace App\Controller\Actors;

use App\Entity\Removal;
use App\Entity\Transfer;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class StaffController
 * Le controlleur des actions spécifiques du personnel de USAT.
 * Ne doit pas remplacer le CRUD des entités
 * @package App\Controller\Actors
 * @IsGranted("ROLE_STAFF")
 */
class StaffController extends AbstractController
{
    /**
     * Le tableau de bord du personnel de USAT de la plateforme
     *
     * @Route("/actors/staff", name="actors_staff_dashboard")
     */
    public function index(EntityManagerInterface $em)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $waitingTransfer = $em->getRepository(Transfer::class)->findBy([]);
        $waitingRemoval = $em->getRepository(Removal::class)->findBy([]);
        $finalizedTransfer = $em->getRepository(Transfer::class)->findBy([]);
        $finalizedRemoval = $em->getRepository(Removal::class)->findBy([]);
        return $this->render('actors/staff/index.html.twig', [
            'controller_name' => 'StaffController',
        ]);
    }
}
