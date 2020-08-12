<?php

namespace App\Controller;

use App\Entity\Transfer;
use App\Form\TransferType;
use App\Repository\TransferRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
     * @Route("/inprogress", name="transfer_index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('transfer/index.html.twig', [
            'transfers' => $this->repo->findBy(['status' => 'inprogress'], ['id' => 'DESC']),
        ]);
    }
    
    /**
     * La liste des demande de transfert approuver, finaliser
     *
     * @Route("/finalized", name="transfer_index_finalized", methods={"GET"})
     */
    public function index_finalized(): Response
    {
        return $this->render('transfer/index.html.twig', [
            'transfers' => $this->repo->findBy(['status' => 'finalized'], ['id' => 'DESC']),
        ]);
    }
    
    /**
     * La liste des demande de transfert rejeter
     *
     * @Route("/rejected", name="transfer_index_rejected", methods={"GET"})
     */
    public function index_rejected(): Response
    {
        return $this->render('transfer/index.html.twig', [
            'transfers' => $this->repo->findBy(['status' => 'rejected'], ['id' => 'DESC']),
        ]);
    }

    /**
     * @Route("/new", name="transfer_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $transfer = new Transfer();
        $form = $this->createForm(TransferType::class, $transfer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($transfer);
            $entityManager->flush();

            return $this->redirectToRoute('transfer_index');
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
        return $this->render('transfer/show.html.twig', [
            'transfer' => $transfer,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="transfer_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Transfer $transfer): Response
    {
        $form = $this->createForm(TransferType::class, $transfer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

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
        if ($this->isCsrfTokenValid('delete'.$transfer->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($transfer);
            $entityManager->flush();
        }

        return $this->redirectToRoute('transfer_index');
    }
}
