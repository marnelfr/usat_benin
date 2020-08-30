<?php

namespace App\Controller\Actors;

use App\Entity\Removal;
use App\Entity\Remover;
use App\Entity\Vehicle;
use App\Service\UserAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AgentController
 * Le controlleur des actions spécifiques des agents.
 * Ne doit pas remplacer le CRUD des entités
 * @package App\Controller\Actors
 */
class AgentController extends AbstractController
{
    /**
     * Le tableau de bord des agents de la plateforme
     *
     * @Route("/actors/agent", name="actors_agent_dashboard")
     * @param Request                $request
     * @param EntityManagerInterface $em
     * @param UserAuthenticator      $authenticator
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request, EntityManagerInterface $em, UserAuthenticator $authenticator)
    {
        $emailVerifySuccessfully = $request->getSession()->getFlashBag()->get('emailVerifySuccessfully');
        if (isset($emailVerifySuccessfully[0])) {
            $authenticator->auth($emailVerifySuccessfully[0], $request);
        }

        $this->denyAccessUnlessGranted('ROLE_AGENT');

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
