<?php

namespace App\Controller;

use App\Entity\Inform;
use App\Form\InformType;
use App\Repository\InformRepository;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
            'informs' => $informRepository->all(),
        ]);
    }

    /**
     * @Route("/new", name="inform_new", methods={"GET","POST"})
     */
    public function new(Request $request, FileUploader $uploader): Response
    {
        $this->denyAccessUnlessGranted('ROLE_STAFF_ADMIN');

        $inform = new Inform();
        $form = $this->createForm(InformType::class, $inform);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $image */
            $image = $form->get('image')->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $inform->setUser($this->getUser());
            $entityManager->persist($inform);
            if ($image) {
                $uploader->upload($image, 'inform', $inform, 'inform');
            }
            $entityManager->flush();
            $this->addFlash('success', 'Communiqué publié avec succès');
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
    public function show(Request $request, Inform $inform): Response
    {
        if ($request->isXmlHttpRequest()) {
            $data['typeMessage'] = 'success';
            $data['view'] = $this->renderView('inform/show.html.twig', [
                'inform' => $inform,
            ]);
            return new JsonResponse($data);
        }
        return new Response('Accès interdit');
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
