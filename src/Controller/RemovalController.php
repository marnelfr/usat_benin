<?php

namespace App\Controller;

use App\Entity\Removal;
use App\Entity\Ship;
use App\Entity\Vehicle;
use App\Form\CheckVehicleType;
use App\Form\RemovalType;
use App\Repository\RemovalRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/removal")
 */
class RemovalController extends AbstractController
{
    private $repo;

    public function __construct(RemovalRepository $removalRepository)
    {
        $this->repo = $removalRepository;
    }


    /**
     * @Route("/", name="removal_index", methods={"GET"})
     */
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        return $this->render('removal/index.html.twig', [
            'title' => 'En attente',
            'noData' => 'Aucune demande en attente',
            'transfers' => $this->repo->findBy(['status' => 'waiting', 'agent' => $this->getUser()], ['id' => 'DESC']),
        ]);
//        return $this->render('removal/index.html.twig', [
//            'removals' => $removalRepository->findAll(),
//        ]);
    }
    /**
     * @Route("/inprogress", name="removal_index_inprogress", methods={"GET"})
     */
    public function index_inprogress(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        return $this->render('removal/index.html.twig', [
            'title' => 'en Cours',
            'noData' => 'Aucune demande en cours de traitement',
            'transfers' => $this->repo->findBy(['status' => 'inprogress', 'agent' => $this->getUser()], ['id' => 'DESC']),
        ]);
    }
    /**
     * @Route("/rejected", name="removal_index_rejected", methods={"GET"})
     */
    public function index_rejected(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        return $this->render('removal/index.html.twig', [
            'title' => 'Rejetées',
            'noData' => 'Aucune demande rejetée',
            'transfers' => $this->repo->findBy(['status' => 'rejected', 'agent' => $this->getUser()], ['id' => 'DESC']),
        ]);
    }
    /**
     * @Route("/finalized", name="removal_index_finalized", methods={"GET"})
     */
    public function index_finalized(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        return $this->render('removal/index.html.twig', [
            'title' => 'Approuvées',
            'noData' => 'Aucune demande appouvée pour le moment',
            'transfers' => $this->repo->findBy(['status' => 'finalized', 'agent' => $this->getUser()], ['id' => 'DESC']),
        ]);
    }

    /**
     * Pour l'affichage du formulaire d'enregistrement d'un enlevement
     *
     * @Route("/new", name="removal_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        //On remplie l'object pour eviter des erreurs qui ne nous interressent pas
        $vehicle = new Vehicle();
        $vehicle->setConsignee('NelDev')
            ->setUser($this->getUser())
            ->setBolFileName('nel')
            ->setCameAt(new \DateTime('yesterday'))
            ->setPutInUseAt(new \DateTime('yesterday'))
            ->setShip($this->getDoctrine()->getRepository(Ship::class)->find(1))
        ;
        $form = $this->createForm(CheckVehicleType::class, $vehicle);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            //Si il y a d'erreur, ce qui nous interresse
            if ($form->count() > 0) {
                $old = $this->getDoctrine()->getRepository(Vehicle::class)->findOneBy([
                    'chassis' => $vehicle->getChassis(),
                    'brand' => $vehicle->getBrand()
                ]);

                //Si ça sous-entend que le vehicule existait...
                // TODO: Trouver le moyen d'envoyer le truc labas
                if ($old) {
                    return $this->redirectToRoute('removal_new_saver', [
                        'chassis' => $vehicle->getChassis(),
                        'brand' => $vehicle->getBrand()->getId()
                    ]);
                }

                goto FIN;
            }

            //Si il y a pas d'erreur, alors il s'agit d'un nouveau vehicule. On redirige alors vers la création du vehicule.
            //Après la création du vehicule, l'utilisateur pourra alors être rediriger vers le formulaire d'enregsitrement de l'enlevement
            $ve = new Vehicle();
            $ve->setBrand($vehicle->getBrand())
                ->setChassis($vehicle->getChassis())
            ;
            return $this->redirectToRoute('vehicle_new', [
                'vehicle' => $ve
            ]);
        }

        FIN:
        return $this->render('removal/check_vehicle.html.twig', [
            'removal' => $vehicle,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Pour l'enregistrement effectif de l'enlevement
     *
     * @Route("/new/save", name="removal_new_saver", methods={"POST", "GET"})
     */
    public function newSaver(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        dump($request->request->all(), $request->query->all()); die();

        $removal = new Removal();
        $form = $this->createForm(RemovalType::class, $removal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($removal);
            $entityManager->flush();

            return $this->redirectToRoute('removal_index');
        }

        return $this->render('removal/new.html.twig', [
            'removal' => $removal,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="removal_show", methods={"GET"})
     */
    public function show(Removal $removal): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        return $this->render('removal/show.html.twig', [
            'removal' => $removal,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="removal_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Removal $removal): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $form = $this->createForm(RemovalType::class, $removal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('removal_index');
        }

        return $this->render('removal/edit.html.twig', [
            'removal' => $removal,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="removal_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Removal $removal): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        if ($this->isCsrfTokenValid('delete'.$removal->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($removal);
            $entityManager->flush();
        }

        return $this->redirectToRoute('removal_index');
    }
}
