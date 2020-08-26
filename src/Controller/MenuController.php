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

            $user = $this->getUser();
            $role = $user->getRoles()[0];
            $role = strtolower($role);
            $role = str_replace('role_', '', $role);

            $data = [
                'dashboard_path' => 'actors_' . $role . '_dashboard'
            ];

            $profil = $user->getProfil()->getSlug();
            if ($profil !== 'agent' && $profil !== 'manager' && !$user->getIsVerified()) {
                $data['change_password'] = true;
            }

            return $this->render('includes/menu_items.html.twig', $data);
        } catch (\Exception $e) {
            return new Response('');
        }
    }
}
