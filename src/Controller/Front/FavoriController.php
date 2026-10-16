<?php
// src/Controller/Front/FavoriController.php

namespace App\Controller\Front;

use App\Entity\Favori;
use App\Entity\Logement;
use App\Repository\FavoriRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class FavoriController extends AbstractController
{
    #[Route('/favori/toggle/{id}', name: 'app_favori_toggle', methods: ['POST'])]
    #[IsGranted('ROLE_USER')]
    public function toggle(
        Logement $logement,
        FavoriRepository $favoriRepo,
        EntityManagerInterface $em,
        Request $request
    ): JsonResponse {
        $user = $this->getUser();

        $existingFavori = $favoriRepo->findOneBy([
            'voyageur' => $user,
            'logement' => $logement,
        ]);

        if ($existingFavori) {
            $em->remove($existingFavori);
            $em->flush();
            return new JsonResponse(['status' => 'removed']);
        }

        $favori = new Favori();
        $favori->setVoyageur($user)
               ->setLogement($logement)
               ->setAjouteLe(new \DateTime());

        $em->persist($favori);
        $em->flush();

        return new JsonResponse(['status' => 'added']);
    }
}
