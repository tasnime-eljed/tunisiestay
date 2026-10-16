<?php

namespace App\Entity;

use App\Repository\PaiementRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping\PrePersist;
use Doctrine\ORM\Mapping\PreUpdate;

#[ORM\Entity(repositoryClass: PaiementRepository::class)]
class Paiement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Reservation $reservation = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    #[Assert\NotBlank]
    #[Assert\Positive]
    private ?string $montant = null;

    #[ORM\Column(length: 3)]
    private ?string $devise = null;

    #[ORM\Column(length: 255)]
    private ?string $stripeIntentionId = null;

    #[ORM\Column(length: 20)]
    #[Assert\NotBlank]
    private ?string $statut = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $payeLe = null;

    #[PrePersist]
    public function doPrePersist(): void
    {
        $this->payeLe = new \DateTime();
    }

    #[PreUpdate]
    public function doPreUpdate(): void
    {
        if ($this->statut === 'paye') {
            $this->payeLe = new \DateTime();
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReservation(): ?Reservation
    {
        return $this->reservation;
    }

    public function setReservation(Reservation $reservation): static
    {
        $this->reservation = $reservation;

        return $this;
    }

    public function getMontant(): ?string
    {
        return $this->montant;
    }

    public function setMontant(string $montant): static
    {
        $this->montant = $montant;

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

    public function getStripeIntentionId(): ?string
    {
        return $this->stripeIntentionId;
    }

    public function setStripeIntentionId(string $stripeIntentionId): static
    {
        $this->stripeIntentionId = $stripeIntentionId;

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

    public function getPayeLe(): ?\DateTime
    {
        return $this->payeLe;
    }

    public function setPayeLe(?\DateTime $payeLe): static
    {
        $this->payeLe = $payeLe;

        return $this;
    }
}
