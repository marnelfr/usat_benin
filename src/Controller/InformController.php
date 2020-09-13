<?php

namespace App\Controller;

use App\Entity\Inform;
use App\Form\InformType;
use App\Repository\InformRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/inform")
 */
class InformController extends AbstractController
{
    /**
     * @Route("/", name="inform_index", methods={"GET"})
     */
    public function index(InformRepository $informRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_STAFF_ADMIN');

        return $this->render('inform/index.html.twig', [
            'informs' => $informRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="inform_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_STAFF_ADMIN');

        $inform = new Inform();
        $form = $this->createForm(InformType::class, $inform);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($inform);
            $entityManager->flush();

            return $this->redirectToRoute('inform_index');
        }

        return $this->render('inform/new.html.twig', [
            'inform' => $inform,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="inform_show", methods={"GET"})
     */
    public function show(Inform $inform): Response
    {
        $this->denyAccessUnlessGranted('ROLE_STAFF_ADMIN');

        return $this->render('inform/show.html.twig', [
            'inform' => $inform,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="inform_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Inform $inform): Response
    {
        $this->denyAccessUnlessGranted('ROLE_STAFF_ADMIN');

        $form = $this->createForm(InformType::class, $inform);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('inform_index');
        }

        return $this->render('inform/edit.html.twig', [
            'inform' => $inform,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="inform_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Inform $inform): Response
    {
        $this->denyAccessUnlessGranted('ROLE_STAFF_ADMIN');

        if ($this->isCsrfTokenValid('delete'.$inform->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($inform);
            $entityManager->flush();
        }

        return $this->redirectToRoute('inform_index');
    }
}
