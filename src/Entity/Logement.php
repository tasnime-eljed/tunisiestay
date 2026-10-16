<?php

namespace App\Entity;

use App\Repository\LogementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping\PrePersist;
use Doctrine\ORM\Mapping\PreUpdate;

#[ORM\Entity(repositoryClass: LogementRepository::class)]
class Logement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'logements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateur $proprietaire = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $titre = null;

    #[ORM\Column(length: 280)]
    private ?string $slug = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 50)]
    private ?string $type = null;

    #[ORM\Column(length: 30)]
    private ?string $statut = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    #[Assert\NotBlank]
    #[Assert\Positive]
    private ?string $prixParNuit = null;

    #[ORM\Column(length: 3)]
    private ?string $devise = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $maxVoyageurs = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $chambres = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $sallesDeBain = null;

    #[ORM\Column(nullable: true)]
    private ?float $latitude = null;

    #[ORM\Column(nullable: true)]
    private ?float $longitude = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $adresse = null;

    #[ORM\Column(length: 100)]
    private ?string $ville = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $region = null;

    #[ORM\Column]
    private ?\DateTime $creeLe = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $modifieLe = null;

    /**
     * @var Collection<int, Equipement>
     */
    #[ORM\ManyToMany(targetEntity: Equipement::class, mappedBy: 'logements')]
    private Collection $equipements;

    /**
     * @var Collection<int, Media>
     */
    #[ORM\OneToMany(targetEntity: Media::class, mappedBy: 'logement', orphanRemoval: true)]
    private Collection $media;

    /**
     * @var Collection<int, Disponibilite>
     */
    #[ORM\OneToMany(targetEntity: Disponibilite::class, mappedBy: 'logement')]
    private Collection $disponibilites;

    /**
     * @var Collection<int, Reservation>
     */
    #[ORM\OneToMany(targetEntity: Reservation::class, mappedBy: 'logement')]
    private Collection $reservations;

    /**
     * @var Collection<int, Avis>
     */
    #[ORM\OneToMany(targetEntity: Avis::class, mappedBy: 'logement')]
    private Collection $avis;

    /**
     * @var Collection<int, Favori>
     */
    #[ORM\OneToMany(targetEntity: Favori::class, mappedBy: 'logement')]
    private Collection $favoris;

    #[PrePersist]
    public function doPrePersist(): void
    {
        $this->creeLe = new \DateTime();
        $this->modifieLe = new \DateTime();
    }

    #[PreUpdate]
    public function doPreUpdate(): void
    {
        $this->modifieLe = new \DateTime();
    }

    public function __construct()
    {
        $this->equipements = new ArrayCollection();
        $this->media = new ArrayCollection();
        $this->disponibilites = new ArrayCollection();
        $this->reservations = new ArrayCollection();
        $this->avis = new ArrayCollection();
        $this->favoris = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProprietaire(): ?Utilisateur
    {
        return $this->proprietaire;
    }

    public function setProprietaire(?Utilisateur $proprietaire): static
    {
        $this->proprietaire = $proprietaire;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

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

    public function getPrixParNuit(): ?string
    {
        return $this->prixParNuit;
    }

    public function setPrixParNuit(string $prixParNuit): static
    {
        $this->prixParNuit = $prixParNuit;

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

    public function getMaxVoyageurs(): ?int
    {
        return $this->maxVoyageurs;
    }

    public function setMaxVoyageurs(int $maxVoyageurs): static
    {
        $this->maxVoyageurs = $maxVoyageurs;

        return $this;
    }

    public function getChambres(): ?int
    {
        return $this->chambres;
    }

    public function setChambres(int $chambres): static
    {
        $this->chambres = $chambres;

        return $this;
    }

    public function getSallesDeBain(): ?int
    {
        return $this->sallesDeBain;
    }

    public function setSallesDeBain(int $sallesDeBain): static
    {
        $this->sallesDeBain = $sallesDeBain;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(?float $latitude): static
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(?float $longitude): static
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): static
    {
        $this->ville = $ville;

        return $this;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(?string $region): static
    {
        $this->region = $region;

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

    public function getModifieLe(): ?\DateTime
    {
        return $this->modifieLe;
    }

    public function setModifieLe(?\DateTime $modifieLe): static
    {
        $this->modifieLe = $modifieLe;

        return $this;
    }

    /**
     * @return Collection<int, Equipement>
     */
    public function getEquipements(): Collection
    {
        return $this->equipements;
    }

    public function addEquipement(Equipement $equipement): static
    {
        if (!$this->equipements->contains($equipement)) {
            $this->equipements->add($equipement);
            $equipement->addLogement($this);
        }

        return $this;
    }

    public function removeEquipement(Equipement $equipement): static
    {
        if ($this->equipements->removeElement($equipement)) {
            $equipement->removeLogement($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Media>
     */
    public function getMedia(): Collection
    {
        return $this->media;
    }

    public function addMedium(Media $medium): static
    {
        if (!$this->media->contains($medium)) {
            $this->media->add($medium);
            $medium->setLogement($this);
        }

        return $this;
    }

    public function removeMedium(Media $medium): static
    {
        if ($this->media->removeElement($medium)) {
            // set the owning side to null (unless already changed)
            if ($medium->getLogement() === $this) {
                $medium->setLogement(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Disponibilite>
     */
    public function getDisponibilites(): Collection
    {
        return $this->disponibilites;
    }

    public function addDisponibilite(Disponibilite $disponibilite): static
    {
        if (!$this->disponibilites->contains($disponibilite)) {
            $this->disponibilites->add($disponibilite);
            $disponibilite->setLogement($this);
        }

        return $this;
    }

    public function removeDisponibilite(Disponibilite $disponibilite): static
    {
        if ($this->disponibilites->removeElement($disponibilite)) {
            // set the owning side to null (unless already changed)
            if ($disponibilite->getLogement() === $this) {
                $disponibilite->setLogement(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Reservation>
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): static
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations->add($reservation);
            $reservation->setLogement($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): static
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getLogement() === $this) {
                $reservation->setLogement(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Avis>
     */
    public function getAvis(): Collection
    {
        return $this->avis;
    }

    public function addAvis(Avis $avis): static
    {
        if (!$this->avis->contains($avis)) {
            $this->avis->add($avis);
            $avis->setLogement($this);
        }

        return $this;
    }

    public function removeAvis(Avis $avis): static
    {
        if ($this->avis->removeElement($avis)) {
            // set the owning side to null (unless already changed)
            if ($avis->getLogement() === $this) {
                $avis->setLogement(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Favori>
     */
    public function getFavoris(): Collection
    {
        return $this->favoris;
    }

    public function addFavori(Favori $favori): static
    {
        if (!$this->favoris->contains($favori)) {
            $this->favoris->add($favori);
            $favori->setLogement($this);
        }

        return $this;
    }

    public function removeFavori(Favori $favori): static
    {
        if ($this->favoris->removeElement($favori)) {
            // set the owning side to null (unless already changed)
            if ($favori->getLogement() === $this) {
                $favori->setLogement(null);
            }
        }

        return $this;
    }
}
