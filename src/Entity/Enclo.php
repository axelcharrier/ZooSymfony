<?php

namespace App\Entity;

use App\Repository\EncloRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EncloRepository::class)]
class Enclo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nom = null;

    #[ORM\Column]
    private ?int $superficie = null;

    #[ORM\Column]
    private ?int $capacite = null;

    #[ORM\Column]
    private ?bool $quarantaine = null;

    /**
     * @var Collection<int, Animal>
     */
    #[ORM\OneToMany(targetEntity: Animal::class, mappedBy: 'id_enclo')]
    private Collection $animals;

    #[ORM\ManyToOne(inversedBy: 'enclos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Espace $id_espace = null;

    public function __construct()
    {
        $this->animals = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getSuperficie(): ?int
    {
        return $this->superficie;
    }

    public function setSuperficie(int $superficie): static
    {
        $this->superficie = $superficie;

        return $this;
    }

    public function getCapacite(): ?int
    {
        return $this->capacite;
    }

    public function setCapacite(int $capacite): static
    {
        $this->capacite = $capacite;

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

    /**
     * @return Collection<int, Animal>
     */
    public function getAnimals(): Collection
    {
        return $this->animals;
    }

    public function addAnimal(Animal $animal): static
    {
        if (!$this->animals->contains($animal)) {
            $this->animals->add($animal);
            $animal->setIdEnclo($this);
        }

        return $this;
    }

    public function removeAnimal(Animal $animal): static
    {
        if ($this->animals->removeElement($animal)) {
            // set the owning side to null (unless already changed)
            if ($animal->getIdEnclo() === $this) {
                $animal->setIdEnclo(null);
            }
        }

        return $this;
    }

    public function getIdEspace(): ?Espace
    {
        return $this->id_espace;
    }

    public function setIdEspace(?Espace $id_espace): static
    {
        $this->id_espace = $id_espace;

        return $this;
    }
}
