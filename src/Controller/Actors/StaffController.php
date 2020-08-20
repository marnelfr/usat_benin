<?php

namespace App\Controller\Actors;

use App\Entity\Processing;
use App\Entity\Removal;
use App\Entity\Remover;
use App\Entity\Transfer;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
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
class StaffController extends AbstractController
{
    /**
     * Le tableau de bord du personnel de USAT de la plateforme
     *
     * @Route("/actors/staff", name="actors_staff_dashboard")
     */
    public function index(EntityManagerInterface $em)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $waitingTransfer = count($em->getRepository(Transfer::class)->findBy(['deleted' => 0, 'status' => 'waiting']));
        $waitingRemoval = count($em->getRepository(Removal::class)->findBy(['deleted' => 0, 'status' => 'waiting']));
        $finalizedTransfer = count($em->getRepository(Transfer::class)->findBy(['deleted' => 0, 'status' => 'finalized']));
        $finalizedRemoval = count($em->getRepository(Removal::class)->findBy(['deleted' => 0, 'status' => 'finalized']));

        $data = compact('waitingRemoval', 'waitingTransfer', 'finalizedRemoval', 'finalizedTransfer');
        return $this->render('actors/staff/index.html.twig', $data);
    }



    /**
     * La liste des demande de transfert afficher au staff
     *
     * @Route("/staff/transfer/waiting", name="staff_transfer_index", methods={"GET"})
     */
    public function transfer_waiting(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        return $this->render('actors/staff/transfer/index.html.twig', [
            'title' => 'En attente',
            'noData' => 'Aucune demande en attente',
            'transfers' => $this->getDoctrine()->getRepository(Transfer::class)->findBy(['status' => 'waiting']),
        ]);
    }

    /**
     * @Route("/staff/transfer/{id}/treatment", name="staff_transfer_treatment")
     * @param Request  $request
     * @param Transfer $transfer
     *
     * @return Response
     */
    public function transfer_treatment(Request $request, Transfer $transfer): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        if ($request->isXmlHttpRequest() && $transfer->getStatus() === 'inprogress') {
            return new JsonResponse([
                'typeMessage' => 'warning',
                'message' => 'Déjà en cours de traitement en cours par ' . $transfer->getProcessing()->getUser()->getFullname()
            ]);
        }

        $transfer->setStatus('inprogress');
        $em = $this->getDoctrine()->getManager();
        $em->getRepository(Processing::class)->add($transfer, 'transfer');
        $em->flush();

        return $this->render('actors/staff/transfer/show.html.twig', [
            'transfer' => $transfer,
        ]);
    }

    /**
     * @Route("/staff/transfer/{id}/reject", options = { "expose" = true }, name="staff_reject_transfer")
     * @param Request  $request
     * @param Transfer $transfer
     */
    public function reject_transfer(Request $request, Transfer $transfer) {
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
}
