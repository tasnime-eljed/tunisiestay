<?php

namespace App\Entity;

use App\Repository\AvisRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AvisRepository::class)]
class Avis
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'avis')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateur $voyageur = null;

    #[ORM\ManyToOne(inversedBy: 'avis')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Logement $logement = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: true)]
    private ?Reservation $reservation = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $note = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $commentaire = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $noteNettete = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $noteEmplacement = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $noteRapportQualite = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $reponseProprietaire = null;

    #[ORM\Column]
    private ?bool $estVisible = null;

    #[ORM\Column]
    private ?\DateTime $creeLe = null;

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

    public function getReservation(): ?Reservation
    {
        return $this->reservation;
    }

    public function setReservation(Reservation $reservation): static
    {
        $this->reservation = $reservation;

        return $this;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(int $note): static
    {
        $this->note = $note;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(?string $commentaire): static
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getNoteNettete(): ?int
    {
        return $this->noteNettete;
    }

    public function setNoteNettete(?int $noteNettete): static
    {
        $this->noteNettete = $noteNettete;

        return $this;
    }

    public function getNoteEmplacement(): ?int
    {
        return $this->noteEmplacement;
    }

    public function setNoteEmplacement(?int $noteEmplacement): static
    {
        $this->noteEmplacement = $noteEmplacement;

        return $this;
    }

    public function getNoteRapportQualite(): ?int
    {
        return $this->noteRapportQualite;
    }

    public function setNoteRapportQualite(?int $noteRapportQualite): static
    {
        $this->noteRapportQualite = $noteRapportQualite;

        return $this;
    }

    public function getReponseProprietaire(): ?string
    {
        return $this->reponseProprietaire;
    }

    public function setReponseProprietaire(?string $reponseProprietaire): static
    {
        $this->reponseProprietaire = $reponseProprietaire;

        return $this;
    }

    public function isEstVisible(): ?bool
    {
        return $this->estVisible;
    }

    public function setEstVisible(bool $estVisible): static
    {
        $this->estVisible = $estVisible;

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
