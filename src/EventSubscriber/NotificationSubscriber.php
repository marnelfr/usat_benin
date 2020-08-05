<?php
# https://github.com/kevinpapst/AdminLTEBundle/blob/master/Resources/docs/navbar_notifications.md
namespace App\EventSubscriber;

use KevinPapst\AdminLTEBundle\Event\NotificationListEvent;
use KevinPapst\AdminLTEBundle\Helper\Constants;
use KevinPapst\AdminLTEBundle\Model\NotificationModel;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Security;

class NotificationSubscriber implements EventSubscriberInterface
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            NotificationListEvent::class => ['onNotifications', 100],
        ];
    }

    public function onNotifications(NotificationListEvent $event)
    {
        $user = $this->security->getUser();

        if (!$user) {
            return;
        }

        $notification = new NotificationModel();
        $notification
            ->setId($user->getId())
            ->setMessage($user->getMessage())
            ->setType(/*Constants::TYPE_SUCCESS*/$user->getType())
            ->setIcon($user->getIcon())
        ;
        $event->addNotification($notification);

        /*
         * You can also set the total number of notifications which could be different from those displayed in the navbar
         * If no total is set, the total will be calculated on the number of notifications added to the event
         */
        $event->setTotal(15);
    }
}