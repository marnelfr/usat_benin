<?php

namespace App\Controller\Actors;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ManagerController
 * Le controlleur des actions spécifiques des manager.
 * Ne doit pas remplacer le CRUD des entités
 * @package App\Controller\Actors
 */
class ManagerController extends AbstractController
{
    /**
     * Le tableau de bord des managers de la plateforme
     *
     * @Route("/actors/manager", name="actors_manager_dashboard")
     */
    public function index()
    {
        return $this->render('actors/manager/index.html.twig', [
            'controller_name' => 'ManagerController',
        ]);
    }
}
