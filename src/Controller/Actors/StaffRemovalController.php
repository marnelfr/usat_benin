<?php

namespace App\Controller\Actors;

use App\Entity\Notification;
use App\Entity\Processing;
use App\Entity\Removal;
use App\Entity\User;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Knp\Snappy\Pdf;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class StaffController
 * Le controlleur des actions spécifiques du personnel de USATum.
 * Ne doit pas remplacer le CRUD des entités
 * @package App\Controller\Actors
 */
class StaffRemovalController extends AbstractController
{

    /**
     * @Route("/staff/removal/{id}/treatment", name="staff_removal_treatment")
     * @param Request  $request
     * @param Removal $removal
     *
     * @return Response
     */
    public function treatment(Request $request, Removal $removal): Response
    {
        $this->denyAccessUnlessGranted('ROLE_STAFF');

        //On definit les differents message affichable à l'utilisateur
        $message = 'La demande à déjà été traitée par ';
        if ($removal->getStatus() === 'inprogress') {
            $message = 'La demande est déjà en cours de traitement par ';
        }

        $em = $this->getDoctrine()->getManager();

        $currentFullname = $this->getUser()->getFullname();
        //Le nom de celui qui est entrain de traiter la demande
        $fullname = $removal->getStatus() !== 'waiting' ? $removal->getProcessing()->getUser()->getFullname() : '';

        $message .= $fullname;

        $ressouceNotAccessible = $removal->getStatus() !== 'waiting' && $fullname !== $currentFullname;

        if ($request->isXmlHttpRequest()) {
            //Un utilisateur ne peut commencer le traitement d'une demande s'il traite déjà une autre
            if ($removal->getStatus() === 'waiting' && $em->getRepository(User::class)->isMakingTreatement()) {
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
            return $this->redirectToRoute('staff_removal_index');
        }
        //Un utilisateur ne peut commencer le traitement d'une demande s'il traite déjà une autre
        if ($removal->getStatus() === 'waiting' && $em->getRepository(User::class)->isMakingTreatement()) {
            $this->addFlash('warning', 'Veuillez finaliser le traitement en cours et réessayer');
            return $this->redirectToRoute('staff_removal_index');
        }

        $removal->setStatus('inprogress');
        $em->getRepository(Processing::class)->add($removal, 'removal');
        $em->flush();

        $this->get('app.log')->add(Removal::class, 'treat', $removal->getId(), ['id']);

        return $this->render('actors/staff/removal/show.html.twig', [
            'removal' => $removal,
        ]);
    }

    /**
     * @Route("/staff/removal/{id}/show", name="staff_removal_show", methods={"GET"})
     * @param Removal $removal
     *
     * @return Response
     */
    public function show(Removal $removal) {
        $this->get('app.log')->add(Removal::class, 'show', $removal->getId(), ['id']);

        return $this->render('actors/staff/removal/show.html.twig', [
            'finalized' => true,
            'removal' => $removal
        ]);
    }


    /**
     * La liste des demande de enlevement finalisés afficher au staff
     *
     * @Route("/staff/removal/finalized", options={"expose"=true}, name="staff_removal_finalized", methods={"GET"})
     */
    public function finalized(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_CONTROL');

        $this->get('app.log')->add('Staff.Removal.Finalized', 'index');

        return $this->render('actors/staff/removal/index.html.twig', [
            'title' => 'Finalisées',
            'btnLabel' => 'Finaliser',
            'btnPath' => 'staff_removal_treatment',
            'noData' => 'Aucune demande en cours',
            'removals' => $this->getDoctrine()->getRepository(Removal::class)->getFinalizedRemoval(),
        ]);
    }

    /**
     * @Route("/staff/removal/{id}/reject", options = { "expose" = true }, name="staff_reject_removal")
     * @param Request  $request
     * @param Removal $removal
     */
    public function reject(Request $request, Removal $removal) {
        $this->denyAccessUnlessGranted('ROLE_STAFF');

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
            $processing = $removal->getProcessing();
            $processing->setReason($form->get('reason')->getData());
            $processing->setVerdict(0);
            $entityManager = $this->getDoctrine()->getManager();
            $removal->setStatus('rejected');
            $entityManager->getRepository(Notification::class)->removalNotif($removal);

            // TODO: Envoie un email au demandeur

            $entityManager->flush();

            $this->get('app.log')->add(Removal::class, 'reject', $removal->getId(), ['id']);

            $this->addFlash('success', 'Demande rejetée avec succès');
            return $this->redirectToRoute('staff_removal_index');
        }


        if ($request->isXmlHttpRequest() && $removal->getStatus() === 'inprogress') {
            $view = $this->renderView('actors/staff/removal/form_reject.html.twig', [
                'form' => $form->createView(),
                'id' => $removal->getId()
            ]);
            return new JsonResponse([
                'typeMessage' => 'success',
                'view' => $view
            ]);
        }

        return new Response('Page introuvable');
    }


    /**
     * @Route("/staff/removal/{id}/approval", name="staff_approval_removal")
     * @param Removal $removal
     * @param Request $request
     * @param Pdf     $pdf
     *
     * @return PdfResponse
     */
    public function approval(Removal $removal, Request $request, Pdf $pdf) {
        $this->denyAccessUnlessGranted('ROLE_STAFF');

        $removal->setStatus('finalized');
        $removal->getProcessing()->setVerdict(1);
        $this->get('app.log')->add(Removal::class, 'approve', $removal->getId(), ['id']);

        $entityManager = $this->getDoctrine()->getManager();

        $entityManager->getRepository(Notification::class)->removalNotif($removal);

        $entityManager->flush();

        $this->addFlash('success', 'Demande approuvée avec succès');

        $html = $this->renderView('actors/staff/removal/print.approval.html.twig', array(
            'removal' => $removal
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
