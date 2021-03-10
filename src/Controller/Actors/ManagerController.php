<?php

namespace App\Controller\Actors;

use App\Entity\Importer;
use App\Entity\Transfer;
use App\Service\UserAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use App\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ManagerController
 * Le controlleur des actions spécifiques des manager.
 * Ne doit pas remplacer le CRUD des entités
 * @package App\Controller\Actors
 */
class ManagerController extends AbstractController
{
    /**
     * Le tableau de bord des managers de la plateforme
     *
     * @Route("/actors/manager", name="actors_manager_dashboard")
     * @param Request                $request
     * @param EntityManagerInterface $em
     *
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

        $this->denyAccessUnlessGranted('ROLE_MANAGER');
        $this->get('app.log')->add('ManagerDashboard', 'index');

        $transfertRepo = $em->getRepository(Transfer::class);

        $finalized = $transfertRepo->totalTransfer('finalized', $this->getUser()); //->findBy(['deleted' => 0, 'status' => , 'manager' => $this->getUser()]));
        $waiting = $transfertRepo->totalTransfer('waiting', $this->getUser()); //o->findBy(['deleted' => 0, 'status' => , 'manager' => $this->getUser()]));
        $rejected = $transfertRepo->totalTransfer('rejected', $this->getUser()); //->findBy(['deleted' => 0, 'status' => , 'manager' => $this->getUser()]));
        $importer = $em->getRepository(Importer::class)->totalImporter($this->getUser());

        $listTreatment = $transfertRepo->getLastTwinty();
//        dd($listTreatment);

        return $this->render('actors/manager/index.html.twig', compact(
            'finalized', 'waiting', 'rejected', 'importer', 'listTreatment'
        ));
    }
}
