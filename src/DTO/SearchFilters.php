<?php

namespace App\DTO;

class SearchFilters
{
    public ?string $ville = null;
    public ?\DateTime $checkIn = null;
    public ?\DateTime $checkOut = null;
    public int $nbVoyageurs = 1;
    public ?float $prixMin = null;
    public ?float $prixMax = null;
    public ?string $type = null;
    public string $sortBy = 'prix_asc';
    public int $page = 1;
}