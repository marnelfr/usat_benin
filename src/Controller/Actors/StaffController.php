<?php

namespace App\Controller\Actors;

use App\Entity\Processing;
use App\Entity\Removal;
use App\Entity\Remover;
use App\Entity\Transfer;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Knp\Snappy\Pdf;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
        $waitingTransfer = count($em->getRepository(Transfer::class)->findBy(['deleted' => 0, 'status' => 'waiting']));
        $waitingRemoval = count($em->getRepository(Removal::class)->findBy(['deleted' => 0, 'status' => 'waiting']));
        $finalizedTransfer = count($em->getRepository(Transfer::class)->findBy(['deleted' => 0, 'status' => 'finalized']));
        $finalizedRemoval = count($em->getRepository(Removal::class)->findBy(['deleted' => 0, 'status' => 'finalized']));

        $data = compact('waitingRemoval', 'waitingTransfer', 'finalizedRemoval', 'finalizedTransfer');
        return $this->render('actors/staff/index.html.twig', $data);
    }


    /**
     * La liste des demande de transfert afficher au staff
     *
     * @Route("/staff/transfer/waiting", name="staff_transfer_index", methods={"GET"})
     */
    public function transfer_index(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        return $this->render('actors/staff/transfer/index.html.twig', [
            'title' => 'En attente',
            'btnLabel' => 'Traiter',
            'btnPath' => 'staff_transfer_treatment',
            'noData' => 'Aucune demande en attente',
            'transfers' => $this->getDoctrine()->getRepository(Transfer::class)->getWaitingTransfer(),
        ]);
    }


    /**
     * La liste des demande d'enlevement afficher au staff
     *
     * @Route("/staff/removal/waiting", name="staff_removal_index", methods={"GET"})
     */
    public function removal_index(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        return $this->render('actors/staff/removal/index.html.twig', [
            'title' => 'En attente',
            'btnLabel' => 'Traiter',
            'btnPath' => 'staff_removal_treatment',
            'noData' => 'Aucune demande en attente',
            'removals' => $this->getDoctrine()->getRepository(Removal::class)->getWaitingRemoval(),
        ]);
    }
}
