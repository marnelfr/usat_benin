<?php

namespace App\Controller;

use App\Entity\DemandeFile;
use App\Entity\Transfer;
use App\Entity\Vehicle;
use App\Form\VehicleType;
use App\Repository\TransferRepository;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/transfer")
 */
class TransferController extends AbstractController
{
    private $repo;

    public function __construct(TransferRepository $transferRepository)
    {
        $this->repo = $transferRepository;
    }

    /**
     * La liste des demande de transfert en attente
     *
     * @Route("/waiting", name="transfer_index", methods={"GET"})
     */
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        return $this->render('transfer/index.html.twig', [
            'title' => 'En attente',
            'noData' => 'Aucune demande en attente',
            'transfers' => $this->repo->findBy(['status' => 'waiting', 'manager' => $this->getUser()], ['id' => 'DESC']),
        ]);
    }

    /**
     * La liste des demande de transfert en attente
     *
     * @Route("/inprogress", name="transfer_index_inprogress", methods={"GET"})
     */
    public function index_waiting(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        return $this->render('transfer/index.html.twig', [
            'title' => 'en Cours',
            'noData' => 'Aucune demande en cours de traitement',
            'transfers' => $this->repo->findBy(['status' => 'inprogress', 'manager' => $this->getUser()], ['id' => 'DESC']),
        ]);
    }

    /**
     * La liste des demande de transfert approuver, finaliser
     *
     * @Route("/finalized", name="transfer_index_finalized", methods={"GET"})
     */
    public function index_finalized(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        return $this->render('transfer/index.html.twig', [
            'title' => 'Approuvées',
            'noData' => 'Aucune demande appouvée pour le moment',
            'transfers' => $this->repo->findBy(['status' => 'finalized', 'manager' => $this->getUser()], ['id' => 'DESC']),
        ]);
    }

    /**
     * La liste des demande de transfert rejeter
     *
     * @Route("/rejected", name="transfer_index_rejected", methods={"GET"})
     */
    public function index_rejected(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        return $this->render('transfer/index.html.twig', [
            'title' => 'Rejetées',
            'noData' => 'Aucune demande rejetée',
            'transfers' => $this->repo->findBy(['status' => 'rejected', 'manager' => $this->getUser()], ['id' => 'DESC']),
        ]);
    }

    /**
     * @Route("/new", name="transfer_new", methods={"GET","POST"})
     */
    public function new(Request $request, FileUploader $uploader): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

//        $transfer = new Transfer();
//        $form = $this->createForm(TransferType::class, $transfer);
        $transfer = new Transfer();
        $vehicle = new Vehicle();
        $form = $this->createForm(VehicleType::class, $vehicle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $bol */
            $bol = $form->get('bol')->getData();

            if ($bol) {
                try{
                    $vehicle->setUser($this->getUser());
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($vehicle);

                    $message = 'Demande envoyée avec succès';
                    $typeMessage = 'success';
                    if(!$uploader->upload($bol, 'bol', $vehicle, 'vehicle')) {
                        $message = 'Demande envoyée avec erreur. Veuillez modifier votre demande et rajouter le connaissement';
                        $typeMessage = 'warning';
                    }

                    $transfer->setVehicle($vehicle);
                    $transfer->setManager($this->getUser());
                    $entityManager->persist($transfer);

                    $entityManager->flush();

                    $this->addFlash($typeMessage, $message);

                    return $this->redirectToRoute('transfer_index');
                }catch (\Exception $e) {
                    dump($e->getMessage()); die();
                }
            }
            $form->get('bol')->addError(new FormError('Veuillez téléverser le connaissement du véhicule'));
        }

        return $this->render('transfer/new.html.twig', [
            'transfer' => $transfer,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="transfer_show", methods={"GET"})
     */
    public function show(Transfer $transfer): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        return $this->render('transfer/show.html.twig', [
            'transfer' => $transfer,
        ]);
    }

    /**
     * @Route("/{id}/img", options = { "expose" = true }, name="transfer_img", methods={"GET"})
     */
    public function img(Request $request, Transfer $transfer) {
        if ($request->isXmlHttpRequest()) {
            $demande = $this->getDoctrine()->getRepository(DemandeFile::class)
                ->findOneBy(['transfer' => $transfer, 'usedFor' => 'assurance']);
            $view = $this->renderView('vehicle/show_img.html.twig', [
                'url' => '/uploads/' . $demande->getFile()->getLink(),
                'alt' => 'Assurance'
            ]);
            return new JsonResponse([
                'view' => $view,
                'error' => !(bool)$demande
            ]);
        }
        return new Response('access denied');
    }

    /**
     * @Route("/{id}/edit", name="transfer_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Transfer $transfer, FileUploader $uploader): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $em = $this->getDoctrine()->getManager();

        /** @var Vehicle $vehicle */
        $vehicle = $transfer->getVehicle();
        $form = $this->createForm(VehicleType::class, $vehicle);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $bol */
            $bol = $form->get('bol')->getData();

            if ($bol) {
                try{
                    $uploader->upload($bol, 'bol', $vehicle, 'vehicle', true);
                }catch (\Exception $e) {
                    dump($e->getMessage()); die();
                }
            }

            $transfer->setStatus('waiting');
            $transfer->setVehicle($vehicle);
            $em->persist($transfer);
            $em->flush();

            $this->addFlash('success', 'Demande modifiée avec succès');

            return $this->redirectToRoute('transfer_index');
        }

        return $this->render('transfer/edit.html.twig', [
            'transfer' => $transfer,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="transfer_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Transfer $transfer): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        if ($this->isCsrfTokenValid('delete'.$transfer->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($transfer);
            $entityManager->flush();
        }

        return $this->redirectToRoute('transfer_index');
    }
}
