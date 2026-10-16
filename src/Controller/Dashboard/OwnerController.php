<?php

namespace App\Controller\Dashboard;

use App\Entity\Logement;
use App\Form\LogementType;
use App\Repository\AvisRepository;
use App\Repository\LogementRepository;
use App\Repository\ReservationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Cocur\Slugify\Slugify;
use App\Entity\Utilisateur;
use App\Entity\Media;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\String\Slugger\SluggerInterface;


#[IsGranted('ROLE_OWNER')]
class OwnerController extends AbstractController
{
    // =============================================
    // TABLEAU DE BORD
    // =============================================
    #[Route('/proprietaire', name: 'owner_dashboard')]
    public function index(
        LogementRepository $logementRepo,
        ReservationRepository $reservationRepo,
        AvisRepository $avisRepo
    ): Response {
        $proprietaire = $this->getUser();
        $logements = $logementRepo->findBy(['proprietaire' => $proprietaire], ['creeLe' => 'DESC']);
        $reservations = $reservationRepo->findByProprietaire($proprietaire);

        $reservationsActives = array_filter(
            $reservations,
            fn($r) => in_array($r->getStatut(), ['en_attente', 'confirme'])
        );

        return $this->render('dashboard/owner/index.html.twig', [
            'logements' => $logements,
            'reservations' => array_slice($reservations, 0, 5),
            'nbLogements' => count($logements),
            'nbReservationsActives' => count($reservationsActives),
            'revenus' => $reservationRepo->getTotalRevenusProprietaire($proprietaire),
            'noteMoyenne' => $avisRepo->getNoteMoyenneProprietaire($proprietaire),
        ]);
    }

    // =============================================
    // MES LOGEMENTS
    // =============================================
    #[Route('/proprietaire/logements', name: 'owner_logements')]
    public function logements(LogementRepository $repo): Response
    {
        return $this->render('dashboard/owner/logements.html.twig', [
            'logements' => $repo->findBy(
                ['proprietaire' => $this->getUser()],
                ['creeLe' => 'DESC']
            ),
        ]);
    }

    // =============================================
    // CRÉER UN LOGEMENT
    // =============================================
    #[Route('/proprietaire/logement/nouveau', name: 'owner_logement_new')]
    public function new(Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
        $logement = new Logement();
        $form = $this->createForm(LogementType::class, $logement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $slugify = new Slugify();
            $logement
                ->setSlug($slugify->slugify($logement->getTitre()) . '-' . uniqid())
                ->setProprietaire($this->getUser())
                ->setStatut('en_attente')
                ->setCreeLe(new \DateTime())
                ->setModifieLe(new \DateTime());

            $imageFiles = $form->get('images')->getData();
            if ($imageFiles) {
                foreach ($imageFiles as $imageFile) {
                    $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                    $safeFilename = $slugger->slug($originalFilename);
                    $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

                    try {
                        $imageFile->move(
                            $this->getParameter('logements_directory'),
                            $newFilename
                        );
                    } catch (FileException $e) {
                        // handle exception if something happens during file upload
                    }

                    $media = new Media();
                    $media->setNomFichier($newFilename);
                    $media->setType('image');
                    $media->setTypeMime($imageFile->getClientMimeType() ?? 'image/jpeg');
                    $media->setPosition(0);
                    $media->setLogement($logement);
                    $em->persist($media);
                }
            }

            $em->persist($logement);
            $em->flush();

            $this->addFlash('success', '🎉 Logement créé ! En attente de validation admin.');
            return $this->redirectToRoute('owner_logements');
        }

        return $this->render('dashboard/owner/logement_form.html.twig', [
            'form' => $form,
            'titrePage' => 'Nouveau logement',
            'logement' => null,
        ]);
    }

    // =============================================
    // MODIFIER UN LOGEMENT
    // =============================================
    #[Route('/proprietaire/logement/{id}/modifier', name: 'owner_logement_edit')]
    public function edit(Logement $logement, Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
        if ($logement->getProprietaire() !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }

        $form = $this->createForm(LogementType::class, $logement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $logement->setModifieLe(new \DateTime());

            $imageFiles = $form->get('images')->getData();
            if ($imageFiles) {
                foreach ($imageFiles as $imageFile) {
                    $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                    $safeFilename = $slugger->slug($originalFilename);
                    $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

                    try {
                        $imageFile->move(
                            $this->getParameter('logements_directory'),
                            $newFilename
                        );
                    } catch (FileException $e) {
                        // handle exception if something happens during file upload
                    }

                    $media = new Media();
                    $media->setNomFichier($newFilename);
                    $media->setType('image');
                    $media->setTypeMime($imageFile->getClientMimeType() ?? 'image/jpeg');
                    $media->setPosition(0);
                    $media->setLogement($logement);
                    $em->persist($media);
                }
            }

            $em->flush();
            $this->addFlash('success', '✅ Logement mis à jour !');
            return $this->redirectToRoute('owner_logements');
        }

        return $this->render('dashboard/owner/logement_form.html.twig', [
            'form' => $form,
            'titrePage' => 'Modifier : ' . $logement->getTitre(),
            'logement' => $logement,
        ]);
    }

