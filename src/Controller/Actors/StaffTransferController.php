<?php

namespace App\Controller\Actors;

use App\Entity\DemandeFile;
use App\Entity\Processing;
use App\Entity\Removal;
use App\Entity\Transfer;
use App\Entity\User;
use App\Service\FileUploader;
use AsyncAws\Core\Configuration;
use AsyncAws\S3\S3Client;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Knp\Snappy\Pdf;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\File;

/**
 * Class StaffController
 * Le controlleur des actions spécifiques du personnel de USAT.
 * Ne doit pas remplacer le CRUD des entités
 * @package App\Controller\Actors
 * @IsGranted("ROLE_STAFF")
 */
class StaffTransferController extends AbstractController
{

    /**
     * @Route("/staff/transfer/{id}/treatment", name="staff_transfer_treatment")
     * @param Request  $request
     * @param Transfer $transfer
     *
     * @return Response
     */
    public function treatment(Request $request, Transfer $transfer): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        /*return $this->render('actors/staff/transfer/print.approval.html.twig', [
            'transfer' => $transfer
        ]);*/

        //On definit les differents message affichable à l'utilisateur
        $message = 'La demande à déjà été traitée par ';
        if ($transfer->getStatus() === 'inprogress') {
            $message = 'La demande est déjà en cours de traitement par ';
        }

        $em = $this->getDoctrine()->getManager();

        $currentFullname = $this->getUser()->getFullname();
        //Le nom de celui qui est entrain de traiter la demande
        $fullname = $transfer->getStatus() !== 'waiting' ? $transfer->getProcessing()->getUser()->getFullname() : '';

        $message .= $fullname;

        $ressouceNotAccessible = $transfer->getStatus() !== 'waiting' && $fullname !== $currentFullname;

        if ($request->isXmlHttpRequest()) {
            //Un utilisateur ne peut commencer le traitement d'une demande s'il traite déjà une autre
            if ($transfer->getStatus() === 'waiting' && $em->getRepository(User::class)->isMakingTreatement()) {
                return new JsonResponse([
                    'typeMessage' => 'warning',
                    'message' => 'Veuillez finaliser le traitement (transfert ou enlèvement) en cours et réessayer'
                ]);
            }
            //un utilisateur ne peut accéder à une demande en cours de traitement par un autre utilisateur
            if ($ressouceNotAccessible) {
                return new JsonResponse([
                    'typeMessage' => 'warning',
                    'message' => $message
                ]);
            } else {
                return new JsonResponse([
                    'typeMessage' => 'success'
                ]);
            }
        }
        //un utilisateur ne peut accéder à une demande en cours de traitement par un autre utilisateur
        if ($ressouceNotAccessible) {
            $this->addFlash('warning', $message);
            return $this->redirectToRoute('staff_transfer_index');
        }
        //Un utilisateur ne peut commencer le traitement d'une demande s'il traite déjà une autre
        if ($transfer->getStatus() === 'waiting' && $em->getRepository(User::class)->isMakingTreatement()) {
            $this->addFlash('warning', 'Veuillez finaliser le traitement en cours et réessayer');
            return $this->redirectToRoute('staff_transfer_index');
        }

        $transfer->setStatus('inprogress');
        $em->getRepository(Processing::class)->add($transfer, 'transfer');
        $em->flush();

