<?php

namespace App\Controller;

use App\Entity\Removal;
use App\Entity\Transfer;
use App\Entity\Vehicle;
use App\Form\VehicleType;
use App\Repository\TransferRepository;
use App\Service\FileUploader;
use App\Service\RefGenerator;
use Knp\Snappy\Image;
use Knp\Snappy\Pdf;
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
        $this->denyAccessUnlessGranted('ROLE_MANAGER');

        $this->get('app.log')->add(Transfer::class, 'index');

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
        $this->denyAccessUnlessGranted('ROLE_MANAGER');

        $this->get('app.log')->add(Transfer::class . '.Waiting', 'index');

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
        $this->denyAccessUnlessGranted('ROLE_MANAGER');

        $this->get('app.log')->add(Transfer::class . '.Finalized', 'index');

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
        $this->denyAccessUnlessGranted('ROLE_MANAGER');

        $this->get('app.log')->add(Transfer::class . '.Rejected', 'index');

        return $this->render('transfer/index.html.twig', [
            'title' => 'Rejetées',
            'noData' => 'Aucune demande rejetée',
            'transfers' => $this->repo->findBy(['status' => 'rejected', 'manager' => $this->getUser()], ['id' => 'DESC']),
        ]);
    }

    /**
     * @Route("/new", name="transfer_new", methods={"GET","POST"})
     * @param Request      $request
     * @param FileUploader $uploader
     * @param RefGenerator $generator
     *
     * @return Response
     */
    public function new(Request $request, FileUploader $uploader, RefGenerator $generator): Response
    {
        $this->denyAccessUnlessGranted('ROLE_MANAGER');

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
                    $transfer->setReference($generator->generate());
                    $entityManager->persist($transfer);

                    $entityManager->flush();

                    $this->get('app.log')->add(Transfer::class, 'new', $transfer->getId());

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
     * @param Transfer $transfer
     *
     * @return Response
     */
    public function show(Transfer $transfer): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $this->get('app.log')->add(Transfer::class, 'show', $transfer->getId(), ['id']);

        return $this->render('transfer/show.html.twig', [
            'transfer' => $transfer,
        ]);
    }

    /**
     * @Route("/{id}/img", options = { "expose" = true }, name="transfer_img", methods={"GET"})
     * @param Request      $request
     * @param Transfer     $transfer
     * @param FileUploader $uploader
     *
     * @return JsonResponse|Response
     */
    public function img(Request $request, Transfer $transfer, FileUploader $uploader) {
        if ($request->isXmlHttpRequest()) {
            $fileLink = $uploader->fileLink($transfer, 'transfer', 'assurance');
            $view = $this->renderView('vehicle/show_img.html.twig', [
                'url' => $fileLink,
                'alt' => 'Assurance'
            ]);

            $this->get('app.log')->add('Transfer.Image', 'show', $transfer->getId(), ['id']);

            return new JsonResponse([
                'view' => $view,
                'error' => $fileLink === false
            ]);
        }
        return new Response('access denied');
    }


    /**
     * @Route("/{id}/pdf", options = { "expose" = true }, name="transfer_attestation_pdf", methods={"GET"})
     * @param Request      $request
     * @param FileUploader $uploader
     * @param Pdf          $pdf
     * @param Image        $imager
     *
     * @return JsonResponse|Response
     */
    public function pdf(Request $request, FileUploader $uploader, Pdf $pdf, Image $imager) {
        if ($request->isXmlHttpRequest()) {
            $type = $request->get('type');
            if ($type === 'transfer') {
                $entity = Transfer::class;
            }else {
                $entity = Removal::class;
            }
            $entity = $this->getDoctrine()->getRepository($entity)->find($request->get('id'));
            if (!$entity) {
                return new Response('Error');
            }
            $html = $this->renderView('actors/staff/'. $type .'/print.approval.html.twig', array(
                $type  => $entity
            ));
            /*return new JpegResponse(
                $imager->getOutputFromHtml($html),
                'image.jpg'
            );*/


            $time = time();
            $pdf->generateFromHtml($html, $this->getParameter('app.bol_dir') . 'temp/' . $time . '.pdf');
            /*$response = new PdfResponse(
                $pdf->getOutputFromHtml($html),
                'file.pdf'
            );*/
            $this->get('app.log')->add(ucfirst($type) . '.PDF', 'show', $entity->getId(), ['id']);

            $view = $this->renderView('transfer/pdf_show.html.twig', [
                'link' => $this->getParameter('app.base_url') . 'uploads/temp/' . $time . '.pdf'
            ]);
            return new JsonResponse([
                'view' => $view,
                'error' => false
            ]);
        }
        return new Response('access denied');
    }


    /**
     * @Route("/{id}/edit", name="transfer_edit", methods={"GET","POST"})
     * @param Request      $request
     * @param Transfer     $transfer
     * @param FileUploader $uploader
     *
     * @return Response
     */
    public function edit(Request $request, Transfer $transfer, FileUploader $uploader): Response
    {
        $this->denyAccessUnlessGranted('ROLE_MANAGER');

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
            $transfer->setCreatedAt(new \DateTime());
            $transfer->setVehicle($vehicle);
            $em->persist($transfer);
            $em->flush();

            $this->get('app.log')->add(Transfer::class, 'edit', $transfer->getId(), ['id']);

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
     * @param Request  $request
     * @param Transfer $transfer
     *
     * @return Response
     */
    public function delete(Request $request, Transfer $transfer): Response
    {
        $this->denyAccessUnlessGranted('ROLE_MANAGER');

        if ($this->isCsrfTokenValid('delete'.$transfer->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($transfer);
            $entityManager->flush();

            $this->get('app.log')->add(Transfer::class, 'delete', $transfer->getId(), ['id']);
        }

        return $this->redirectToRoute('transfer_index');
    }
}
