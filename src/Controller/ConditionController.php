<?php

namespace App\Controller;

use App\Entity\Condition;
use App\Form\ConditionType;
use App\Repository\ConditionRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/condition")
 */
class ConditionController extends AbstractController
{
    /**
     * @Route("/", name="condition_index", methods={"GET"})
     */
    public function index(ConditionRepository $conditionRepository): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('condition/index.html.twig', [
            'conditions' => $conditionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="condition_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $condition = new Condition();
        $form = $this->createForm(ConditionType::class, $condition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($condition);
            $entityManager->flush();

            return $this->redirectToRoute('condition_index');
        }

        return $this->render('condition/new.html.twig', [
            'condition' => $condition,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/show", name="condition_show", options={"expose" = true}, methods={"GET"})
     */
    public function show(Request $request): Response
    {
        if ($request->isXmlHttpRequest()) {
            $condition = $this->getDoctrine()->getRepository(Condition::class)->last();
            $view = $this->renderView('condition/show.html.twig', [
                'condition' => $condition,
            ]);
            return new JsonResponse([
                'typeMessage' => 'success',
                'view' => $view
            ]);
        }
        die('Ressource introuvable..');
    }

    /**
     * @Route("/{id}", name="condition_show_default", methods={"GET"})
     */
    public function showDefault(Condition $condition): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('condition/show.html.twig', [
            'condition' => $condition,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="condition_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Condition $condition): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $form = $this->createForm(ConditionType::class, $condition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('condition_index');
        }

        return $this->render('condition/edit.html.twig', [
            'condition' => $condition,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="condition_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Condition $condition): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        if ($this->isCsrfTokenValid('delete'.$condition->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($condition);
            $entityManager->flush();
        }

        return $this->redirectToRoute('condition_index');
    }
}
