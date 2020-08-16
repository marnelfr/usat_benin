<?php

namespace App\Controller;

use App\Entity\Removal;
use App\Form\RemovalType;
use App\Repository\RemovalRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/removal")
 */
class RemovalController extends AbstractController
{
    /**
     * @Route("/", name="removal_index", methods={"GET"})
     */
    public function index(RemovalRepository $removalRepository): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        return $this->render('removal/index.html.twig', [
            'removals' => $removalRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="removal_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $removal = new Removal();
        $form = $this->createForm(RemovalType::class, $removal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($removal);
            $entityManager->flush();

            return $this->redirectToRoute('removal_index');
        }

        return $this->render('removal/new.html.twig', [
            'removal' => $removal,
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
