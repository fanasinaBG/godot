<?php

namespace App\Entity;

use App\Repository\RecetteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: RecetteRepository::class)]
class Recette
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Plat $idPlat = null;

    #[ORM\Column]
    private ?int $temps = null;

    /**
     * @var Collection<int, Vilany>
     */
    #[ORM\OneToMany(targetEntity: Vilany::class, mappedBy: 'recette')]
    private Collection $idVilany;

    /**
     * @var Collection<int, RelationIngredientRecette>
     */
    #[ORM\OneToMany(targetEntity: RelationIngredientRecette::class, mappedBy: 'recette')]
    private Collection $relationIngredientRecettes;

    #[ORM\OneToOne(mappedBy: 'idRecette', cascade: ['persist', 'remove'])]
    private ?Plat $plat = null;

    public function __construct()
    {
        $this->idVilany = new ArrayCollection();
        $this->relationIngredientRecettes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdPlat(): ?Plat
    {
        return $this->idPlat;
    }

    public function setIdPlat(?Plat $idPlat): static
    {
        $this->idPlat = $idPlat;
        return $this;
    }

    public function getTemps(): ?int
    {
        return $this->temps;
    }

    public function setTemps(int $temps): static
    {
        $this->temps = $temps;
        return $this;
    }

    /**
     * @return Collection<int, Vilany>
     */
    public function getIdVilany(): Collection
    {
        return $this->idVilany;
    }

    public function addIdVilany(Vilany $idVilany): static
    {
        if (!$this->idVilany->contains($idVilany)) {
            $this->idVilany->add($idVilany);
            $idVilany->setRecette($this);
        }

        return $this;
    }

    public function removeIdVilany(Vilany $idVilany): static
    {
        if ($this->idVilany->removeElement($idVilany)) {
            if ($idVilany->getRecette() === $this) {
                $idVilany->setRecette(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, RelationIngredientRecette>
     */
    public function getRelationIngredientRecettes(): Collection
    {
        return $this->relationIngredientRecettes;
    }

    public function addRelationIngredientRecette(RelationIngredientRecette $relationIngredientRecette): static
    {
        if (!$this->relationIngredientRecettes->contains($relationIngredientRecette)) {
            $this->relationIngredientRecettes->add($relationIngredientRecette);
            $relationIngredientRecette->setRecette($this);
        }

        return $this;
    }

    public function removeRelationIngredientRecette(RelationIngredientRecette $relationIngredientRecette): static
    {
        if ($this->relationIngredientRecettes->removeElement($relationIngredientRecette)) {
            if ($relationIngredientRecette->getRecette() === $this) {
                $relationIngredientRecette->setRecette(null);
            }
        }

        return $this;
    }

    public function getPlat(): ?Plat
    {
        return $this->plat;
    }

    public function setPlat(?Plat $plat): static
    {
        if ($plat === null && $this->plat !== null) {
            $this->plat->setIdRecette(null);
        }

        if ($plat !== null && $plat->getIdRecette() !== $this) {
            $plat->setIdRecette($this);
        }

        $this->plat = $plat;

        return $this;
    }
}
