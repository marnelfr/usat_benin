<?php

namespace App\Controller;

use App\Entity\Removal;
use App\Entity\Transfer;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    /**
     * @Route("/search/by/ref", name="search_by_ref")
     */
    public function index(Request $request)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $ref = $request->get('ref');
        $ref = mb_strtoupper($ref);
        $entity_code = substr($ref, 0, 2);

        if ($entity_code !== 'EN' && $entity_code !== 'TR') {
            $this->addFlash('warning', 'Erreur! Veuillez entrer une référence valide');
            goto FIN;
        }

        $em = $this->getDoctrine()->getManager();

        if ($entity_code === 'EN') {
            $demande_name = 'enlèvement';
            $entity_name = 'removal';
            $repo = $em->getRepository(Removal::class);
        }
        if ($entity_code === 'TR') {
            $demande_name = 'transfert';
            $entity_name = 'transfer';
            $repo = $em->getRepository(Transfer::class);
        }

        $demande = $repo->findOneBy(['reference' => $ref]);
        if (!$demande) {
            $this->addFlash('warning', 'La référence entrée ne correspond à aucune demande de ' . $demande_name);
            goto FIN;
        }

        if ($entity_code === 'EN') {
            return $this->render('removal/show.html.twig', [
                $entity_name => $demande,
                'search' => true
            ]);
        }

        if ($entity_code === 'TR') {
            return $this->render('transfer/show.html.twig', [
                $entity_name => $demande,
                'search' => true
            ]);
        }

        $this->addFlash('danger', 'Erreur de chargement');

        FIN:
        return new RedirectResponse($request->headers->get('referer'));
    }
}
