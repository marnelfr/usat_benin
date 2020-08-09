<?php
# https://github.com/kevinpapst/AdminLTEBundle/blob/master/Resources/docs/knp_menu.md

namespace App\EventSubscriber;

use KevinPapst\AdminLTEBundle\Event\BreadcrumbMenuEvent;
use KevinPapst\AdminLTEBundle\Event\KnpMenuEvent;
use Knp\Menu\ItemInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Security;

class KnpMenuBuilderSubscriber implements EventSubscriberInterface
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KnpMenuEvent::class => ['onSetupMenu', 100],
            BreadcrumbMenuEvent::class => ['onSetupNavbar', 100]
        ];
    }

    public function onSetupMenu(KnpMenuEvent $event): void
    {
        $menu = $event->getMenu();
        $user = $this->security->getUser();

        if (!$user) {
            return;
        }

        $menu->addChild('MainNavigationMenuItem', [
            'label' => 'MENU PRINCIPAL',
            'childOptions' => $event->getChildOptions()
        ])->setAttribute('class', 'header');

        $menu->addChild('dashboard', [
            'route' => $this->getDashboardPath($user),
            'label' => 'Tableau de bord',
            'childOptions' => $event->getChildOptions()
        ])->setLabelAttribute('icon', 'fas fa-tachometer-alt');

        if ($user->getProfil()->getSlug() === 'manager') {
            $this->getManagerMenu($menu, $event);
        }
        if ($user->getProfil()->getSlug() === 'agent') {
            $this->getAgentMenu($menu, $event);
        }

        $menu->addChild('vehicle', [
            'route' => 'app_register',
            'label' => 'Mes véhicules',
            'childOptions' => $event->getChildOptions(),
        ])->setLabelAttribute('icon', 'fas fa-tachometer-alt');

        $menu->getChild('vehicle')->addChild('new_vehicle', [
            'route' => 'app_register',
            'label' => 'Nouveau véhicule',
            'childOptions' => $event->getChildOptions()
        ])->setLabelAttribute('icon', 'fas fa-rss-square');

        $menu->getChild('vehicle')->addChild('list_vehicle', [
            'route' => 'app_register',
            'label' => 'Liste des véhicules',
            'childOptions' => $event->getChildOptions()
        ])->setLabelAttribute('icon', 'fas fa-rss-square');


    }




    private function getManagerMenu(ItemInterface $menu, KnpMenuEvent $event) {
        $menu->addChild('transfer', [
            'route' => 'app_register',
            'label' => 'Transfert de véhicule',
            'childOptions' => $event->getChildOptions(),
        ])->setLabelAttribute('icon', 'fas fa-tachometer-alt');

        $menu->getChild('transfer')->addChild('new_transfer', [
            'route' => 'app_register',
            'label' => 'Nouvelle demande',
            'childOptions' => $event->getChildOptions()
        ])->setLabelAttribute('icon', 'fas fa-rss-square');

        $menu->getChild('transfer')->addChild('list_transfer', [
            'route' => 'app_register',
            'label' => 'Liste des transferts',
            'childOptions' => $event->getChildOptions()
        ])->setLabelAttribute('icon', 'fas fa-rss-square');

        $menu->getChild('transfer')->getChild('list_transfer')->addChild('remain_transfer', [
            'route' => 'app_register',
            'label' => 'En cours',
            'childOptions' => $event->getChildOptions()
        ])->setLabelAttribute('icon', 'fas fa-rss-square');

        $menu->getChild('transfer')->getChild('list_transfer')->addChild('done_transfer', [
            'route' => 'app_register',
            'label' => 'Finalisés',
            'childOptions' => $event->getChildOptions()
        ])->setLabelAttribute('icon', 'fas fa-rss-square');


        $menu->addChild('importer', [
            'route' => 'app_register',
            'label' => 'Mes importateurs',
            'childOptions' => $event->getChildOptions(),
        ])->setLabelAttribute('icon', 'fas fa-tachometer-alt');

        $menu->getChild('importer')->addChild('new_importer', [
            'route' => 'app_register',
            'label' => 'Nouveau importateur',
            'childOptions' => $event->getChildOptions()
        ])->setLabelAttribute('icon', 'fas fa-rss-square');

        $menu->getChild('importer')->addChild('list_importer', [
            'route' => 'app_register',
            'label' => 'Liste des importateurs',
            'childOptions' => $event->getChildOptions()
        ])->setLabelAttribute('icon', 'fas fa-rss-square');
    }


    private function getAgentMenu(ItemInterface $menu, KnpMenuEvent $event) {
        $menu->addChild('removal', [
            'route' => 'app_register',
            'label' => 'Enlèvement de véhicule',
            'childOptions' => $event->getChildOptions(),
        ])->setLabelAttribute('icon', 'fas fa-tachometer-alt');

        $menu->getChild('removal')->addChild('new_removal', [
            'route' => 'app_register',
            'label' => 'Nouvelle demande',
            'childOptions' => $event->getChildOptions()
        ])->setLabelAttribute('icon', 'fas fa-rss-square');

        $menu->getChild('removal')->addChild('list_removal', [
            'route' => 'app_register',
            'label' => 'Liste des enlèvements',
            'childOptions' => $event->getChildOptions()
        ])->setLabelAttribute('icon', 'fas fa-rss-square');

        $menu->getChild('removal')->getChild('list_removal')->addChild('remain_removal', [
            'route' => 'app_register',
            'label' => 'En cours',
            'childOptions' => $event->getChildOptions()
        ])->setLabelAttribute('icon', 'fas fa-rss-square');

        $menu->getChild('removal')->getChild('list_removal')->addChild('done_removal', [
            'route' => 'app_register',
            'label' => 'Finalisés',
            'childOptions' => $event->getChildOptions()
        ])->setLabelAttribute('icon', 'fas fa-rss-square');


        $menu->addChild('remover', [
            'route' => 'app_register',
            'label' => 'Mes enleveurs',
            'childOptions' => $event->getChildOptions(),
        ])->setLabelAttribute('icon', 'fas fa-tachometer-alt');

        $menu->getChild('remover')->addChild('new_remover', [
            'route' => 'app_register',
            'label' => 'Nouveau enleveur',
            'childOptions' => $event->getChildOptions()
        ])->setLabelAttribute('icon', 'fas fa-rss-square');

        $menu->getChild('remover')->addChild('list_remover', [
            'route' => 'app_register',
            'label' => 'Liste des enleveurs',
            'childOptions' => $event->getChildOptions()
        ])->setLabelAttribute('icon', 'fas fa-rss-square');
    }




    private function getDashboardPath($user) {
        try {
            $role = $user->getRoles()[0];
            $role = strtolower($role);
            $role = str_replace('role_', '', $role);
            return 'actors_' . $role . '_dashboard';
        } catch (\Exception $e) {
            return 'home_page';
        }

    }
}