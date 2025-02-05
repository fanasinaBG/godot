<?php

namespace App\Entity;

use App\Repository\RelationIngredientRecetteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RelationIngredientRecetteRepository::class)]
class RelationIngredientRecette
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, ingredient>
     */
    #[ORM\OneToMany(targetEntity: ingredient::class, mappedBy: 'relationIngredientRecette')]
    private Collection $idIngredient;

    /**
     * @var Collection<int, Recette>
     */
    #[ORM\OneToMany(targetEntity: Recette::class, mappedBy: 'relationIngredientRecette')]
    private Collection $idRecette;

    #[ORM\Column]
    private ?int $nombre = null;


    public function __construct()
    {
        $this->idIngredient = new ArrayCollection();
        $this->idRecette = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, ingredient>
     */
    public function getIdIngredient(): Collection
    {
        return $this->idIngredient;
    }

    public function addIdIngredient(ingredient $idIngredient): static
    {
        if (!$this->idIngredient->contains($idIngredient)) {
            $this->idIngredient->add($idIngredient);
            $idIngredient->setRelationIngredientRecette($this);
        }

        return $this;
    }

    public function removeIdIngredient(ingredient $idIngredient): static
    {
        if ($this->idIngredient->removeElement($idIngredient)) {
            // set the owning side to null (unless already changed)
            if ($idIngredient->getRelationIngredientRecette() === $this) {
                $idIngredient->setRelationIngredientRecette(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Recette>
     */
    public function getIdRecette(): Collection
    {
        return $this->idRecette;
    }

    public function addIdRecette(Recette $idRecette): static
    {
        if (!$this->idRecette->contains($idRecette)) {
            $this->idRecette->add($idRecette);
            $idRecette->setRelationIngredientRecette($this);
        }

        return $this;
    }

    public function removeIdRecette(Recette $idRecette): static
    {
        if ($this->idRecette->removeElement($idRecette)) {
            // set the owning side to null (unless already changed)
            if ($idRecette->getRelationIngredientRecette() === $this) {
                $idRecette->setRelationIngredientRecette(null);
            }
        }

        return $this;
    }

    public function getNombre(): ?int
    {
        return $this->nombre;
    }

    public function setNombre(int $nombre): static
    {
        $this->nombre = $nombre;

        return $this;
    }
}
