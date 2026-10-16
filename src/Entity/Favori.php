<?php

namespace App\Entity;

use App\Repository\FavoriRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FavoriRepository::class)]
class Favori
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'favoris')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateur $voyageur = null;

    #[ORM\ManyToOne(inversedBy: 'favoris')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Logement $logement = null;

    #[ORM\Column]
    private ?\DateTime $ajoute_le = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVoyageur(): ?Utilisateur
    {
        return $this->voyageur;
    }

    public function setVoyageur(?Utilisateur $voyageur): static
    {
        $this->voyageur = $voyageur;

        return $this;
    }

    public function getLogement(): ?Logement
    {
        return $this->logement;
    }

    public function setLogement(?Logement $logement): static
    {
        $this->logement = $logement;

        return $this;
    }

    public function getAjouteLe(): ?\DateTime
    {
        return $this->ajoute_le;
    }

    public function setAjouteLe(\DateTime $ajoute_le): static
    {
        $this->ajoute_le = $ajoute_le;

        return $this;
    }
}
