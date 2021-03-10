<?php

namespace App\Controller;

use App\Entity\DemandeFile;
use App\Entity\File;
use App\Entity\Notification;
use App\Entity\Removal;
use App\Entity\Vehicle;
use App\Form\RemovalType;
use App\Repository\RemovalRepository;
use App\Repository\VehicleRepository;
use App\Service\FileUploader;
use App\Service\RefGenerator;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\File\UploadedFile;
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
    /**
     * @var FileUploader
     */
    private $uploader;

    public function __construct(RemovalRepository $removalRepository, VehicleRepository $vehicleRepository, VehicleController $controller, FileUploader $uploader)
    {
        $this->repo = $removalRepository;
        $this->vehicleRepo = $vehicleRepository;
        $this->vehicleController = $controller;
        $this->uploader = $uploader;
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
     * Pour l'affichage de l'étape 1 du formulaire d'enregistrement d'un enlevement
     *
     * @Route("/new", name="removal_new", methods={"GET","POST"})
     * @param Request $request
     *
     * @return Response
     */
    public function new(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        //On génère le formulaire pour la vérification de l'existance des véhicules avec des constraintes et tout
        $form = $this->vehicleRepo->checkVehicleForm($this->createFormBuilder());

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();//On recupère les données du formulaire

            //On vérifie l'existence propable d'un vehicule a base de ses informations
            $vehicle = $this->vehicleRepo->findOneBy($data);

            if ($vehicle) { //Si un véhicule a été trouvé a base de ses informations,
                if ($request->isXmlHttpRequest()) { //Si c'est par ajax on fait la demande
                    //On renvoie de quoi afficher le modal contenant les informations du vehicule avec
                    // un lien vers l'étape 3 du formulaire
                    return new JsonResponse([
                        'show_view' => $this->renderView('vehicle/show_modal.html.twig', [
                            'vehicle' => $vehicle,
                            'removal_new_saver_link' => $this->generateUrl('removal_new_saver', ['id' => $vehicle->getId()])
                        ]),
                        'typeMessage' => 'vehicle_found'
                    ]);
                }
                //Si c'est pas une requette ajax, on renvoie directement vers l'étape 3 du formulaire
                return $this->newSaver($request, $vehicle);
            }
            //Si aucun vehicule n'est trouvé, on renvoie vers l'étape 2 du formulaire pour l'enregsitrement du véhicule.
            return new JsonResponse([
                'typeMessage' => 'next',
                'view_new_vehicle' => $this->vehicleController->new($request, $this, $data, true)
            ]);
        }

        //Même pour l'affichage du formalaire, on prévoit le cas où une demande sera fait par ajax (a cause d'un besoin hein))))))))
        if ($request->isXmlHttpRequest()) {
            return new JsonResponse([
                'typeMessage' => 'form',
                'form' => $this->renderView('removal/check_vehicle_form.html.twig', [
                    'form' => $form->createView()
                ])
            ]);
        }

        //Pour les demnades non ajax
        return $this->render('removal/check_vehicle.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/{use}/img", options = { "expose" = true }, name="removal_img", methods={"GET"})
     * @param Request $request
     *
     * @return Response
     */
    public function img(Request $request, Removal $removal, FileUploader $uploader) {
        if ($request->isXmlHttpRequest()) {
            $use = $request->get('use');
            if ($use === 'bol') {
                return $this->vehicleController->img($request, $removal->getVehicle(), $uploader);
            }
            $fileLink = $uploader->fileLink($removal, 'removal', $use);
            $view = $this->renderView('vehicle/show_img.html.twig', [
                'url' => $fileLink,
                'alt' => 'Document scanné',
            ]);
            return new JsonResponse([
                'view' => $view,
                'error' => $fileLink === false
            ]);
        }
        return new Response('access denied');
    }

    /**
     * Pour l'enregistrement effectif de l'enlevement
     * Affiche l'etape 3 du forumaire puis traite sa soumission
     *
     * @Route("/new/{id}/save", name="removal_new_saver", methods={"POST", "GET"})
     * @param Request $request
     * @param Vehicle $vehicle
     *
     * @return Response
     */
    public function newSaver(Request $request, Vehicle $vehicle, RefGenerator $generator): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $removal = new Removal();
        $removal->setVehicle($vehicle);
        $form = $this->createForm(RemovalType::class, $removal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            //On verifie si une demande d'enlevement avait déjà été fait par rapport au vehicule
            if ($this->repo->findOneBy(['vehicle' => $vehicle])) {
                $this->addFlash('warning', 'Une demande d\'enlevement a déjà été fait pour ce véhicule');
            }else{
                /** @var UploadedFile $bfu */
                $bfu = $form->get('bfu')->getData();
                /** @var UploadedFile $entry */
                $entry = $form->get('entry')->getData();
                /** @var UploadedFile $receipt */
                $receipt = $form->get('receipt')->getData();

                if (!$bfu || !$entry || !$receipt) {
                    $form->get('bfu')->addError(new FormError('Veuillez téléverser la copie scanné du BFU réglé'));
                    $form->get('receipt')->addError(new FormError('Veuillez téléverser la copie scanné du reçu de banque'));
                    $form->get('entry')->addError(new FormError('Veuillez téléverser la copie scanné de la déclaration de Douane'));
                    goto FIN;
                }

                $removal->setStatus('waiting')
                    ->setAgent($this->getUser())
                    ->setReference($generator->generate('removal'))
                ;
                $entityManager->persist($removal);

                $fileNotSent = false;
                foreach (['bfu' => $bfu, 'entry' => $entry, 'receipt' => $receipt] as $key => $uploadedFile) {
                    if (!$this->uploader->upload($uploadedFile, $key, $removal)) {
                        $fileNotSent = true;
                    }
                }
                if ($fileNotSent) {
                    $this->addFlash('warning', 'Demande d\'enlevement avec erreur d\'enregistrement. Veuiller modifier la demande et rajouter les fichiers scannés');
                } else {
                    $this->addFlash('success', 'Demande d\'enlevement envoyée avec succès');
                }
            }
            return $this->redirectToRoute('removal_index');
        }

        FIN:
        //Au cas une erreur est trouvé par rapport au formulaire
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
     * @param Request $request
     * @param Removal $removal
     *
     * @return string|Response
     */
    public function edit(Request $request, Removal $removal) {
        return $this->vehicleController->new($request, $this, ['id' => $removal->getVehicle()->getId()], false, true);
    }

    /**
     * @Route("/edit/{id}/saver", name="removal_edit_saver", methods={"GET","POST"}, requirements={"id":"\d+"})
     * @throws \Exception
     */
    public function editSaver(Request $request, Removal $removal): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $form = $this->createForm(RemovalType::class, $removal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $objectManager = $this->getDoctrine()->getManager();

            /** @var UploadedFile $bfu */
            $bfu = $form->get('bfu')->getData();
            /** @var UploadedFile $entry */
            $entry = $form->get('entry')->getData();
            /** @var UploadedFile $receipt */
            $receipt = $form->get('receipt')->getData();

            foreach (['bfu' => $bfu, 'entry' => $entry, 'receipt' => $receipt] as $key => $uploadedFile) {
                if ($uploadedFile) {
                    $this->uploader->upload($uploadedFile, $key, $removal, 'removal', true);
                }
            }
            $removal->setStatus('waiting');
            $removal->setCreatedAt(new \DateTime());
            // TODO: si l'enlevement a été éditer sans que la personne ne clique sur la notification, on la marque quand même comme lu
//            $objectManager->getRepository(Notification::class)->find

            $objectManager->flush();

            return $this->redirectToRoute('removal_index');
        }

        return $this->render('removal/edit.html.twig', [
            'removal' => $removal,
            'edit' => true,
            'vehicle' => $removal->getVehicle(),
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
