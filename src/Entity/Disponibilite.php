<?php

namespace App\Entity;

use App\Repository\DisponibiliteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping\PrePersist;

#[ORM\Entity(repositoryClass: DisponibiliteRepository::class)]
class Disponibilite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'disponibilites')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Logement $logement = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotNull]
    private ?\DateTime $date = null;

    #[ORM\Column]
    private ?bool $estDisponible = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    #[Assert\PositiveOrZero]
    private ?string $prixPersonnalise = null;

    #[PrePersist]
    public function doPrePersist(): void
    {
        $this->estDisponible = true;
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    public function setDate(\DateTime $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function isEstDisponible(): ?bool
    {
        return $this->estDisponible;
    }

    public function setEstDisponible(bool $estDisponible): static
    {
        $this->estDisponible = $estDisponible;

        return $this;
    }

    public function getPrixPersonnalise(): ?string
    {
        return $this->prixPersonnalise;
    }

    public function setPrixPersonnalise(?string $prixPersonnalise): static
    {
        $this->prixPersonnalise = $prixPersonnalise;

        return $this;
    }
}
