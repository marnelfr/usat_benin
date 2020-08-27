<?php

namespace App\Controller\Actors;

use App\Entity\Removal;
use App\Entity\Remover;
use App\Entity\Vehicle;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AgentController
 * Le controlleur des actions spécifiques des agents.
 * Ne doit pas remplacer le CRUD des entités
 * @package App\Controller\Actors
 * @IsGranted("ROLE_AGENT")
 */
class AgentController extends AbstractController
{
    /**
     * Le tableau de bord des agents de la plateforme
     *
     * @Route("/actors/agent", name="actors_agent_dashboard")
     */
    public function index(EntityManagerInterface $em)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $removalRepo = $em->getRepository(Removal::class);

        $finalized = count($removalRepo->findBy(['deleted' => 0,'status' => 'finalized', 'agent' => $this->getUser()]));
        $waiting = count($removalRepo->findBy(['deleted' => 0,'status' => 'waiting', 'agent' => $this->getUser()]));
        $vehicle = count($em->getRepository(Vehicle::class)->findBy(['deleted' => 0, 'user' => $this->getUser()]));
        $remover = count($em->getRepository(Remover::class)->findBy(['agent' => $this->getUser(), 'deleted'=> 0]));

        $listTreatment = $removalRepo->getLastTwinty();

        return $this->render('actors/agent/index.html.twig', compact(
            'finalized', 'waiting', 'vehicle', 'remover', 'listTreatment'
        ));
    }
}
