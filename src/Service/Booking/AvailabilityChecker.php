<?php
// src/Service/Booking/AvailabilityChecker.php

namespace App\Service\Booking;

use App\Entity\Logement;
use App\Repository\ReservationRepository;

class AvailabilityChecker
{
    public function __construct(
        private readonly ReservationRepository $repo
    ) {
    }

    public function isAvailable(Logement $logement, \DateTime $checkIn, \DateTime $checkOut): bool
    {
        return count($this->repo->findConflicts($logement, $checkIn, $checkOut)) === 0;
    }

    public function getDatesBloquees(Logement $logement): array
    {
        $reservations = $this->repo->findBy([
            'logement' => $logement,
            'statut' => ['confirme', 'en_attente'],
        ]);

        $dates = [];
        foreach ($reservations as $r) {
            $current = clone $r->getDateArrivee();
            while ($current <= $r->getDateDepart()) {
                $dates[] = $current->format('Y-m-d');
                $current->modify('+1 day');
            }
        }
        return $dates;
    }
}