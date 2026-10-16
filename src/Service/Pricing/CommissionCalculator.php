<?php
// src/Service/Pricing/CommissionCalculator.php

namespace App\Service\Pricing;

use App\Repository\ConfigCommissionRepository;

class CommissionCalculator
{
    public function __construct(
        private readonly ConfigCommissionRepository $repo
    ) {
    }

    public function calculer(float $montantBase): array
    {
        $config = $this->repo->findOneBy(['estActive' => true]);
        $taux = $config ? (float) $config->getTaux() : 12.0;

        $commission = round($montantBase * $taux / 100, 2);
        $total = round($montantBase + $commission, 2);

        return [
            'base' => $montantBase,
            'taux' => $taux,
            'commission' => $commission,
            'total' => $total,
        ];
    }
}