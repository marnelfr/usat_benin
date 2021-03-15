<?php

namespace App\Controller;

use App\Entity\Notification;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NotificationController extends AbstractController
{
    /**
     * @Route("/notification", name="notification")
     */
    public function index(): Response
    {
        $user = $this->getUser();
        $profile = $user->getProfil()->getSlug();
        if ($profile === 'agent' || $profile === 'manager') {
            $nofifications = $this->getDoctrine()->getRepository(Notification::class)->findBy([
                'user'          => $user,
                'isAlreadyRead' => 0
            ], ['id' => 'DESC']);
            return $this->render('notification/index.html.twig', [
                'notifications' => $nofifications,
                'total' => count($nofifications)
            ]);
        }
        return new Response('');
    }

    /**
     * @Route("/notification/{id}/show", name="notification_show")
     * @param Request      $request
     * @param Notification $notification
     *
     * @return RedirectResponse
     */
    public function access(Request $request, Notification $notification): RedirectResponse
    {
        $notification->setIsAlreadyRead(true);
        $this->getDoctrine()->getManager()->flush();

        if ($notification->getTransfer()) {
            return $this->redirectToRoute('transfer_show', ['id' => $notification->getTransfer()->getId()]);
        }
        if ($notification->getRemoval()) {
            return $this->redirectToRoute('removal_show', ['id' => $notification->getRemoval()->getId()]);
        }
        return new RedirectResponse($request->headers->get('referer'));
    }
}
