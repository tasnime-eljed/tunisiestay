<?php
// src/Controller/Front/HomeController.php

namespace App\Controller\Front;

use App\Repository\LogementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(LogementRepository $repo): Response
    {
        $logements = $repo->findBy(
            ['statut' => 'publie'],
            ['creeLe' => 'DESC'],
            6
        );

        $destinationsPopulaires = $repo->findPopularDestinations(4);

        return $this->render('front/home.html.twig', [
            'logements' => $logements,
            'destinationsPopulaires' => $destinationsPopulaires,
        ]);
    }
}