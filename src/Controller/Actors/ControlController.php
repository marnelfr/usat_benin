<?php

namespace App\Controller\Actors;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ControlController
 * Le controlleur des actions spécifiques des contrôleurs (CCIB, MIT).
 * Ne doit pas remplacer le CRUD des entités
 * @package App\Controller\Actors
 */
class ControlController extends AbstractController
{
    /**
     * Le tableau de bord des contrôleurs de la plateforme
     *
     * @Route("/actors/control", name="actors_control_dashboard")
     */
    public function index()
    {
        return $this->render('actors/control/index.html.twig', [
            'controller_name' => 'ControlController',
        ]);
    }
}
