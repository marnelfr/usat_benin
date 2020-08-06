<?php

namespace App\Controller\Actors;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminController
 * Le controlleur des actions spécifiques des admins.
 * Ne doit pas remplacer le CRUD des entités
 * @package App\Controller\Actors
 */
class AdminController extends AbstractController
{
    /**
     * Le tableau de bord des admins de la plateforme
     *
     * @Route("/actors/admin", name="actors_admin_dashboard")
     */
    public function index()
    {
        return $this->render('actors/admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
}
