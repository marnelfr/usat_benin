<?php

namespace App\Controller;

use App\Entity\Remover;
use App\Form\RemoverType;
use App\Repository\RemoverRepository;
use App\Service\FileUploader;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
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
     * @param RemoverRepository $removerRepository
     *
     * @return Response
     */
    public function index(RemoverRepository $removerRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_AGENT');
        $this->get('app.log')->add(Remover::class, 'index');

        return $this->render('remover/index.html.twig', [
            'removers' => $removerRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="remover_new", options={"expose"=true}, methods={"GET","POST"})
     * @param Request      $request
     * @param FileUploader $uploader
     *
     * @return Response
     */
    public function new(Request $request, FileUploader $uploader): Response
    {
        $this->denyAccessUnlessGranted('ROLE_AGENT');

        $remover = new Remover();
        $form = $this->createForm(RemoverType::class, $remover);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $cin */
            $cin = $form->get('cinName')->getData();

            $remover->setAgent($this->getUser());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($remover);

            if ($cin && $uploader->upload($cin, 'cin', $remover, 'remover')) {

                $message = 'Enleveur enregistré avec succès';

                $this->get('app.log')->add(Remover::class, 'new', $remover->getId());

                if ($request->isXmlHttpRequest()) {
                    return new JsonResponse([
                        'typeMessage' => 'success',
                        'message' => $message,
                        'id' => $remover->getId(),
                        'name' => $remover->getFullname()
                    ]);
                }
                $this->addFlash('success', $message);

                return $this->redirectToRoute('remover_index');
            }
            $form->get('cinName')->addError(new FormError('Veuillez téléverser la Carte Nationale d\'Identité de l\'enleveur'));
        }
        $data = [
            'remover' => $remover,
            'form'    => $form->createView(),
        ];

        if ($request->isXmlHttpRequest()) {
            $view = $this->renderView('remover/modal_add.html.twig', $data);
            return new JsonResponse([
                'typeMessage' => 'view',
                'view' => $view
            ]);
        }

        return $this->render('remover/new.html.twig', $data);
    }

    /**
     * @Route("/{id}", name="remover_show", methods={"GET"})
     * @param Remover $remover
     *
     * @return Response
     */
    public function show(Remover $remover): Response
    {
        $this->denyAccessUnlessGranted('ROLE_AGENT');

        $this->get('app.log')->add(Remover::class, 'show', $remover->getId(), ['id']);

        return $this->render('remover/show.html.twig', [
            'remover' => $remover,
        ]);
    }

    /**
     * @Route("/{id}/img", options = { "expose" = true }, name="remover_img", methods={"GET"})
     * @param Request      $request
     * @param Remover      $remover
     * @param FileUploader $uploader
     *
     * @return JsonResponse|Response
     */
    public function img(Request $request, Remover $remover, FileUploader $uploader) {
        if ($request->isXmlHttpRequest()) {
            $fileLink = $uploader->fileLink($remover, 'remover', 'cin');
            $view = $this->renderView('vehicle/show_img.html.twig', [
                'url' => $fileLink,
                'alt' => 'Carte nationale d\'identité'
            ]);

            $this->get('app.log')->add('Remover.Image', 'show', $remover->getId(), ['id']);

            return new JsonResponse([
                'view' => $view,
                'error' => $fileLink === false
            ]);
        }
        return new Response('access denied');
    }

    /**
     * @Route("/{id}/edit", name="remover_edit", methods={"GET","POST"})
     * @param Request      $request
     * @param Remover      $remover
     * @param FileUploader $uploader
     *
     * @return Response
     */
    public function edit(Request $request, Remover $remover, FileUploader $uploader): Response
    {
        $this->denyAccessUnlessGranted('ROLE_AGENT');

        $form = $this->createForm(RemoverType::class, $remover);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $cin */
            $cin = $form->get('cinName')->getData();

            if ($cin) {
                try{
                    $uploader->upload($cin, 'cin', $remover, 'remover', true);
                }catch (\Exception $e) {
                    dump($e->getMessage()); die();
                }
            }
            $this->getDoctrine()->getManager()->flush();

            $this->get('app.log')->add(Remover::class, 'edit', $remover->getId(), ['id']);

            return $this->redirectToRoute('remover_index');
        }

        return $this->render('remover/edit.html.twig', [
            'remover' => $remover,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="remover_delete", methods={"DELETE"})
     * @param Request $request
     * @param Remover $remover
     *
     * @return Response
     */
    public function delete(Request $request, Remover $remover): Response
    {
        $this->denyAccessUnlessGranted('ROLE_AGENT');

        if ($this->isCsrfTokenValid('delete'.$remover->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($remover);
            $entityManager->flush();

            $this->get('app.log')->add(Remover::class, 'delete', $remover->getId(), ['id']);
        }

        return $this->redirectToRoute('remover_index');
    }
}
