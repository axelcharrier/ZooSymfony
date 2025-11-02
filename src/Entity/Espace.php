<?php

namespace App\Entity;

use App\Repository\EspaceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EspaceRepository::class)]
class Espace
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column]
    private ?int $superficie = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $date_ouverture = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $date_fermeture = null;

    /**
     * @var Collection<int, Enclo>
     */
    #[ORM\OneToMany(targetEntity: Enclo::class, mappedBy: 'id_espace')]
    private Collection $enclos;

    public function __construct()
    {
        $this->enclos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
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

    public function getDateOuverture(): ?\DateTime
    {
        return $this->date_ouverture;
    }

    public function setDateOuverture(?\DateTime $date_ouverture): static
    {
        $this->date_ouverture = $date_ouverture;

        return $this;
    }

    public function getDateFermeture(): ?\DateTime
    {
        return $this->date_fermeture;
    }

    public function setDateFermeture(?\DateTime $date_fermeture): static
    {
        $this->date_fermeture = $date_fermeture;

        return $this;
    }

    /**
     * @return Collection<int, Enclo>
     */
    public function getEnclos(): Collection
    {
        return $this->enclos;
    }

    public function addEnclo(Enclo $enclo): static
    {
        if (!$this->enclos->contains($enclo)) {
            $this->enclos->add($enclo);
            $enclo->setIdEspace($this);
        }

        return $this;
    }

    public function removeEnclo(Enclo $enclo): static
    {
        if ($this->enclos->removeElement($enclo)) {
            // set the owning side to null (unless already changed)
            if ($enclo->getIdEspace() === $this) {
                $enclo->setIdEspace(null);
            }
        }

        return $this;
    }
}
