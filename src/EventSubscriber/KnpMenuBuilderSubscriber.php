<?php
# https://github.com/kevinpapst/AdminLTEBundle/blob/master/Resources/docs/knp_menu.md

namespace App\EventSubscriber;

use KevinPapst\AdminLTEBundle\Event\KnpMenuEvent;
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

        $menu->addChild('blogId', [
            'route' => 'app_register',
            'label' => 'Transfert de véhicule',
            'childOptions' => $event->getChildOptions(),
//            'extras' => [
//                'badge' => [
//                    'color' => 'yellow',
//                    'value' => 4,
//                ],
//            ],
        ])->setLabelAttribute('icon', 'fas fa-tachometer-alt');

        $menu->getChild('blogId')->addChild('ChildOneItemId', [
            'route' => 'app_register',
            'label' => 'ChildOneDisplayName',
            'extras' => [
                'badges' => [
                    [ 'value' => 6, 'color' => 'blue' ],
                    [ 'value' => 5, ],
                ],
            ],
            'childOptions' => $event->getChildOptions()
        ])->setLabelAttribute('icon', 'fas fa-rss-square');

        $menu->getChild('blogId')->addChild('ChildTwoItemId', [
            'route' => 'app_register',
            'label' => 'ChildTwoDisplayName',
            'childOptions' => $event->getChildOptions()
        ]);
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