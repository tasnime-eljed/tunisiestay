<?php

namespace App\Twig;

use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class CurrencyExtension extends AbstractExtension
{
    public function __construct(
        private RequestStack $requestStack
    ) {}

    public function getFilters(): array
    {
        return [
            new TwigFilter('format_price', [$this, 'formatPrice']),
        ];
    }

    public function formatPrice($amount, string $originalCurrency = 'TND'): string
    {
        $session = $this->requestStack->getSession();
        $targetCurrency = $session->get('_currency', 'TND');

        $amount = (float) $amount;

        // Taux de conversion fixe pour la démo (1 EUR = 3.4 TND)
        $rate = 3.4;

        if ($originalCurrency === 'TND' && $targetCurrency === 'EUR') {
            $amount = $amount / $rate;
        } elseif ($originalCurrency === 'EUR' && $targetCurrency === 'TND') {
            $amount = $amount * $rate;
        }

        if ($targetCurrency === 'EUR') {
            return number_format($amount, 2, '.', ' ') . ' €';
        }

        return number_format($amount, 2, '.', ' ') . ' TND';
    }
}
