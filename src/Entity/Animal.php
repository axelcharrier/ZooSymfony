<?php

namespace App\Entity;

use App\Repository\AnimalRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnimalRepository::class)]
class Animal
{
    #[ORM\Id]
    #[ORM\Column(type: 'bigint')]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nom = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $date_naissance = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $date_arrive = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $date_depart = null;

    #[ORM\Column(length: 50)]
    private ?string $genre = null;

    #[ORM\Column(length: 255)]
    private ?string $espece = null;

    #[ORM\Column]
    private ?bool $sterilise = null;

    #[ORM\Column]
    private ?bool $quarantaine = null;

    #[ORM\ManyToOne(inversedBy: 'animals')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Enclo $id_enclo = null;

    public function __construct()
    {
        $this->date_arrive = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDateNaissance(): ?\DateTime
    {
        return $this->date_naissance;
    }

    public function setDateNaissance(?\DateTime $date_naissance): static
    {
        $this->date_naissance = $date_naissance;

        return $this;
    }

    public function getDateArrive(): ?\DateTime
    {
        return $this->date_arrive;
    }

    public function setDateArrive(\DateTime $date_arrive): static
    {
        $this->date_arrive = $date_arrive;

        return $this;
    }

    public function getDateDepart(): ?\DateTime
    {
        return $this->date_depart;
    }

    public function setDateDepart(?\DateTime $date_depart): static
    {
        $this->date_depart = $date_depart;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): static
    {
        $this->genre = $genre;

        return $this;
    }

    public function getEspece(): ?string
    {
        return $this->espece;
    }

    public function setEspece(string $espece): static
    {
        $this->espece = $espece;

        return $this;
    }

    public function isSterilise(): ?bool
    {
        return $this->sterilise;
    }

    public function setSterilise(bool $sterilise): static
    {
        $this->sterilise = $sterilise;

        return $this;
    }

    public function isQuarantaine(): ?bool
    {
        return $this->quarantaine;
    }

    public function setQuarantaine(bool $quarantaine): static
    {
        $this->quarantaine = $quarantaine;

        return $this;
    }

    public function getIdEnclo(): ?Enclo
    {
        return $this->id_enclo;
    }

    public function setIdEnclo(?Enclo $id_enclo): static
    {
        $this->id_enclo = $id_enclo;

        return $this;
    }
}
