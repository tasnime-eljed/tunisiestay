<?php
// src/Service/Payment/StripeService.php

namespace App\Service\Payment;

use App\Entity\Paiement;
use App\Entity\Reservation;
use Doctrine\ORM\EntityManagerInterface;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class StripeService
{
    public function __construct(
        private readonly string $secretKey,
        private readonly EntityManagerInterface $em,
    ) {
        Stripe::setApiKey($this->secretKey);
    }

    public function creerIntention(Reservation $reservation): string
    {
        $params = [
            'amount' => (int) ($reservation->getMontantTotal() * 100),
            'currency' => strtolower($reservation->getDevise() === 'TND' ? 'usd' : 'eur'),
            'metadata' => ['reservation_id' => $reservation->getId()],
        ];

        /** @var PaymentIntent $intent */
        $intent = PaymentIntent::create($params);

        $paiement = (new Paiement())
            ->setReservation($reservation)
            ->setMontant($reservation->getMontantTotal())
            ->setDevise($reservation->getDevise())
            ->setStripeIntentionId($intent->id)
            ->setStatut('en_attente');

        $this->em->persist($paiement);
        $this->em->flush();

        return $intent->client_secret;
    }
}