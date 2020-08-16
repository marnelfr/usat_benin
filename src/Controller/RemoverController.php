<?php

namespace App\Controller;

use App\Entity\Remover;
use App\Form\RemoverType;
use App\Repository\RemoverRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/remover")
 */
class RemoverController extends AbstractController
{
    /**
     * @Route("/", name="remover_index", methods={"GET"})
     */
    public function index(RemoverRepository $removerRepository): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        return $this->render('remover/index.html.twig', [
            'removers' => $removerRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="remover_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $remover = new Remover();
        $form = $this->createForm(RemoverType::class, $remover);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($remover);
            $entityManager->flush();

            return $this->redirectToRoute('remover_index');
        }

        return $this->render('remover/new.html.twig', [
            'remover' => $remover,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="remover_show", methods={"GET"})
     */
    public function show(Remover $remover): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        return $this->render('remover/show.html.twig', [
            'remover' => $remover,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="remover_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Remover $remover): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $form = $this->createForm(RemoverType::class, $remover);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('remover_index');
        }

        return $this->render('remover/edit.html.twig', [
            'remover' => $remover,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="remover_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Remover $remover): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        if ($this->isCsrfTokenValid('delete'.$remover->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($remover);
            $entityManager->flush();
        }

        return $this->redirectToRoute('remover_index');
    }
}
