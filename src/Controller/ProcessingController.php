<?php

namespace App\Controller;

use App\Entity\Processing;
use App\Form\ProcessingType;
use App\Repository\ProcessingRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/processing")
 */
class ProcessingController extends AbstractController
{
    /**
     * @Route("/", name="processing_index", methods={"GET"})
     * @param ProcessingRepository $processingRepository
     *
     * @return Response
     */
    public function index(ProcessingRepository $processingRepository): Response
    {
        $this->get('app.log')->add(Processing::class, 'index');

        return $this->render('processing/index.html.twig', [
            'processings' => $processingRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="processing_new", methods={"GET","POST"})
     * @param Request $request
     *
     * @return Response
     */
    public function new(Request $request): Response
    {
        $processing = new Processing();
        $form = $this->createForm(ProcessingType::class, $processing);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($processing);
            $entityManager->flush();

            $this->get('app.log')->add(Processing::class, 'new', $processing->getId());

            return $this->redirectToRoute('processing_index');
        }

        return $this->render('processing/new.html.twig', [
            'processing' => $processing,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="processing_show", methods={"GET"})
     * @param Processing $processing
     *
     * @return Response
     */
    public function show(Processing $processing): Response
    {
        $this->get('app.log')->add(Processing::class, 'show', $processing->getId(), ['id']);

        return $this->render('processing/show.html.twig', [
            'processing' => $processing,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="processing_edit", methods={"GET","POST"})
     * @param Request    $request
     * @param Processing $processing
     *
     * @return Response
     */
    public function edit(Request $request, Processing $processing): Response
    {
        $form = $this->createForm(ProcessingType::class, $processing);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->get('app.log')->add(Processing::class, 'edit', $processing->getId(), ['id']);

            return $this->redirectToRoute('processing_index');
        }

        return $this->render('processing/edit.html.twig', [
            'processing' => $processing,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="processing_delete", methods={"DELETE"})
     * @param Request    $request
     * @param Processing $processing
     *
     * @return Response
     */
    public function delete(Request $request, Processing $processing): Response
    {
        if ($this->isCsrfTokenValid('delete'.$processing->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($processing);
            $entityManager->flush();

            $this->get('app.log')->add(Processing::class, 'delete', $processing->getId(), ['id']);
        }

        return $this->redirectToRoute('processing_index');
    }
}
