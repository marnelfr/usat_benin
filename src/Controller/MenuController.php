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
            //Un staff_admin n'est d'un staff avec un tout peut privilège dessus: la gestion des utilisateurs
            //Donc il n'a pas de lien personnel
            if ($role === 'ROLE_STAFF_ADMIN') {
                $role = 'ROLE_STAFF';
            }
            $role = strtolower($role);
            $role = str_replace('role_', '', $role);

            //On construit le lien du tableau de bord
            if ($role === 'manager_admin') {
                $role = 'manager';
            }
            if ($role === 'customs_officer') {
                $role = 'agent';
            }
            $data = [
                'dashboard_path' => 'actors_' . $role . '_dashboard'
            ];
            //dd($data, $role);

            $profil = $user->getProfil()->getSlug();
            $data['change_password'] = false;
            //S'il s'agit pas d'un agent ni d'un manager, on ne vérifie en reéalité par le mail
            //La vérification de l'email se substitue ici à la personnalisation du mot de passe qui est obligatoire
            if (/*$profil !== 'agent' && $profil !== 'manager' && */!$user->getIsVerified()) {
                $data['change_password'] = true;
            }
//            dump($data, $profil, $user->getIsVerified(), $this->getParameter('app.base_url'));

            return $this->render('menu/menu_items.html.twig', $data);
        } catch (\Exception $e) {
            return new Response('');
        }
    }
}
