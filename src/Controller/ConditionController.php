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
     * @param ConditionRepository $conditionRepository
     *
     * @return Response
     */
    public function index(ConditionRepository $conditionRepository): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $this->get('app.log')->add(Condition::class, 'index');

        return $this->render('condition/index.html.twig', [
            'conditions' => $conditionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="condition_new", methods={"GET","POST"})
     * @param Request $request
     *
     * @return Response
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

            $this->get('app.log')->add(Condition::class, 'new', $condition->getId());

            return $this->redirectToRoute('condition_index');
        }

        return $this->render('condition/new.html.twig', [
            'condition' => $condition,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/show", name="condition_show", options={"expose" = true}, methods={"GET"})
     * @param Request $request
     *
     * @return Response
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
     * @param Condition $condition
     *
     * @return Response
     */
    public function showDefault(Condition $condition): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $this->get('app.log')->add(Condition::class, 'show', $condition->getId(), ['id']);

        return $this->render('condition/show.html.twig', [
            'condition' => $condition,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="condition_edit", methods={"GET","POST"})
     * @param Request   $request
     * @param Condition $condition
     *
     * @return Response
     */
    public function edit(Request $request, Condition $condition): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $form = $this->createForm(ConditionType::class, $condition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->get('app.log')->add(Condition::class, 'edit', $condition->getId(), ['id']);

            return $this->redirectToRoute('condition_index');
        }

        return $this->render('condition/edit.html.twig', [
            'condition' => $condition,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="condition_delete", methods={"DELETE"})
     * @param Request   $request
     * @param Condition $condition
     *
     * @return Response
     */
    public function delete(Request $request, Condition $condition): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        if ($this->isCsrfTokenValid('delete'.$condition->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();

            $this->get('app.log')->add(Condition::class, 'delete', $condition->getId(), ['id']);

            $entityManager->remove($condition);
            $entityManager->flush();
        }

        return $this->redirectToRoute('condition_index');
    }
}
