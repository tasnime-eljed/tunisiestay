<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping\PrePersist;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateur $voyageur = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Logement $logement = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotNull]
    private ?\DateTime $dateArrivee = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotNull]
    #[Assert\GreaterThan(propertyPath: "dateArrivee")]
    private ?\DateTime $dateDepart = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $nbVoyageurs = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $nbNuits = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    #[Assert\NotBlank]
    #[Assert\Positive]
    private ?string $montantBase = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $tauxCommission = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $montantCommission = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $montantTotal = null;

    #[ORM\Column(length: 3)]
    private ?string $devise = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $montantEnEur = null;

    #[ORM\Column(length: 20)]
    private ?string $statut = null;

    #[ORM\Column]
    private ?\DateTime $creeLe = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $confirmeLe = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $annuleLe = null;

    #[PrePersist]
    public function doPrePersist(): void
    {
        $this->creeLe = new \DateTime();
    }

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

    public function getDateArrivee(): ?\DateTime
    {
        return $this->dateArrivee;
    }

    public function setDateArrivee(\DateTime $dateArrivee): static
    {
        $this->dateArrivee = $dateArrivee;

        return $this;
    }

    public function getDateDepart(): ?\DateTime
    {
        return $this->dateDepart;
    }

    public function setDateDepart(\DateTime $dateDepart): static
    {
        $this->dateDepart = $dateDepart;

        return $this;
    }

    public function getNbVoyageurs(): ?int
    {
        return $this->nbVoyageurs;
    }

    public function setNbVoyageurs(int $nbVoyageurs): static
    {
        $this->nbVoyageurs = $nbVoyageurs;

        return $this;
    }

    public function getNbNuits(): ?int
    {
        return $this->nbNuits;
    }

    public function setNbNuits(int $nbNuits): static
    {
        $this->nbNuits = $nbNuits;

        return $this;
    }

    public function getMontantBase(): ?string
    {
        return $this->montantBase;
    }

    public function setMontantBase(string $montantBase): static
    {
        $this->montantBase = $montantBase;

        return $this;
    }

    public function getTauxCommission(): ?string
    {
        return $this->tauxCommission;
    }

    public function setTauxCommission(string $tauxCommission): static
    {
        $this->tauxCommission = $tauxCommission;

        return $this;
    }

    public function getMontantCommission(): ?string
    {
        return $this->montantCommission;
    }

    public function setMontantCommission(string $montantCommission): static
    {
        $this->montantCommission = $montantCommission;

        return $this;
    }

    public function getMontantTotal(): ?string
    {
        return $this->montantTotal;
    }

    public function setMontantTotal(string $montantTotal): static
    {
        $this->montantTotal = $montantTotal;

        return $this;
    }

    public function getDevise(): ?string
    {
        return $this->devise;
    }

    public function setDevise(string $devise): static
    {
        $this->devise = $devise;

        return $this;
    }

    public function getMontantEnEur(): ?string
    {
        return $this->montantEnEur;
    }

    public function setMontantEnEur(?string $montantEnEur): static
    {
        $this->montantEnEur = $montantEnEur;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): static
    {
        $this->statut = $statut;

        return $this;
    }

    public function getCreeLe(): ?\DateTime
    {
        return $this->creeLe;
    }

    public function setCreeLe(\DateTime $creeLe): static
    {
        $this->creeLe = $creeLe;

        return $this;
    }

    public function getConfirmeLe(): ?\DateTime
    {
        return $this->confirmeLe;
    }

    public function setConfirmeLe(?\DateTime $confirmeLe): static
    {
        $this->confirmeLe = $confirmeLe;

        return $this;
    }

    public function getAnnuleLe(): ?\DateTime
    {
        return $this->annuleLe;
    }

    public function setAnnuleLe(?\DateTime $annuleLe): static
    {
        $this->annuleLe = $annuleLe;

        return $this;
    }
}
