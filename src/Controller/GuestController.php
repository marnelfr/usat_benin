<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class GuestController extends AbstractController
{
    /**
     * Display the home page
     *
     * @Route("/", name="home_page")
     */
    public function index(EntityManagerInterface $em, Request $request)
    {
        $login = $request->get('login');

//        dump($request->getSession()->getFlashBag()->get('registration'), $request->getSession()->getFlashBag()->get('emailNotVerified'));
        $flashBag = $request->getSession()->getFlashBag();
        $data = [
            'login_form'            => $login ?? 0,
            'onTheVerificationWay'  => isset($flashBag->get('onTheVerificationWay')[0]),
            'emailNotVerified'  => count($flashBag->get('emailNotVerified')),
            'blocked_user'  => count($flashBag->get('blocked_user')),
            'registration'          => isset($flashBag->get('registration')[0])
        ];
        dump($data);
        return $this->render('guest/home/home.html.twig', $data);
    }
}
