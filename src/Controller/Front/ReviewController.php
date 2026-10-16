<?php
// src/Controller/Front/ReviewController.php

namespace App\Controller\Front;

use App\Entity\Avis;
use App\Entity\Logement;
use App\Entity\Reservation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_TRAVELER')]
class ReviewController extends AbstractController
{
    #[Route('/avis/nouveau/logement/{id}', name: 'app_review_logement_new', methods: ['POST'])]
    public function newFromLogement(Logement $logement, Request $request, EntityManagerInterface $em): Response
    {
        $note = (int) $request->request->get('note', 0);
        if ($note < 1 || $note > 5) {
            $this->addFlash('error', 'Veuillez sélectionner une note entre 1 et 5 étoiles.');
            return $this->redirectToRoute('app_logement_show', [
                'id'   => $logement->getId(),
                'slug' => $logement->getSlug(),
            ]);
        }

        $avis = new Avis();
        $avis->setVoyageur($this->getUser())
             ->setLogement($logement)
             ->setNote($note)
             ->setCommentaire($request->request->get('commentaire'))
             ->setNoteNettete($request->request->get('note_nettete') ? (int) $request->request->get('note_nettete') : null)
             ->setNoteEmplacement($request->request->get('note_emplacement') ? (int) $request->request->get('note_emplacement') : null)
             ->setNoteRapportQualite($request->request->get('note_rapport_qualite') ? (int) $request->request->get('note_rapport_qualite') : null)
             ->setEstVisible(true)
             ->setCreeLe(new \DateTime());

        $em->persist($avis);
        $em->flush();

        $this->addFlash('success', '⭐ Merci pour votre avis !');
        return $this->redirectToRoute('app_logement_show', [
            'id'   => $logement->getId(),
            'slug' => $logement->getSlug(),
        ]);
    }

    #[Route('/avis/nouveau/{id}', name: 'app_review_new', methods: ['POST'])]
    public function new(Reservation $reservation, Request $request, EntityManagerInterface $em): Response
    {
        if ($reservation->getVoyageur() !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }

        $note = (int) $request->request->get('note', 0);
        if ($note < 1 || $note > 5) {
            $this->addFlash('error', 'Veuillez sélectionner une note entre 1 et 5 étoiles.');
            return $this->redirectToRoute('app_logement_show', [
                'id'   => $reservation->getLogement()->getId(),
                'slug' => $reservation->getLogement()->getSlug(),
            ]);
        }

        $avis = new Avis();
        $avis->setVoyageur($this->getUser())
             ->setLogement($reservation->getLogement())
             ->setReservation($reservation)
             ->setNote($note)
             ->setCommentaire($request->request->get('commentaire'))
             ->setNoteNettete($request->request->get('note_nettete') ? (int) $request->request->get('note_nettete') : null)
             ->setNoteEmplacement($request->request->get('note_emplacement') ? (int) $request->request->get('note_emplacement') : null)
             ->setNoteRapportQualite($request->request->get('note_rapport_qualite') ? (int) $request->request->get('note_rapport_qualite') : null)
             ->setEstVisible(true)
             ->setCreeLe(new \DateTime());

        $em->persist($avis);
        $em->flush();

        $this->addFlash('success', '⭐ Merci pour votre avis !');
        return $this->redirectToRoute('app_logement_show', [
            'id'   => $reservation->getLogement()->getId(),
            'slug' => $reservation->getLogement()->getSlug(),
        ]);
    }
}