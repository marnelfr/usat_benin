<?php

namespace App\Controller;

use App\Entity\Agent;
use App\Entity\Importer;
use App\Entity\Manager;
use App\Entity\Removal;
use App\Entity\Remover;
use App\Entity\Transfer;
use App\Entity\User;
use App\Entity\Vehicle;
use App\Repository\ImporterRepository;
use App\Repository\RemovalRepository;
use App\Repository\RemoverRepository;
use App\Repository\TransferRepository;
use App\Repository\UserRepository;
use App\Repository\VehicleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
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
     * @Route("/load", options={"expose"=true}, name="statistic_load")
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

            if ($request->get('initial') === 'false') {
                $global = $request->get('global');
                if (!$global) {
                    return new JsonResponse([
                        'typeMessage' => 'warning',
                        'message' => 'Erreur de chargement. Veuillez recharger la page et réessayer'
                    ]);
                }
                $statistics = ['global' => json_decode($global, true)];
                $statistics['global']['global'] = $global;
            } else {
                $statistics = ['global' => $this->getStatistics()];
            }

            $statistics['period'] = $this->getStatistics($debut, $fin);

            return new JsonResponse([
                'typeMessage' => 'success',
                'view' => $this->renderView('statistic/show.html.twig', $statistics)
            ]);
        }
        return new Response('Accès interdit');
    }

    private function getStatistics($debut = null, $fin = null): array
    {
        $doctrine = $this->getDoctrine();
        /** @var TransferRepository $transferRepo */
        $transferRepo = $doctrine->getRepository(Transfer::class);
        /** @var RemovalRepository $removalRepo */
        $removalRepo = $doctrine->getRepository(Removal::class);
        /** @var UserRepository $userRepo */
        $userRepo = $doctrine->getRepository(User::class);
        /** @var VehicleRepository $vehicleRepo */
        $vehicleRepo = $doctrine->getRepository(Vehicle::class);
        /** @var ImporterRepository $importerRepo */
        $importerRepo = $doctrine->getRepository(Importer::class);
        /** @var RemoverRepository $removerRepo */
        $removerRepo = $doctrine->getRepository(Remover::class);

        $global = [];
        $global['transfer'] = [
            'waiting' => $transferRepo->totalTransfer('waiting', null, $debut, $fin),
            'inprogress' => $transferRepo->totalTransfer('inprogress', null, $debut, $fin),
            'finalized' => $transferRepo->totalTransfer('finalized', null, $debut, $fin),
            'rejected' => $transferRepo->totalTransfer('rejected', null, $debut, $fin),
        ];

        $global['removal'] = [
            'waiting' => $removalRepo->totalRemoval('waiting', null, $debut, $fin),
            'finalized' => $removalRepo->totalRemoval('finalized', null, $debut, $fin),
            'rejected' => $removalRepo->totalRemoval('rejected', null, $debut, $fin),
        ];

        $global['vehicle'] = $vehicleRepo->totalVehicle(null, $debut, $fin);
        $global['importer'] = $importerRepo->totalImporter(null, $debut, $fin);
        $global['remover'] = $removerRepo->totalRemover(null, $debut, $fin);

        $global['agent'] = $userRepo->totalUser('agent', null, $debut, $fin);
        $global['manager'] = $userRepo->totalUser('manager', null, $debut, $fin);
        $global['staff'] = $userRepo->totalUser('staff', null, $debut, $fin);
        $global['staff_admin'] = $userRepo->totalUser('staff_admin', null, $debut, $fin);
        $global['controller'] = $userRepo->totalUser('controller', null, $debut, $fin);

        if (!$debut) {
            $global['global'] = json_encode($global);
        }

        return $global;
    }
}
