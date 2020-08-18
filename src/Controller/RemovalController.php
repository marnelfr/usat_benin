<?php

namespace App\Controller;

use App\Entity\Removal;
use App\Entity\Vehicle;
use App\Form\RemovalType;
use App\Repository\RemovalRepository;
use App\Repository\VehicleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/removal")
 */
class RemovalController extends AbstractController
{
    private $repo;
    private $vehicleRepo;
    /**
     * @var VehicleController
     */
    private $vehicleController;

    public function __construct(RemovalRepository $removalRepository, VehicleRepository $vehicleRepository, VehicleController $controller)
    {
        $this->repo = $removalRepository;
        $this->vehicleRepo = $vehicleRepository;
        $this->vehicleController = $controller;
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
            'removals' => $this->repo->findBy(['status' => 'waiting', 'agent' => $this->getUser()], ['id' => 'DESC']),
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
            'removals' => $this->repo->findBy(['status' => 'inprogress', 'agent' => $this->getUser()], ['id' => 'DESC']),
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
            'removals' => $this->repo->findBy(['status' => 'rejected', 'agent' => $this->getUser()], ['id' => 'DESC']),
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
            'removals' => $this->repo->findBy(['status' => 'finalized', 'agent' => $this->getUser()], ['id' => 'DESC']),
        ]);
    }

    /**
     * Pour l'affichage du formulaire d'enregistrement d'un enlevement
     *
     * @Route("/new", name="removal_new", methods={"GET","POST"})
     * @param Request $request
     *
     * @return Response
     */
    public function new(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $form = $this->vehicleRepo->checkVehicleForm($this->createFormBuilder());

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $vehicle = $this->vehicleRepo->findOneBy($data);

            if ($vehicle) {
                if ($request->isXmlHttpRequest()) {
                    return new JsonResponse([
                        'show_view' => $this->renderView('vehicle/show_modal.html.twig', [
                            'vehicle' => $vehicle,
                            'removal_new_saver_link' => $this->generateUrl('removal_new_saver', ['id' => $vehicle->getId()])
                        ]),
                        'typeMessage' => 'vehicle_found'
                    ]);
                }

                return $this->newSaver($request, $vehicle);
            }

            return $this->vehicleController->new($request, $this, $data, true);
        }

        if ($request->isXmlHttpRequest()) {
            return new JsonResponse([
                'typeMessage' => 'form',
                'form' => $this->renderView('removal/check_vehicle_form.html.twig', [
                    'form' => $form->createView()
                ])
            ]);
        }

        return $this->render('removal/check_vehicle.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * Pour l'enregistrement effectif de l'enlevement
     *
     * @Route("/new/{id}/save", name="removal_new_saver", methods={"POST", "GET"})
     * @param Request $request
     * @param Vehicle $vehicle
     *
     * @return Response
     */
    public function newSaver(Request $request, Vehicle $vehicle): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $removal = new Removal();
        $removal->setVehicle($vehicle);
        $form = $this->createForm(RemovalType::class, $removal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            if ($this->repo->findOneBy(['vehicle' => $vehicle])) {
                $this->addFlash('warning', 'Une demande d\'enlevement a déjà été fait pour ce véhicule');
            }else{
                $removal->setStatus('waiting')
                    ->setAgent($this->getUser());

                $entityManager->persist($removal);
                $entityManager->flush();
                $this->addFlash('success', 'Demande d\'enlevement envoyée avec succès');
            }

            return $this->redirectToRoute('removal_index');
        }

        return $this->render('removal/new.html.twig', [
            'removal' => $removal,
            'vehicle' => $vehicle,
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
