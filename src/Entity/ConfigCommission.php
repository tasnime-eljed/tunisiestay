<?php

namespace App\Entity;

use App\Repository\ConfigCommissionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping\PrePersist;

#[ORM\Entity(repositoryClass: ConfigCommissionRepository::class)]
#[ORM\HasLifecycleCallbacks]
class ConfigCommission
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    #[Assert\NotBlank]
    #[Assert\Range(min: 0, max: 100)]
    private ?string $taux = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $montantMin = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $montantMax = null;

    #[ORM\Column]
    private ?bool $estActive = null;

    #[ORM\Column]
    private ?\DateTime $creeLe = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTaux(): ?string
    {
        return $this->taux;
    }

    public function setTaux(string $taux): static
    {
        $this->taux = $taux;

        return $this;
    }

    public function getMontantMin(): ?string
    {
        return $this->montantMin;
    }

    public function setMontantMin(?string $montantMin): static
    {
        $this->montantMin = $montantMin;

        return $this;
    }

    public function getMontantMax(): ?string
    {
        return $this->montantMax;
    }

    public function setMontantMax(?string $montantMax): static
    {
        $this->montantMax = $montantMax;

        return $this;
    }

    #[PrePersist]
    public function doPrePersist(): void
    {
        $this->creeLe = new \DateTime();
        $this->estActive = true;
    }

    public function isEstActive(): ?bool
    {
        return $this->estActive;
    }

    public function setEstActive(bool $estActive): static
    {
        $this->estActive = $estActive;

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
}
