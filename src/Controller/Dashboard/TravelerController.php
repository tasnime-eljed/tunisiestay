<?php

namespace App\Controller\Dashboard;

use App\Repository\AvisRepository;
use App\Repository\FavoriRepository;
use App\Repository\ReservationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_TRAVELER')]
class TravelerController extends AbstractController
{
    #[Route('/voyageur', name: 'traveler_dashboard')]
    public function index(
        ReservationRepository $reservationRepo,
        FavoriRepository $favoriRepo,
        AvisRepository $avisRepo
    ): Response {
        $user = $this->getUser();
        
        $reservations = $reservationRepo->findByVoyageur($user);
        $favoris = $favoriRepo->findByVoyageur($user);
        $avis = $avisRepo->findByVoyageur($user);

        return $this->render('dashboard/traveler/index.html.twig', [
            'reservations' => $reservations,
            'nbReservations' => count($reservations),
            'nbFavoris' => count($favoris),
            'nbAvis' => count($avis),
        ]);
    }

    #[Route('/voyageur/reservations', name: 'traveler_reservations')]
    public function reservations(ReservationRepository $repo): Response
    {
        return $this->render('dashboard/traveler/reservations.html.twig', [
            'reservations' => $repo->findByVoyageur($this->getUser()),
        ]);
    }

    #[Route('/voyageur/reservation/{id}/annuler', name: 'traveler_reservation_annuler', methods: ['POST'])]
    public function annuler(
        int $id,
        ReservationRepository $repo,
        EntityManagerInterface $em
    ): Response {
        $reservation = $repo->find($id);

        if (!$reservation || $reservation->getVoyageur() !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }

        $statutsAnnulables = ['en_attente', 'confirme'];
        if (!in_array($reservation->getStatut(), $statutsAnnulables)) {
            $this->addFlash('error', 'Cette réservation ne peut pas être annulée.');
            return $this->redirectToRoute('traveler_reservations');
        }

        $reservation->setStatut('annule');
        $reservation->setAnnuleLe(new \DateTime());
        $em->flush();

        $this->addFlash('success', '✅ Votre réservation a été annulée avec succès.');
        return $this->redirectToRoute('traveler_reservations');
    }

    #[Route('/voyageur/reservation/{id}/reporter', name: 'traveler_reservation_reporter', methods: ['POST'])]
    public function reporter(
        int $id,
        Request $request,
        ReservationRepository $repo,
        EntityManagerInterface $em
    ): Response {
        $reservation = $repo->find($id);

        if (!$reservation || $reservation->getVoyageur() !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }

        $statutsReportables = ['en_attente', 'confirme'];
        if (!in_array($reservation->getStatut(), $statutsReportables)) {
            $this->addFlash('error', 'Cette réservation ne peut pas être reportée.');
            return $this->redirectToRoute('traveler_reservations');
        }

        $nouvelleArrivee = $request->request->get('nouvelle_arrivee');
        $nouveauDepart   = $request->request->get('nouveau_depart');

        if (!$nouvelleArrivee || !$nouveauDepart) {
            $this->addFlash('error', 'Veuillez renseigner les nouvelles dates.');
            return $this->redirectToRoute('traveler_reservations');
        }

        $dateArrivee = new \DateTime($nouvelleArrivee);
        $dateDepart  = new \DateTime($nouveauDepart);

        if ($dateDepart <= $dateArrivee) {
            $this->addFlash('error', 'La date de départ doit être après la date d\'arrivée.');
            return $this->redirectToRoute('traveler_reservations');
        }

        if ($dateArrivee < new \DateTime('today')) {
            $this->addFlash('error', 'La nouvelle date d\'arrivée doit être dans le futur.');
            return $this->redirectToRoute('traveler_reservations');
        }

        $nbNuits = (int) $dateArrivee->diff($dateDepart)->days;
        $prixParNuit = (float) $reservation->getLogement()->getPrixParNuit();
        $montantBase = $nbNuits * $prixParNuit;
        $taux = (float) ($reservation->getTauxCommission() ?? 0.12);
        $commission = $montantBase * $taux;
        $total = $montantBase + $commission;

        $reservation->setDateArrivee($dateArrivee)
                    ->setDateDepart($dateDepart)
                    ->setNbNuits($nbNuits)
                    ->setMontantBase((string) $montantBase)
                    ->setMontantCommission((string) $commission)
                    ->setMontantTotal((string) $total)
                    ->setStatut('en_attente');

        $em->flush();

        $this->addFlash('success', '📅 Votre réservation a été reportée. En attente de confirmation.');
        return $this->redirectToRoute('traveler_reservations');
    }

    #[Route('/voyageur/favoris', name: 'traveler_favoris')]
    public function favoris(FavoriRepository $repo): Response
    {
        return $this->render('dashboard/traveler/favoris.html.twig', [
            'favoris' => $repo->findByVoyageur($this->getUser()),
        ]);
    }

    #[Route('/voyageur/avis', name: 'traveler_avis')]
    public function avis(AvisRepository $repo): Response
    {
        return $this->render('dashboard/traveler/avis.html.twig', [
            'avis' => $repo->findByVoyageur($this->getUser()),
        ]);
    }

    #[Route('/voyageur/profil', name: 'traveler_profil')]
    public function profil(
        Request $request, 
        EntityManagerInterface $em,
        \Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface $passwordHasher
    ): Response {
        /** @var \App\Entity\Utilisateur $user */
        $user = $this->getUser();

        if ($request->isMethod('POST')) {
            $user->setPrenom($request->request->get('prenom', $user->getPrenom()));
            $user->setNom($request->request->get('nom', $user->getNom()));
            $user->setTelephone($request->request->get('telephone'));

            // Gestion de l'avatar
            $avatarFile = $request->files->get('avatar');
            if ($avatarFile) {
                $newFilename = uniqid().'.'.$avatarFile->guessExtension();
                $avatarFile->move($this->getParameter('kernel.project_dir').'/public/uploads/avatars', $newFilename);
                $user->setAvatarUrl($newFilename);
            }

            // Changement de mot de passe
            $newPassword = $request->request->get('new_password');
            if (!empty($newPassword)) {
                $confirmPassword = $request->request->get('confirm_password');
                if ($newPassword === $confirmPassword) {
                    $hashedPassword = $passwordHasher->hashPassword($user, $newPassword);
                    $user->setPassword($hashedPassword);
                } else {
                    $this->addFlash('error', 'Les mots de passe ne correspondent pas.');
                    return $this->redirectToRoute('traveler_profil');
                }
            }

            $em->flush();
            $this->addFlash('success', 'Profil mis à jour !');
            return $this->redirectToRoute('traveler_profil');
        }

        return $this->render('dashboard/traveler/profil.html.twig', [
            'user' => $user,
        ]);
    }
}