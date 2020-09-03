<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class StatisticController
 * @package App\Controller
 * @Route("/statistic")
 */
class StatisticController extends AbstractController
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

        return $this->render('statistic/index.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/load", options={"expose"=true}, ,name="statistic_load")
     * @param Request $request
     */
    public function load(Request $request) {

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        if ($request->isXmlHttpRequest()) {
            $debut = new \DateTime($request->get('debut'));
            $fin = new \DateTime($request->get('fin'));
            if (!$debut || !$fin) {
                return new JsonResponse([
                    'typeMessage' => 'warning',
                    'message' => 'Veuillez renseigner une date de début et une date fin'
                ]);
            }
            $statistics = $this->getStatistics($debut, $fin);
            return new JsonResponse([
                'typeMessage' => 'success',
                'view' => $this->renderView('statistic/show.html.twig', $statistics)
            ]);
        }
        return new Response('Accès interdit');
    }

    private function getStatistics($debut, $fin)
    {
        /**
         * nombre de transfert qui à été
         *      demander
         *      dont le traitement est encours
         *      dont le traitement a été aprouvé
         *      rejeter
         * nombre d'enlevement qui a été
         *      demander
         *      dont le traitment est encours
         *      dont le traitement est approuvé
         *      rejeter
         * nombre de gestionnaire qu'on a
         * nombre de commissionnaire qu'on a
         * nombre importer
         * nombre de verification de fiche imprimer qui a été effectué
         * nombre de vehicule qui a eté enregistré au total
         */



    }
}
