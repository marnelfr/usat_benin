<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Service\FileUploader;
use App\Service\LocalFileUploader;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class UserController
 * @package App\Controller
 * @Route("/user")
 * @IsGranted("ROLE_STAFF_ADMIN")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="user_index", methods={"GET"})
     * @param UserRepository $userRepository
     *
     * @return Response
     */
    public function index(UserRepository $userRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_STAFF_ADMIN');
        $this->get('app.log')->add('User', 'index');

        return $this->render('user/index.html.twig', [
            'users' => $userRepository->all(),
        ]);
    }

    /**
     * @Route("/new", name="user_new", methods={"GET","POST"})
     * @param Request                      $request
     * @param UserPasswordEncoderInterface $encoder
     *
     *
     * @param FileUploader                 $uploader
     *
     * @return Response
     */
    public function new(Request $request, UserPasswordEncoderInterface $encoder, FileUploader $uploader): Response
    {
        $this->denyAccessUnlessGranted('ROLE_STAFF_ADMIN');

        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $image */
            $image = $form->get('image')->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $slug = $user->getProfil()->getSlug();
            if ($slug === 'agent') {
                $user->setRoles(['ROLE_AGENT']);
            }elseif ($slug === 'manager') {
                $user->setRoles(['ROLE_MANAGER']);
            }elseif ($slug === 'staff') {
                $user->setRoles(['ROLE_STAFF', 'ROLE_CONTROL']);
            }elseif($slug === 'staff_admin') {
                $user->setRoles(['ROLE_STAFF_ADMIN', 'ROLE_STAFF', 'ROLE_CONTROL']);
            }elseif($slug === 'respo_manager') {
                $user->setRoles(['ROLE_MANAGER_ADMIN', 'ROLE_MANAGER']);
            }elseif($slug === 'customs_officer') {
                $user->setRoles(['ROLE_CUSTOMS_OFFICER', 'ROLE_AGENT']);
            }elseif($slug === 'controller') {
                $user->setRoles(['ROLE_CONTROL']);
            }
            $user->setStatus(1);
            $user->setIsVerified(0);
            $user->setPassword(
                $encoder->encodePassword(
                    $user,
                    $user->getPassword()
                )
            );
            $entityManager->persist($user);

            if ($image) {
                $uploader->upload($image, 'dp', $user, 'user', false, true);
            }

            $entityManager->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param User $user
     * @Route("/{id}", name="user_show", methods={"GET"})
     *
     * @return Response
     */
    public function show(User $user): Response
    {
        $this->denyAccessUnlessGranted('ROLE_STAFF_ADMIN');

        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user): Response
    {
        $this->denyAccessUnlessGranted('ROLE_STAFF_ADMIN');

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        //todo: comment ne pas afficher le champs de mot de passe à la modification de l'utilisateur ?
        /**
         * Bon je me dis qu'on va supprimer le champs avec js genre .remove() quoi, quand le formulaire va s'afficher
         *  Mais si on fait ça, ça va pas invalider le formulaire ?
         */

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_delete", methods={"DELETE"})
     */
    public function delete(Request $request, User $user): Response
    {
        $this->denyAccessUnlessGranted('ROLE_STAFF_ADMIN');

        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            if ($user->getStatus()) {
                $message = $user->getFullname() . ' a été bloqué avec succès';
                $user->setStatus(0);
            }else{
                $message = $user->getFullname() . ' a été débloqué avec succès';
                $user->setStatus(1);
            }
//            $entityManager->remove($user);
            $this->addFlash('success', $message);
            $this->getDoctrine()->getManager()->flush();
        }

        return $this->redirectToRoute('user_index');
    }
}
