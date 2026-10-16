<?php
// src/Controller/Front/SearchController.php

namespace App\Controller\Front;

use App\Repository\LogementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SearchController extends AbstractController
{
    #[Route('/recherche', name: 'app_search')]
    public function index(Request $request, LogementRepository $repo): Response
    {
        $ville = $request->query->get('ville');
        $type = $request->query->get('type');
        $checkIn = $request->query->get('check_in');
        $checkOut = $request->query->get('check_out');
        $nbVoyageurs = $request->query->getInt('voyageurs', 1);
        $prixMin = $request->query->get('prix_min');
        $prixMax = $request->query->get('prix_max');
        $tri = $request->query->get('tri', 'recent');

        $logements = $repo->recherche([
            'ville' => $ville,
            'type' => $type,
            'voyageurs' => $nbVoyageurs,
            'prix_min' => $prixMin,
            'prix_max' => $prixMax,
            'tri' => $tri,
        ]);

        return $this->render('front/search.html.twig', [
            'logements' => $logements,
            'total' => count($logements),
            'ville' => $ville,
            'type' => $type,
            'checkIn' => $checkIn,
            'checkOut' => $checkOut,
            'nbVoyageurs' => $nbVoyageurs,
            'prixMin' => $prixMin,
            'prixMax' => $prixMax,
            'tri' => $tri,
        ]);
    }
}