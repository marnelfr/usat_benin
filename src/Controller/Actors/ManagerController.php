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
     */
    public function index(EntityManagerInterface $em)
    {
        $transfertRepo = $em->getRepository(Transfer::class);

        $finalized = count($transfertRepo->findBy(['status' => 'finalized']));
        $inprogress = count($transfertRepo->findBy(['status' => 'inprogress']));
        $rejected = count($transfertRepo->findBy(['status' => 'rejected']));
        $importer = count($em->getRepository(Importer::class)->findBy(['manager' => $this->getUser(), 'deleted'=> 0]));

        return $this->render('actors/manager/index.html.twig', compact(
            'finalized', 'inprogress', 'rejected', 'importer'
        ));
    }
}
