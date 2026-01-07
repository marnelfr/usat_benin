<?php

namespace App\Controller;

use App\Entity\Agent;
use App\Entity\Manager;
use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\FleetRepository;
use App\Security\EmailVerifier;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Form\Exception\LogicException;
use Symfony\Component\Form\Exception\OutOfBoundsException;
use Symfony\Component\Form\Exception\RuntimeException;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class RegistrationController extends AbstractController
{
    private $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }

    /**
     * @Route("/register", name="app_register")
     * @param Request                      $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param FleetRepository              $fleetRepo
     *
     * @return Response
     * @throws LogicException
     * @throws OutOfBoundsException
     * @throws RuntimeException
     * @throws \Symfony\Component\HttpFoundation\Exception\BadRequestException
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, FleetRepository $fleetRepo): Response
    {
        return $this->redirectToRoute('home_page', [], 301);
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        if ($user->getUsername() === null) {
            $user->setUsername(' ');
        }
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //On recupère toutes les données du formulaire même les champs non mappés
            $data = $request->request->all('registration_form');

            if ($user->getProfil()->getSlug() === 'manager') {
                //On recupère le parc du guestionnaire
                $fleet = $fleetRepo->find($data['fleet']);

                //Si le parc n'existe pas...
                if (!$fleet) {
                    $form->addError(new FormError('Parc inexistant'));
                    goto END_GET;
                }

                $newUser = new Manager();
                $newUser->setFleet($fleet);
//                $newUser->setRoles(['ROLE_MANAGER']);
            } else {
                $newUser = new Agent();
//                $newUser->setRoles(['ROLE_AGENT']);
            }

            $newUser->setAddress($user->getAddress())
                ->setEmail($user->getEmail())
                ->setLastName($user->getLastName())
                ->setName($user->getName())
                ->setPhone($user->getPhone())
                ->setProfil($user->getProfil())
                ->setUsername($user->getUsername())
                ->setCompagny($data['compagny'])
//                ->setIfu($data['ifu'])
//                ->setRegisterNum($data['registerNum'])
            ;

            // encode the plain password
            $newUser->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($newUser);
            $entityManager->flush();

            // generate a signed url and email it to the user
            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $newUser,
                (new TemplatedEmail())
                    ->from(new Address('marnelginola@gmail.com', 'UsaTum'))
                    ->to($newUser->getEmail())
                    ->subject('Please Confirm your Email')
                    ->htmlTemplate('registration/confirmation_email.html.twig')
            );
            // do anything else you need here, like send an email
//            $request->getSession()->getFlashBag()->add('registration', true);
            $this->addFlash('registration', true);

            return $this->redirectToRoute('home_page');
        }

        END_GET:
        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/verify/email", name="app_verify_email")
     */
    public function verifyUserEmail(Request $request): Response
    {
        return $this->redirectToRoute('home_page', [], 301);

        if (!$this->isGranted('IS_AUTHENTICATED_FULLY')) {
            $this->addFlash('onTheVerificationWay', true);
        }
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $this->getUser());
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $exception->getReason());

            return $this->redirectToRoute('app_register');
        }

        $user = $this->getUser();

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
        $this->addFlash('emailVerifySuccessfully', $user->getId());
        $this->addFlash('success', 'Votre adresse email a été vérifié avec succès');

        if ($user->getProfil()->getSlug() === 'manager') {
            $user->setRoles(['ROLE_MANAGER']);
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('actors_manager_dashboard');
        }
        if ($user->getProfil()->getSlug() === 'agent') {
            $user->setRoles(['ROLE_AGENT']);
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('actors_agent_dashboard');
        }

        return $this->redirectToRoute('home_page');
    }
}
