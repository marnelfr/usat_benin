<?php

namespace App\Controller\Actors;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class StaffController
 * Le controlleur des actions spécifiques du personnel de USAT.
 * Ne doit pas remplacer le CRUD des entités
 * @package App\Controller\Actors
 */
class StaffController extends AbstractController
{
    /**
     * Le tableau de bord du personnel de USAT de la plateforme
     *
     * @Route("/actors/staff", name="actors_staff_dashboard")
     */
    public function index()
    {
        return $this->render('actors/staff/index.html.twig', [
            'controller_name' => 'StaffController',
        ]);
    }
}
