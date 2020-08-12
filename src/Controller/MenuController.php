<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MenuController extends AbstractController
{


    public function menu()
    {
        try {
            $role = $this->getUser()->getRoles()[0];
            $role = strtolower($role);
            $role = str_replace('role_', '', $role);
            return $this->render('includes/menu_items.html.twig', [
                'dashboard_path' => 'actors_' . $role . '_dashboard'
            ]);
        } catch (\Exception $e) {
            return new Response('');
        }
    }
}
