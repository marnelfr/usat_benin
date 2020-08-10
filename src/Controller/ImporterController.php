<?php

namespace App\Controller;

use App\Entity\Importer;
use App\Form\ImporterType;
use App\Repository\ImporterRepository;
use App\Repository\ProfilRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
        return $this->render('importer/index.html.twig', [
            'importers' => $importerRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="importer_new", methods={"GET","POST"})
     */
    public function new(Request $request, SluggerInterface $slugger, ProfilRepository $profilRepo): Response
    {
        $importer = new Importer();
        $form = $this->createForm(ImporterType::class, $importer);
        $form->handleRequest($request);

        $uniqid = uniqid();
        $data = $request->request->all('importer');
        if ($request->getMethod() === 'POST') {
            $importer->setEmail($data['e_mail'] === '' ? $uniqid . '_default@dev.fr' : $data['e_mail']);
        }

        if ($form->isSubmitted() && $form->isValid()) {

            $slug = $slugger->slug($importer->getName() . '-' . $importer->getLastName())->lower() . '-' . $uniqid;
            $importer->setUsername($slug);
            $importer->setPassword('-');
            $importer->setProfil($profilRepo->findOneBy(['slug' => 'importer']));
            $importer->setManager($this->getUser());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($importer);
            $entityManager->flush();

            return $this->redirectToRoute('importer_index');
        }

        return $this->render('importer/new.html.twig', [
            'importer' => $importer,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="importer_show", methods={"GET"})
     */
    public function show(Importer $importer): Response
    {
        return $this->render('importer/show.html.twig', [
            'importer' => $importer,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="importer_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Importer $importer): Response
    {
        $form = $this->createForm(ImporterType::class, $importer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

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
        if ($this->isCsrfTokenValid('delete'.$importer->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($importer);
            $entityManager->flush();
        }

        return $this->redirectToRoute('importer_index');
    }
}
