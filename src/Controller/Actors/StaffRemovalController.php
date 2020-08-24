<?php

namespace App\Controller\Actors;

use App\Entity\Processing;
use App\Entity\Removal;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Knp\Snappy\Pdf;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class StaffController
 * Le controlleur des actions spécifiques du personnel de USAT.
 * Ne doit pas remplacer le CRUD des entités
 * @package App\Controller\Actors
 * @IsGranted("ROLE_STAFF")
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
    public function removal_treatment(Request $request, Removal $removal): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

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
                    'message' => 'Veuillez finaliser le traitement en cours et réessayer'
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

        return $this->render('actors/staff/removal/show.html.twig', [
            'removal' => $removal,
        ]);
    }

    /**
     * La liste des demande de enlevement en cours afficher au staff
     *
     * @Route("/staff/removal/inprogress", options={"expose"=true}, name="staff_removal_inprogress", methods={"GET"})
     */
    public function removal_inpgrosse(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        return $this->render('actors/staff/removal/index.html.twig', [
            'title' => 'En cours',
            'btnLabel' => 'Finaliser',
            'btnPath' => 'staff_removal_treatment',
            'noData' => 'Aucune demande en cours',
            'removals' => $this->getDoctrine()->getRepository(Removal::class)->getInProgressRemoval(),
        ]);
    }

    /**
     * @Route("/staff/removal/{id}/reject", options = { "expose" = true }, name="staff_reject_removal")
     * @param Request  $request
     * @param Removal $removal
     */
    public function reject_removal(Request $request, Removal $removal) {
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
            $processing = $removal->getProcessing();
            $processing->setReason($form->get('reason')->getData());
            $processing->setVerdict(0);

            $removal->setStatus('rejected');

            // TODO: Envoie un email au demandeur

            $this->getDoctrine()->getManager()->flush();
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
}
