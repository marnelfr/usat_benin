<?php

namespace App\Controller;

use App\Entity\DemandeFile;
use App\Entity\Vehicle;
use App\Form\VehicleType;
use App\Repository\VehicleRepository;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
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
            $view = $this->renderView('vehicle/show_img.html.twig', [
                'url' => '/uploads/bol/' . $vehicle->getBolFileName(),
                'alt' => 'Connaissement de véhicule'
            ]);
            return new JsonResponse([
                'view' => $view,
                'error' => $vehicle->getBolFileName() === ''
            ]);
        }
        return new Response('access denied');
    }

    /**
     * Est utilisé pour la création des vehicules au niveau de l'étape 2 du formulaire de demande d'enlevement
     *
     * @Route("/new", name="vehicle_new", methods={"POST"})
     * @param Request           $request
     * @param RemovalController $removalController
     * @param array             $data => Les données reçues lorsque la methode new est directement appelé depuis RemovalController
     * @param bool              $isXmlHttpRequest
     * @param bool              $edit
     *
     * @return string|Response
     */
    public function new(Request $request, RemovalController $removalController, array $data = [], bool $isXmlHttpRequest = false, bool $edit = false)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $entityManager = $this->getDoctrine()->getManager();

        //S'il s'agit d'un edit de removal, cette methode est appelé depuis removal_edit
        // avec la variable $edit à true et l'id du véhicule concerné dans $data
        if ($edit) {
            $vehicle = $entityManager->getRepository(Vehicle::class)->find($data['id']); //On recupère donc le véhicule concerné
        }
        //Grâce à $edit qui est renvoyé à la vue, on ajout au formulaire, l'input de nom $edit lorsque $edit est définit
        //Donc dans ce cas, get(edit) est different de null puisque le champs de name edit existe. Cependant j'arrive pas a recupérer ça valeur
        elseif ($request->get('edit') !== null) {
            //Ayant besoin de l'id de vehicule, il est sauvegardé donc dans le champs id que j'ai rajouté au formulaire.
            $vehicle = $entityManager->getRepository(Vehicle::class)->find($request->get('vehicle')['id']);
            $edit = true; //On remet $edit à true pour qu'on sache qu'on est dans le cas d'une modification
        }
        //Si ni $edit ni le champs de name 'edit' ne sont définit, alors on est dans le cas d'un ajout de vehicule
        else{
            $vehicle = new Vehicle();
            //Lorsque la page est rappeler suite à une erreur sur le formulaire, $data n'est pas fourni
            if ($data) {
                $vehicle->setChassis($data['chassis'])
                    ->setBrand($data['brand']);
            }
        }
//        dd($vehicle);
        $form = $this->createForm(VehicleType::class, $vehicle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $bol */
            $bol = $form->get('bol')->getData();

            //On enregistre un vehicule que si le connaissement est fourni ou s'il s'agit d'une modification
            if ($bol || $edit) {
                try {
                    if ($bol) {
                        $file = $this->uploader->upload($bol, 'bol', $edit, $vehicle->getBolFileName());

                        $entityManager->getRepository(DemandeFile::class)->add(
                            $file,
                            'bol',
                            $vehicle,
                            'vehicle'
                        );

                        $vehicle->setBolFileName(
                            $file->getLink()
                        );
                    }

                    $vehicle->setUser($this->getUser());
                    $entityManager->persist($vehicle);
                    $entityManager->flush();

                    if ($edit) {
                        return $removalController->editSaver($request, $vehicle->getRemoval());
                    }

                    //Une fois le véhicule enregistré, on passe à l'étape 3 du formulaire d'enlèvement
                    return $removalController->newSaver($request, $vehicle);
                }catch (\Exception $e) {
                    dd($e->getMessage());
                }
            }
            $form->get('bol')->addError(new FormError('Veuillez téléverser le connaissement du véhicule'));
//            return $this->redirectToRoute('vehicle_index');
        }

        //Pour les demandes par ajax, fait lorsque l'utilisateur passe de l'étape 1 à l'étape 2 en renseignant des informations
        //de véhicule inexistant
        if ($isXmlHttpRequest) {
            return $this->renderView('vehicle/new_content.html.twig', [
                'vehicle' => $vehicle,
                'form' => $form->createView(),
            ]);
        }

        //Pour les autres demandes qui subviennent lorqu'il y a une erreur de validation sur le formulaire
        return $this->render('vehicle/new.html.twig', [
            'vehicle' => $vehicle,
            //$edit est envoyé à la vue pour mettre le titre adapté et mettre en
            // place l'inp de name 'edit' permettant de savoir qu'on est dans le cas d'une modification
            'edit' => $edit,
            'form' => $form->createView(),
        ]);
    }

    //Back up de la version d'enregistrement par defaut des vehicules
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
