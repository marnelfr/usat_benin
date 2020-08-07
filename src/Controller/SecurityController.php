<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/home", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        //C'est dans le Security/AppCustomAuthenticator que ça se passe

        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        $login = $this->renderView('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);

        return $this->forward('App\Controller\GuestController:index', [], ['login' => $login]);
    }

    /**
     * @Route("/login/form", name="app_login_form")
     * @return Response
     */
    public function login_form(AuthenticationUtils $authenticationUtils): Response {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/check/user/profil", name="security_check_user_profil")
     */
    public function check_user_profil() {
//        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY'); //todo : Comment rediriger en utilisant ceci ??
//        if (!$this->isGranted('IS_AUTHENTICATED_FULLY')) {
//            return $this->redirectToRoute('home_page');
//        }
        // TODO: Est-ce qu'il faut vraiment interdit à cex qui n'ont pas valider leur email de se connecter
//        $user = $this->getUser();
//        if (!$user->getIsVerified()) {
//            $this->addFlash('emailNotVerified', true);
//            return $this->redirectToRoute('app_logout');
//        }
        if ($this->isGranted('ROLE_AGENT')) {
            return $this->redirectToRoute('actors_agent_dashboard');
        }

        if ($this->isGranted('ROLE_MANAGER')) {
            return $this->redirectToRoute('actors_manager_dashboard');
        }

        if ($this->isGranted('ROLE_CONTROL')) {
            return $this->redirectToRoute('actors_control_dashboard');
        }

        if ($this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('actors_admin_dashboard');
        }

        if ($this->isGranted('ROLE_STAFF')) {
            return $this->redirectToRoute('actors_staff_dashboard');
        }

        return $this->redirectToRoute('home_page');
    }







    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
