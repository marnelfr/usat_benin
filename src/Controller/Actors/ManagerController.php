<?php

namespace App\Controller\Actors;

use App\Entity\Importer;
use App\Entity\Transfer;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ManagerController
 * Le controlleur des actions spécifiques des manager.
 * Ne doit pas remplacer le CRUD des entités
 * @package App\Controller\Actors
 * @IsGranted("ROLE_MANAGER")
 */
class ManagerController extends AbstractController
{
    /**
     * Le tableau de bord des managers de la plateforme
     *
     * @Route("/actors/manager", name="actors_manager_dashboard")
     * @param EntityManagerInterface $em
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(EntityManagerInterface $em)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $transfertRepo = $em->getRepository(Transfer::class);

        $finalized = count($transfertRepo->findBy(['deleted' => 0, 'status' => 'finalized', 'manager' => $this->getUser()]));
        $waiting = count($transfertRepo->findBy(['deleted' => 0, 'status' => 'waiting', 'manager' => $this->getUser()]));
        $rejected = count($transfertRepo->findBy(['deleted' => 0, 'status' => 'rejected', 'manager' => $this->getUser()]));
        $importer = count($em->getRepository(Importer::class)->findBy(['user' => $this->getUser(), 'deleted'=> 0]));

        $listTreatment = $transfertRepo->getLastTwinty();

        return $this->render('actors/manager/index.html.twig', compact(
            'finalized', 'waiting', 'rejected', 'importer', 'listTreatment'
        ));
    }
}
