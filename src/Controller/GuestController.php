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

        $data = [
            'login_form'        => $login === null ? 0 : $login,
            'registration'      => isset($request->getSession()->getFlashBag()->get('registration')[0]),
            'emailNotVerified'      => isset($request->getSession()->getFlashBag()->get('emailNotVerified')[0])
        ];
        dump($data);
        return $this->render('guest/home/home.html.twig', $data);
    }
}
