<?php
# https://github.com/kevinpapst/AdminLTEBundle/blob/master/Resources/docs/knp_menu.md

namespace App\EventSubscriber;

use KevinPapst\AdminLTEBundle\Event\KnpMenuEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class KnpMenuBuilderSubscriber implements EventSubscriberInterface
{

    public static function getSubscribedEvents(): array
    {
        return [
            KnpMenuEvent::class => ['onSetupMenu', 100],
        ];
    }

    public function onSetupMenu(KnpMenuEvent $event): void
    {
        $menu = $event->getMenu();

        $menu->addChild('MainNavigationMenuItem', [
            'label' => 'MENU PRINCIPAL',
            'childOptions' => $event->getChildOptions()
        ])->setAttribute('class', 'header');

        $menu->addChild('dashboard', [
            'route' => 'dashboard',
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
}