        return $this->render('actors/staff/transfer/show.html.twig', [
            'transfer' => $transfer,
        ]);
    }

    /**
     * La liste des demande de transfert en cours afficher au staff
     *
     * @Route("/staff/transfer/inprogress", options={"expose"=true}, name="staff_transfer_inprogress", methods={"GET"})
     */
    public function inprogress(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        return $this->render('actors/staff/transfer/index.html.twig', [
            'title' => 'En cours',
            'btnLabel' => 'Finaliser',
            'btnPath' => 'staff_transfer_treatment',
            'noData' => 'Aucune demande en cours',
            'transfers' => $this->getDoctrine()->getRepository(Transfer::class)->getInProgressTransfer(),
        ]);
    }

    /**
     * @param Request $request
     * @Route("/staff/transfer/{id}/finalize", options={"expose" = true}, name="staff_finalize_transfer")
     */
    public function finalizer(Request $request, Transfer $transfer, FileUploader $uploader) {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $form = $this->createFormBuilder()
            ->add('assurance', FileType::class, [
                'label' => 'Reçu d\'assurance',

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => true,

                'help' => 'Veuillez choisir un fichier image <b>jpg/jpeg</b> ou <b>png</b> d\'au plus 2048ko (2Mo)',
                'help_html' => true,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '2048k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Veuillez choisir un fichier image jpg ou png',
                    ])
                ],
            ])->getForm()
        ;
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $assurance */
            $assurance = $form->get('assurance')->getData();

            $entityManager = $this->getDoctrine()->getManager();

            if ($assurance && $uploader->upload($assurance, 'assurance', $transfer, 'transfer')) {

                $transfer->setStatus('finalized');

                $entityManager->flush();
                return new JsonResponse([
                    'typeMessage' => 'success'
                ]);
            }
        }

        if ($request->isXmlHttpRequest()) {
            return new JsonResponse([
                'typeMessage' => 'form',
                'view' => $this->renderView('actors/staff/transfer/form_finalizer.html.twig', [
                    'form' => $form->createView(),
                    'id' => $transfer->getId()
                ])
            ]);
        }
    }

    /**
     * La liste des demande de transfert en cours afficher au staff
     *
     * @Route("/staff/transfer/finalized", name="staff_transfer_finalized", methods={"GET"})
     */
    public function finalized(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        return $this->render('actors/staff/transfer/index.html.twig', [
            'title' => 'Finalisées',
            'btnLabel' => 'Voir',
            'btnPath' => 'staff_transfer_treatment',
            'noData' => 'Aucune demande finalisée pour le moment',
            'transfers' => $this->getDoctrine()->getRepository(Transfer::class)->getFinalizedTransfer(),
        ]);
    }

    /**
     * @return Response
     * @Route("/staff/transfer/{id}/show", name="staff_transfer_show")
     */
    public function show(Transfer $transfer): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        return $this->render('transfer/show.html.twig', [
            'transfer' => $transfer,
        ]);
    }

    /**
     * @Route("/staff/transfer/{id}/reject", options = { "expose" = true }, name="staff_reject_transfer")
     * @param Request  $request
     * @param Transfer $transfer
     */
    public function reject(Request $request, Transfer $transfer) {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $form = $this->createFormBuilder()
            ->add('reason', TextareaType::class, [
                'required' => true,
                'attr' => [
                    'row' => 5
                ]
            ])
            ->getForm()
        ;

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $processing = $transfer->getProcessing();
            $processing->setReason($form->get('reason')->getData());
            $processing->setVerdict(0);

            $transfer->setStatus('rejected');

            // TODO: Envoie un email au demandeur

            $this->addFlash('success', 'Demande rejetée avec succès');

            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('staff_transfer_index');
        }


        if ($request->isXmlHttpRequest() && $transfer->getStatus() === 'inprogress') {
            $view = $this->renderView('actors/staff/transfer/form_reject.html.twig', [
                'form' => $form->createView(),
                'id' => $transfer->getId()
            ]);
            return new JsonResponse([
                'typeMessage' => 'success',
                'view' => $view
            ]);
        }

        return new Response('Page introuvable');
    }


    /**
     * @Route("/staff/transfer/{id}/approval", name="staff_approval_transfer")
     * @param Request $request
     */
    public function approval(Transfer $transfer, Request $request, Pdf $pdf) {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $transfer->getProcessing()->setVerdict(1);
        $this->getDoctrine()->getManager()->flush();

        $html = $this->renderView('actors/staff/transfer/print.approval.html.twig', array(
            'transfer'  => $transfer,
            'ref' => 'TR' . str_pad($transfer->getId(), 10, "0", STR_PAD_LEFT)
        ));
        $cookie = Cookie::create('downloaded')
            ->withValue(true)
            ->withExpires(new \DateTime('+10 seconds'))
            ->withSecure(false)
            ->withHttpOnly(false)
        ;
        $response = new PdfResponse(
            $pdf->getOutputFromHtml($html),
            'file.pdf'
        );
        $response->headers->setCookie($cookie);
        return $response;
    }
}
