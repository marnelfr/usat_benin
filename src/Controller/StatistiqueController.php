<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class StatistiqueController extends AbstractController
{
    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request)
    {
        $form = $this->createFormBuilder()
            ->add('from', DateType::class, [
                'mapped' => false,
                'label' => 'Date début',
                'placeholder' => 'Renseigner une date début',
                'widget' => 'single_text',
                'data' => new \DateTime()
            ])
            ->add('to', DateType::class, [
                'mapped' => false,
                'label' => 'Date fin',
                'placeholder' => 'Renseignez une date fin',
                'widget' => 'single_text',
                'data' => new \DateTime()
            ])
            ->getForm();

        $form->handleRequest($request);

        return $this->render('statistique/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
