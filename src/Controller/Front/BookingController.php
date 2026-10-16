<?php
// src/Controller/Front/BookingController.php

namespace App\Controller\Front;

use App\Entity\Logement;
use App\Service\Booking\BookingService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class BookingController extends AbstractController
{
    #[Route('/reservation/creer/{id}', name: 'app_booking_create', methods: ['POST'])]
    #[IsGranted('ROLE_TRAVELER')]
    public function create(
        Logement $logement,
        Request $request,
        BookingService $service
    ): Response {
        try {
            $reservation = $service->creer(
                $logement,
                $this->getUser(),
                new \DateTime($request->request->get('check_in')),
                new \DateTime($request->request->get('check_out')),
                (int) $request->request->get('nb_voyageurs', 1)
            );

            return $this->redirectToRoute('app_payment', [
                'id' => $reservation->getId()
            ]);

        } catch (\Exception $e) {
            $this->addFlash('error', $e->getMessage());
            return $this->redirectToRoute('app_logement_show', [
                'id' => $logement->getId(),
                'slug' => $logement->getSlug(),
            ]);
        }
    }
}