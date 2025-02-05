<?php

namespace App\Entity;

use App\Repository\IngredientRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IngredientRepository::class)]
class Ingredient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\ManyToOne(inversedBy: 'idIngredient')]
    private ?RelationIngredientRecette $relationIngredientRecette = null;

    #[ORM\ManyToOne(inversedBy: 'idIngredient')]
    private ?StockIngredient $stockIngredient = null;

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

    public function getRelationIngredientRecette(): ?RelationIngredientRecette
    {
        return $this->relationIngredientRecette;
    }

    public function setRelationIngredientRecette(?RelationIngredientRecette $relationIngredientRecette): static
    {
        $this->relationIngredientRecette = $relationIngredientRecette;

        return $this;
    }

    public function getStockIngredient(): ?StockIngredient
    {
        return $this->stockIngredient;
    }

    public function setStockIngredient(?StockIngredient $stockIngredient): static
    {
        $this->stockIngredient = $stockIngredient;

        return $this;
    }
}
