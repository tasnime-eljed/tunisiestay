<?php
// src/Service/Booking/BookingService.php

namespace App\Service\Booking;

use App\Entity\Reservation;
use App\Entity\Logement;
use App\Entity\Utilisateur;
use App\Service\Pricing\CommissionCalculator;
use Doctrine\ORM\EntityManagerInterface;

class BookingService
{
    public function __construct(
        private readonly AvailabilityChecker $checker,
        private readonly CommissionCalculator $commission,
        private readonly EntityManagerInterface $em,
    ) {
    }

    public function creer(
        Logement $logement,
        Utilisateur $voyageur,
        \DateTime $checkIn,
        \DateTime $checkOut,
        int $nbVoyageurs
    ): Reservation {
        if (!$this->checker->isAvailable($logement, $checkIn, $checkOut)) {
            throw new \Exception('Ce logement n\'est pas disponible pour ces dates.');
        }

        $nbNuits = $checkIn->diff($checkOut)->days;
        $montantBase = (float) $logement->getPrixParNuit() * $nbNuits;
        $calcul = $this->commission->calculer($montantBase);

        $reservation = (new Reservation())
            ->setVoyageur($voyageur)
            ->setLogement($logement)
            ->setDateArrivee($checkIn)
            ->setDateDepart($checkOut)
            ->setNbVoyageurs($nbVoyageurs)
            ->setNbNuits($nbNuits)
            ->setMontantBase((string) $calcul['base'])
            ->setTauxCommission((string) $calcul['taux'])
            ->setMontantCommission((string) $calcul['commission'])
            ->setMontantTotal((string) $calcul['total'])
            ->setDevise($logement->getDevise())
            ->setStatut('en_attente')
            ->setCreeLe(new \DateTime());

        $this->em->persist($reservation);
        $this->em->flush();

        return $reservation;
    }
}