<?php
// src/Controller/LocaleController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LocaleController extends AbstractController
{
    #[Route('/langue/{locale}', name: 'app_change_locale', requirements: ['locale' => 'fr|en|ar'])]
    public function changeLocale(string $locale, Request $request): Response
    {
        $request->getSession()->set('_locale', $locale);
        return $this->redirect($request->headers->get('referer', '/'));
    }

    #[Route('/devise/{currency}', name: 'app_change_currency', requirements: ['currency' => 'EUR|TND'])]
    public function changeCurrency(string $currency, Request $request): Response
    {
        $request->getSession()->set('_currency', $currency);
        return $this->redirect($request->headers->get('referer', '/'));
    }
}