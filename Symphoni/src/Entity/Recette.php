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
    private ?plat $idPlat = null;

    #[ORM\Column]
    private ?int $temps = null;

    /**
     * @var Collection<int, vilany>
     */
    #[ORM\OneToMany(targetEntity: vilany::class, mappedBy: 'recette')]
    private Collection $idVilany;

    #[ORM\ManyToOne(inversedBy: 'idRecette')]
    private ?RelationIngredientRecette $relationIngredientRecette = null;

    #[ORM\OneToOne(mappedBy: 'idRecette', cascade: ['persist', 'remove'])]
    private ?Plat $plat = null;

    public function __construct()
    {
        $this->idVilany = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdPlat(): ?plat
    {
        return $this->idPlat;
    }

    public function setIdPlat(?plat $idPlat): static
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
     * @return Collection<int, vilany>
     */
    public function getIdVilany(): Collection
    {
        return $this->idVilany;
    }

    public function addIdVilany(vilany $idVilany): static
    {
        if (!$this->idVilany->contains($idVilany)) {
            $this->idVilany->add($idVilany);
            $idVilany->setRecette($this);
        }

        return $this;
    }

    public function removeIdVilany(vilany $idVilany): static
    {
        if ($this->idVilany->removeElement($idVilany)) {
            // set the owning side to null (unless already changed)
            if ($idVilany->getRecette() === $this) {
                $idVilany->setRecette(null);
            }
        }

        return $this;
    }

    public function getRelationIngredientRecette(): ?RelationIngredientRecette
    {
        return $this->relationIngredientRecette;
    }

    public function setRelationIngredientRecette(?RelationIngredientRecette $relationIngredientRecette): static
    {
        $this->relationIngredientRecette = $relationIngredientRecette;

        return $this;
    }

    public function getPlat(): ?Plat
    {
        return $this->plat;
    }

    public function setPlat(?Plat $plat): static
    {
        // unset the owning side of the relation if necessary
        if ($plat === null && $this->plat !== null) {
            $this->plat->setIdRecette(null);
        }

        // set the owning side of the relation if necessary
        if ($plat !== null && $plat->getIdRecette() !== $this) {
            $plat->setIdRecette($this);
        }

        $this->plat = $plat;

        return $this;
    }
}
