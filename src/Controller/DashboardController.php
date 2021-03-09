<?php

namespace App\Controller;

use App\Controller\Actors\AdminController;
use App\Controller\Actors\AgentController;
use App\Controller\Actors\ControlController;
use App\Service\UserAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use App\Controller\Actors\ManagerController;
use App\Controller\Actors\StaffController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{

    /**
     * @Route("/dashboard", name="dashboard")
     * @param Request                $request
     * @param EntityManagerInterface $em
     * @param UserAuthenticator      $authenticator
     * @param StaffController        $staff
     * @param AgentController        $agent
     * @param ManagerController      $manager
     * @param ControlController      $control
     * @param AdminController        $admin
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function index(
        Request $request,
        EntityManagerInterface $em,
        UserAuthenticator $authenticator,
        StaffController $staff,
        AgentController $agent,
        ManagerController $manager,
        ControlController $control,
        AdminController $admin
    ) {

        if ($this->isGranted('ROLE_AGENT')) {
            return $agent->index($request, $em, $authenticator);
        }

        if ($this->isGranted('ROLE_MANAGER')) {
            return $manager->index($request, $em, $authenticator);
        }

        if ($this->isGranted('ROLE_STAFF')) {
            return $staff->index();
        }

        if ($this->isGranted('ROLE_CONTROL')) {
            return $control->index($staff);
        }

        if ($this->isGranted('ROLE_ADMIN')) {
            return $admin->index();
        }

        return $this->redirectToRoute('logout');

    }
}
