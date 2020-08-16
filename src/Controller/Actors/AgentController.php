<?php

namespace App\Controller\Actors;

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
    public function index()
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        return $this->render('actors/agent/index.html.twig', [
            'controller_name' => 'AgentController',
        ]);
    }
}