    // =============================================
    // SUPPRIMER UN LOGEMENT
    // =============================================
    #[Route('/proprietaire/logement/{id}/supprimer', name: 'owner_logement_delete', methods: ['POST'])]
    public function delete(Logement $logement, Request $request, EntityManagerInterface $em): Response
    {
        if ($logement->getProprietaire() !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }

        if ($this->isCsrfTokenValid('delete' . $logement->getId(), $request->request->get('_token'))) {
            $em->remove($logement);
            $em->flush();
            $this->addFlash('success', 'Logement supprimé.');
        }

        return $this->redirectToRoute('owner_logements');
    }

    // =============================================
    // RÉSERVATIONS REÇUES
    // =============================================
    #[Route('/proprietaire/reservations', name: 'owner_reservations')]
    public function reservations(ReservationRepository $repo): Response
    {
        return $this->render('dashboard/owner/reservations.html.twig', [
            'reservations' => $repo->findByProprietaire($this->getUser()),
        ]);
    }

    // =============================================
    // ACCEPTER UNE RÉSERVATION
    // =============================================
    #[Route('/proprietaire/reservation/{id}/accepter', name: 'owner_reservation_accepter', methods: ['POST'])]
    public function accepterReservation(
        \App\Entity\Reservation $reservation,
        EntityManagerInterface $em
    ): Response {
        if ($reservation->getLogement()->getProprietaire() !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }

        $reservation->setStatut('confirme');
        $reservation->setConfirmeLe(new \DateTime());
        $em->flush();

        $this->addFlash('success', '✅ Réservation confirmée !');
        return $this->redirectToRoute('owner_reservations');
    }

    // =============================================
    // REFUSER UNE RÉSERVATION
    // =============================================
    #[Route('/proprietaire/reservation/{id}/refuser', name: 'owner_reservation_refuser', methods: ['POST'])]
    public function refuserReservation(
        \App\Entity\Reservation $reservation,
        EntityManagerInterface $em
    ): Response {
        if ($reservation->getLogement()->getProprietaire() !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }

        $reservation->setStatut('annule');
        $reservation->setAnnuleLe(new \DateTime());
        $em->flush();

        $this->addFlash('success', 'Réservation refusée.');
        return $this->redirectToRoute('owner_reservations');
    }

    // =============================================
    // REVENUS
    // =============================================
    #[Route('/proprietaire/revenus', name: 'owner_revenus')]
    public function revenus(ReservationRepository $repo): Response
    {
        $reservations = $repo->findByProprietaire($this->getUser());
        $terminees = array_filter($reservations, fn($r) => $r->getStatut() === 'termine');

        return $this->render('dashboard/owner/revenus.html.twig', [
            'reservations' => $terminees,
            'total' => $repo->getTotalRevenusProprietaire($this->getUser()),
        ]);
    }

    // =============================================
    // AVIS REÇUS
    // =============================================
    #[Route('/proprietaire/avis', name: 'owner_avis')]
    public function avis(AvisRepository $repo): Response
    {
        return $this->render('dashboard/owner/avis.html.twig', [
            'avis' => $repo->findByProprietaire($this->getUser()),
            'noteMoyenne' => $repo->getNoteMoyenneProprietaire($this->getUser()),
        ]);
    }

    // =============================================
    // RÉPONDRE À UN AVIS
    // =============================================
    #[Route('/proprietaire/avis/{id}/repondre', name: 'owner_avis_repondre', methods: ['POST'])]
    public function repondreAvis(
        \App\Entity\Avis $avis,
        Request $request,
        EntityManagerInterface $em
    ): Response {
        if ($avis->getLogement()->getProprietaire() !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }

        $reponse = $request->request->get('reponse');
        if ($reponse) {
            $avis->setReponseProprietaire($reponse);
            $em->flush();
            $this->addFlash('success', 'Réponse publiée !');
        }

        return $this->redirectToRoute('owner_avis');
    }

    // =============================================
    // MON PROFIL
    // =============================================
    #[Route('/proprietaire/profil', name: 'owner_profil')]
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
                    return $this->redirectToRoute('owner_profil');
                }
            }

            $em->flush();
            $this->addFlash('success', 'Profil mis à jour !');
            return $this->redirectToRoute('owner_profil');
        }

        return $this->render('dashboard/owner/profil.html.twig', [
            'user' => $user,
        ]);
    }
}