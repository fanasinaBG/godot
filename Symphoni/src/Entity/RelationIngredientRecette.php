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
     * @var Collection<int, Ingredient>
     */
    #[ORM\ManyToOne(targetEntity: Ingredient::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Ingredient $idIngredient = null;  // Une seule relation à Ingredient ici

    /**
     * @var Collection<int, Recette>
     */
    #[ORM\ManyToOne(targetEntity: Recette::class)]  // Modifié pour référencer Recette
    #[ORM\JoinColumn(nullable: false)]
    private ?Recette $idRecette = null;  // L'association correcte avec Recette

    #[ORM\Column]
    private ?int $nombre = null;

    public function __construct()
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdIngredient(): ?Ingredient
    {
        return $this->idIngredient;
    }

    public function setIdIngredient(Ingredient $idIngredient): static
    {
        $this->idIngredient = $idIngredient;

        return $this;
    }

    public function getIdRecette(): ?Recette
    {
        return $this->idRecette;
    }

    public function setIdRecette(Recette $idRecette): static
    {
        $this->idRecette = $idRecette;

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

    public function addIdIngredient(Ingredient $ingredient): static
    {
        $this->idIngredient = $ingredient;  // L'affectation ici est une seule entité, pas une collection
        return $this;
    }
}
