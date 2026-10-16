<?php
// src/Controller/Front/LogementController.php

namespace App\Controller\Front;

use App\Entity\Logement;
use App\Repository\AvisRepository;
use App\Repository\FavoriRepository;
use App\Repository\ReservationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LogementController extends AbstractController
{
    #[Route('/logement/{id}-{slug}', name: 'app_logement_show')]
    public function show(
        Logement $logement,
        string $slug,
        AvisRepository $avisRepo,
        ReservationRepository $reservationRepo,
        FavoriRepository $favoriRepo
    ): Response {
        // Rediriger si slug incorrect
        if ($logement->getSlug() !== $slug) {
            return $this->redirectToRoute('app_logement_show', [
                'id'   => $logement->getId(),
                'slug' => $logement->getSlug(),
            ], 301);
        }

        $avis = $avisRepo->findBy(
            ['logement' => $logement, 'estVisible' => true],
            ['creeLe' => 'DESC']
        );

        // Dates bloquées (JSON pour le calendrier JS)
        $reservationsActives = $reservationRepo->findActiveByLogement($logement);
        $datesBloquees = [];
        foreach ($reservationsActives as $resa) {
            $period = new \DatePeriod(
                $resa->getDateArrivee(),
                new \DateInterval('P1D'),
                $resa->getDateDepart()
            );
            foreach ($period as $dt) {
                $datesBloquees[] = $dt->format('Y-m-d');
            }
        }

        // Favori status
        $isFavori = false;
        if ($this->getUser()) {
            $isFavori = (bool) $favoriRepo->findOneBy([
                'voyageur' => $this->getUser(),
                'logement' => $logement,
            ]);
        }

        // Réservation terminée sans avis (pour permettre de laisser un avis)
        $reservationEligible = null;
        if ($this->getUser()) {
            $reservationsTerminees = $reservationRepo->findBy([
                'voyageur' => $this->getUser(),
                'logement' => $logement,
                'statut'   => 'terminee',
            ]);
            foreach ($reservationsTerminees as $r) {
                // Vérifier que cet utilisateur n'a pas déjà laissé un avis pour cette résa
                $dejaAvis = $avisRepo->findOneBy(['reservation' => $r]);
                if (!$dejaAvis) {
                    $reservationEligible = $r;
                    break;
                }
            }
        }

        return $this->render('front/logement_show.html.twig', [
            'logement'             => $logement,
            'avis'                 => $avis,
            'datesBloquees'        => json_encode($datesBloquees),
            'isFavori'             => $isFavori,
            'reservationEligible'  => $reservationEligible,
            'noteMoyenne'          => count($avis) > 0
                ? round(array_sum(array_map(fn($a) => $a->getNote(), $avis)) / count($avis), 1)
                : null,
        ]);
    }
}