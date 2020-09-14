<?php

namespace App\Controller;

use App\Entity\Agent;
use App\Entity\Fleet;
use App\Entity\Inform;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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

        // TODO: Mettre en place une action pour afficher les informations
        $parc = $this->createFormBuilder()
            ->add('fleet', EntityType::class, [
                'mapped' => false,
                'class' => Fleet::class,
                'placeholder' => 'Selectionnez un parc',
                'query_builder' => static function (EntityRepository $er) {
                    return $er->createQueryBuilder('f')
                        ->where('f.deleted=0')
                        ->orderBy('f.name', 'ASC')
                    ;
                },
            ])->getForm()
        ;
        $parc->handleRequest($request);
        $informs = $em->getRepository(Inform::class)->all();

        // TODO: Mettre en place une action pour afficher les informations
        $commissionnaire = $this->createFormBuilder()
            ->add('agent', EntityType::class, [
                'mapped' => false,
                'class' => Agent::class,
                'placeholder' => 'Selectionnez un commissionnaire',
                'query_builder' => static function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.name', 'ASC')
                    ;
                },
            ])->getForm()
        ;

        $commissionnaire->handleRequest($request);

//        dump($request->getSession()->getFlashBag()->get('registration'), $request->getSession()->getFlashBag()->get('emailNotVerified'));
        $flashBag = $request->getSession()->getFlashBag();
        $data = [
            'login_form'            => $login ?? 0,
            'onTheVerificationWay'  => isset($flashBag->get('onTheVerificationWay')[0]),
            'emailNotVerified'      => count($flashBag->get('emailNotVerified')),
            'blocked_user'          => count($flashBag->get('blocked_user')),
            'registration'          => isset($flashBag->get('registration')[0]),
            'parc'                  => $parc->createView(),
            'commissionnaire'       => $commissionnaire->createView(),
            'informs'               => $informs
        ];
        //dump($data);
        return $this->render('guest/home/home.html.twig', $data);
    }

    /**
     * @param Request $request
     * @Route("/guest/show/fleet", name="guest_show_fleet")
     */
    public function showFleet(Request $request) {

        // TODO: Recuperer le fleet
        $fleet = new Fleet();
        return $this->render('guest/show_fleet.html.twig', [
            'fleet' => $fleet
        ]);
    }

    /**
     * @param Request $request
     * @Route("/guest/shpw/agent", name="guest_show_agent")
     */
    public function showAgent(Request $request) {

        // TODO: Recuperer l'agent
        $agent = new Agent();
        return $this->render('guest/show_agent.html.twig', [
            'agent' => $agent
        ]);
    }
}
