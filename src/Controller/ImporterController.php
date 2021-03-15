<?php

namespace App\Controller;

use App\Entity\Importer;
use App\Form\ImporterType;
use App\Repository\ImporterRepository;
use App\Repository\ProfilRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * @Route("/importer")
 */
class ImporterController extends AbstractController
{
    /**
     * @Route("/", name="importer_index", methods={"GET"})
     * @param ImporterRepository $importerRepository
     *
     * @return Response
     */
    public function index(ImporterRepository $importerRepository): Response
    {
        $this->denyAccessUnlessGranted(['ROLE_MANAGER', 'ROLE_AGENT']);

        $this->get('app.log')->add(Importer::class, 'index');

        return $this->render('importer/index.html.twig', [
            'importers' => $importerRepository->findBy(['deleted' => 0, 'user' => $this->getUser()], ['id' => 'DESC']),
        ]);
    }

    /**
     * @Route("/new", name="importer_new", options={"expose"=true}, methods={"GET","POST"})
     * @param Request            $request
     * @param SluggerInterface   $slugger
     * @param ProfilRepository   $profilRepo
     * @param ImporterRepository $importerRepo
     *
     * @return Response
     */
    public function new(Request $request, SluggerInterface $slugger, ProfilRepository $profilRepo, ImporterRepository $importerRepo): Response
    {
        $this->denyAccessUnlessGranted(['ROLE_MANAGER', 'ROLE_AGENT']);

        $importer = new Importer();
        $form = $this->createForm(ImporterType::class, $importer);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $importer->setUser($this->getUser());

            $entityManager = $this->getDoctrine()->getManager();
            $old = $importerRepo->findOneBy(['name' => $importer->getName()]);
            if (!$old) {
                $entityManager->persist($importer);
                $entityManager->flush();
            } else {
                if (!$old->getEmail()) {
                    $old->setEmail($importer->getEmail());
                }
                if (!$old->getAddress()) {
                    $old->setAddress($importer->getAddress());
                }
                if (!$old->getPhone()) {
                    $old->setPhone($importer->getPhone());
                }
                $importer = $old;
            }

            $entityManager->flush();

            $this->get('app.log')->add(Importer::class, 'new', $importer->getId());

            $message = 'Importeur enregistré avec succès';

            if ($request->isXmlHttpRequest()) {
                return new JsonResponse([
                    'typeMessage' => 'success',
                    'message' => $message,
                    'id' => $importer->getId(),
                    'name' => $importer->getName()
                ]);
            }
            $this->addFlash('success', $message);
            return $this->redirectToRoute('importer_index');
        }

        $data = [
            'importer' => $importer,
            'form' => $form->createView(),
        ];

        if ($request->isXmlHttpRequest()) {
            $view = $this->renderView('importer/modal_add.html.twig', $data);
            return new JsonResponse([
                'typeMessage' => 'view',
                'view' => $view
            ]);
        }

        return $this->render('importer/new.html.twig', $data);
    }

    /**
     * @Route("/{id}", name="importer_show", methods={"GET"})
     * @param Importer $importer
     *
     * @return Response
     */
    public function show(Importer $importer): Response
    {
        $this->denyAccessUnlessGranted(['ROLE_MANAGER', 'ROLE_AGENT']);

        $this->get('app.log')->add(Importer::class, 'show', $importer->getId(), ['id']);

        return $this->render('importer/show.html.twig', [
            'importer' => $importer,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="importer_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Importer $importer): Response
    {
        $this->denyAccessUnlessGranted(['ROLE_MANAGER', 'ROLE_AGENT']);

        $form = $this->createForm(ImporterType::class, $importer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->get('app.log')->add(Importer::class, 'edit', $importer->getId(), ['id']);
            $this->addFlash('success', 'Modifications enregistrées avec succès');
            return $this->redirectToRoute('importer_index');
        }

        return $this->render('importer/edit.html.twig', [
            'importer' => $importer,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="importer_delete", methods={"DELETE"})
     * @param Request  $request
     * @param Importer $importer
     *
     * @return Response
     */
    public function delete(Request $request, Importer $importer): Response
    {
        $this->denyAccessUnlessGranted(['ROLE_MANAGER', 'ROLE_AGENT']);

        if ($this->isCsrfTokenValid('delete'.$importer->getId(), $request->request->get('_token'))) {
            try{
                $entityManager = $this->getDoctrine()->getManager();
//                $entityManager->remove($importer);
                $importer->setDeleted(1);
                $entityManager->flush();

                $this->get('app.log')->add(Importer::class, 'delete', $importer->getId(), ['id']);

                $this->addFlash('success', 'Importeur supprimer avec succès');
            }catch (\Exception $e) {
                $this->addFlash('danger', 'Impossible de supprimer l\'importeur pour le moment');
            }
        }

        return $this->redirectToRoute('importer_index');
    }
}
