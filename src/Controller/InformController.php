<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class InformController extends AbstractController
{
    /**
     * @Route("/inform", name="inform")
     */
    public function index()
    {
        return $this->render('inform/index.html.twig', [
            'controller_name' => 'InformController',
        ]);
    }
}
