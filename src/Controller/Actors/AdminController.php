<?php

namespace App\Controller\Actors;

use App\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminController
 * Le controlleur des actions spécifiques des admins.
 * Ne doit pas remplacer le CRUD des entités
 * @package App\Controller\Actors
 * @IsGranted("ROLE_ADMIN")
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
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        return $this->render('actors/admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
}
