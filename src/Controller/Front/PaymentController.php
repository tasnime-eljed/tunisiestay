<?php
// src/Controller/Front/PaymentController.php

namespace App\Controller\Front;

use App\Entity\Reservation;
use App\Service\Payment\StripeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('IS_AUTHENTICATED_FULLY')]
class PaymentController extends AbstractController
{
    public function __construct(
        private readonly string $stripePublicKey
    ) {
    }

    #[Route('/paiement/{id}', name: 'app_payment')]
    public function index(Reservation $reservation, StripeService $stripe): Response
    {
        return $this->render('front/payment.html.twig', [
            'reservation' => $reservation,
            'clientSecret' => $stripe->creerIntention($reservation),
            'stripePublicKey' => $this->stripePublicKey,
        ]);
    }

    #[Route('/paiement/{id}/success', name: 'app_payment_success')]
    public function success(Reservation $reservation): Response
    {
        $this->addFlash('success', '🎉 Paiement confirmé ! Réservation validée.');
        return $this->render('front/payment_success.html.twig', [
            'reservation' => $reservation,
        ]);
    }
}