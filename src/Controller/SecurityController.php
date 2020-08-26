<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

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
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
//        if (!$this->isGranted('IS_AUTHENTICATED_FULLY')) {
//            return $this->redirectToRoute('home_page');
//        }
        // TODO: Est-ce qu'il faut vraiment interdit à cex qui n'ont pas valider leur email de se connecter
        $user = $this->getUser();
        $profil = $user->getProfil()->getSlug();
        if (!$user->getIsVerified() && $profil === 'agent' && $profil === 'manager') {
            /*$profil = $user->getProfil()->getSlug();
            if ($profil !== 'agent' && $profil !== 'manager') {
                $this->addFlash('warning', 'Veuillez personnaliser votre code d\'accès');
                return $this->redirectToRoute('user_new_password');
            }*/
            $this->addFlash('emailNotVerified', true);
            return $this->redirectToRoute('home_page');
        }
        if (!$user->getStatus()) {
            $this->addFlash('blocked_user', true);
            return $this->redirectToRoute('home_page');
        }

        // TODO: Mettre en place un eventSubscriber pour mieux gérer ceci
        $user->setLastConnection(new \DateTime());
        $this->getDoctrine()->getManager()->flush();

        if ($this->isGranted('ROLE_AGENT')) {
            return $this->redirectToRoute('actors_agent_dashboard');
        }

        if ($this->isGranted('ROLE_MANAGER')) {
            return $this->redirectToRoute('actors_manager_dashboard');
        }

        if ($this->isGranted('ROLE_STAFF')) {
            return $this->redirectToRoute('actors_staff_dashboard');
        }

        if ($this->isGranted('ROLE_CONTROL')) {
            return $this->redirectToRoute('actors_control_dashboard');
        }

        if ($this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('actors_admin_dashboard');
        }

        return $this->redirectToRoute('home_page');
    }


    /**
     * @param Request $request
     * @Route("/p/c/n", name="pcn", options={"expose"=true})
     * @return JsonResponse
     */
    public function change_password(Request $request, UserPasswordEncoderInterface $encoder) {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $form = $this->createFormBuilder()
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'mapped' => false,
                'invalid_message' => 'Vos codes d\'accès ne correspondent pas',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options'  => ['label' => 'Code d\'accès'],
                'second_options' => ['label' => 'Confirmez code'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrez un code d\'accès',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre code doit avoir au moins {{ limit }} charactères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ]
            ])->getForm()
        ;
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $user->setPassword(
                $encoder->encodePassword(
                    $user,
                    $form->get('
                    plainPassword')->getData()
                )
            );
            $user->setIsVerified(1);
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Code d\'accès modifier avec succès');
            return new JsonResponse([
                'typeMessage' => 'success',
                'link' => $this->generateUrl('security_check_user_profil')
            ]);
        }

        if ($request->isXmlHttpRequest()) {
            return new JsonResponse([
                'typeMessage' => 'form',
                'view' => $this->renderView('security/new_pwd_form.html.twig', [
                    'form' => $form->createView()
                ])
            ]);
        }

    }


    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
