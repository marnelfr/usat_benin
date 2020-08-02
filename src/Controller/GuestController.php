<?php

namespace App\Controller;

use App\Entity\Vehicule;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class GuestController extends AbstractController
{
    /**
     * Display the home page
     *
     * @Route("/", name="home_page")
     */
    public function index(EntityManagerInterface $em)
    {
//        $vehicules = $em->getRepository(Vehicule::class)->findAll();
//        dump($vehicules); die();
        return $this->render('guest/home.html.twig');
    }
}
