<?php

namespace App\Controller;

use App\Entity\Vehicle;
use App\Form\VehicleType;
use App\Repository\VehicleRepository;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/vehicle")
 */
class VehicleController extends AbstractController
{

    /**
     * @var FileUploader
     */
    private $uploader;

    public function __construct(FileUploader $uploader)
    {
        $this->uploader = $uploader;
    }

    /**
     * @Route("/", name="vehicle_index", methods={"GET"})
     */
    public function index(VehicleRepository $vehicleRepository): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        return $this->render('vehicle/index.html.twig', [
            'vehicles' => $vehicleRepository->findBy(['user' => $this->getUser(), 'deleted' => 0], ['createdAt' => 'DESC']),
        ]);
    }



    /**
     * @Route("/{id}", name="vehicle_show", methods={"GET"})
     */
    public function show(Vehicle $vehicle): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        return $this->render('vehicle/show.html.twig', [
            'vehicle' => $vehicle,
        ]);
    }

    /**
     * @Route("/{id}/img", options = { "expose" = true }, name="vehicle_img", methods={"GET"})
     */
    public function img(Request $request, Vehicle $vehicle) {
        if ($request->isXmlHttpRequest()) {
            return $this->render('vehicle/show_img.html.twig', [
                'url' => '/uploads/bol/' . $vehicle->getBolFileName(),
                'alt' => 'Connaissement de véhicule'
            ]);
        }
        return new Response('access denied');
    }

    /**
     * Est utiliser pour la création des vehicules au niveau des demandes d'enlevement
     *
     * @Route("/new", name="vehicle_new", methods={"GET","POST"})
     * @param Request           $request
     * @param RemovalController $removalController
     * @param array             $data => Les données reçues lorsque la methode new est directement appelé depuis RemovalController
     *
     * @return Response
     */
    public function new(Request $request, RemovalController $removalController, array $data = []): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $vehicle = new Vehicle();
        if ($data) {
            $vehicle->setChassis($data['chassis'])
                ->setBrand($data['brand']);
        }
        $form = $this->createForm(VehicleType::class, $vehicle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $bol */
            $bol = $form->get('bol')->getData();

            if ($bol) {
//                try {
                    $file = $this->uploader->upload($bol);
                    $vehicle->setBolFileName(
                        $file->getLink()
                    );

                    $vehicle->setUser($this->getUser());
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($vehicle);
                    $entityManager->flush();
                    return $removalController->newSaver($request, $vehicle);
//                }catch (\Exception $e) {
//                    dd($e->getMessage());
//                }
            }

//            return $this->redirectToRoute('vehicle_index');
        }

        return $this->render('vehicle/new.html.twig', [
            'vehicle' => $vehicle,
            'form' => $form->createView(),
        ]);
    }

    public function newBack() {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        dump($request->request->all(), $request->query->all()); die();
        $vehicle = new Vehicle();
        $form = $this->createForm(VehicleType::class, $vehicle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($vehicle);
            $entityManager->flush();

            return $this->redirectToRoute('vehicle_index');
        }

        return $this->render('vehicle/new.html.twig', [
            'vehicle' => $vehicle,
            'form' => $form->createView(),
        ]);
    }

    /*
     * @Route("/{id}/edit", name="vehicle_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Vehicle $vehicle): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $form = $this->createForm(VehicleType::class, $vehicle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('vehicle_index');
        }

        return $this->render('vehicle/edit.html.twig', [
            'vehicle' => $vehicle,
            'form' => $form->createView(),
        ]);
    }

    /*
     * @Route("/{id}", name="vehicle_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Vehicle $vehicle): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        if ($this->isCsrfTokenValid('delete'.$vehicle->getId(), $request->request->get('_token'))) {
            try{
                $entityManager = $this->getDoctrine()->getManager();
//                $entityManager->remove($vehicle);
                $vehicle->setDeleted(1);
                $entityManager->flush();
                $this->addFlash('success', 'Véhicule supprimer avec succès');
            } catch (\Exception $e) {
                $this->addFlash('danger', 'Impossible de supprimer le véhicule pour le moment');
            }
        }
        return $this->redirectToRoute('vehicle_index');
    }
}
