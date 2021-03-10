<?php

namespace App\Controller\Actors;

use App\Entity\Removal;
use App\Entity\Remover;
use App\Entity\Vehicle;
use App\Service\UserAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Controller\AbstractController;
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
        $this->get('app.log')->add('AgentDashboard', 'index');

        $removalRepo = $em->getRepository(Removal::class);

        $finalized = $removalRepo->totalRemoval('finalized', $this->getUser());
        $waiting = $removalRepo->totalRemoval('waiting', $this->getUser());
        $vehicle = $em->getRepository(Vehicle::class)->totalVehicle($this->getUser());
        $remover = $em->getRepository(Remover::class)->totalRemover($this->getUser());

        $listTreatment = $removalRepo->getLastTwinty();
//        dd($listTreatment);

        return $this->render('actors/agent/index.html.twig', compact(
            'finalized', 'waiting', 'vehicle', 'remover', 'listTreatment'
        ));
    }
}
