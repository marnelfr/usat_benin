<?php

namespace App\Controller;

use App\Entity\Importer;
use App\Form\ImporterType;
use App\Repository\ImporterRepository;
use App\Repository\ProfilRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
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
     */
    public function index(ImporterRepository $importerRepository): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $this->get('app.log')->add('Importer', 'index');

        return $this->render('importer/index.html.twig', [
            'importers' => $importerRepository->findBy(['deleted' => 0, 'user' => $this->getUser()], ['id' => 'DESC']),
        ]);
    }

    /**
     * @Route("/new", name="importer_new", options={"expose"=true}, methods={"GET","POST"})
     */
    public function new(Request $request, SluggerInterface $slugger, ProfilRepository $profilRepo, ImporterRepository $importerRepo): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

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
     */
    public function show(Importer $importer): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        return $this->render('importer/show.html.twig', [
            'importer' => $importer,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="importer_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Importer $importer): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $form = $this->createForm(ImporterType::class, $importer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
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
     */
    public function delete(Request $request, Importer $importer): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        if ($this->isCsrfTokenValid('delete'.$importer->getId(), $request->request->get('_token'))) {
            try{
                $entityManager = $this->getDoctrine()->getManager();
//                $entityManager->remove($importer);
                $importer->setDeleted(1);
                $entityManager->flush();
                $this->addFlash('success', $importer->getFullname() . ' supprimer avec succès');
            }catch (\Exception $e) {
                $this->addFlash('danger', 'Impossible de supprimer ' . $importer->getFullname() . ' pour le moment');
            }
        }

        return $this->redirectToRoute('importer_index');
    }
}
