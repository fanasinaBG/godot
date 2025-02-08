<?php
// StockIngredient.php
namespace App\Entity;

use App\Repository\StockIngredientRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: StockIngredientRepository::class)]
class StockIngredient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['stock:read','stock:liste'])]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Ingredient::class, inversedBy: 'stockIngredients')]
#[ORM\JoinColumn(name: 'ingredient_id', referencedColumnName: 'id')]
    #[Groups(['stock:liste'])]
    private ?Ingredient $ingredient = null; // Changement de la relation ManyToMany à ManyToOne

    #[ORM\Column]
    #[Groups(['stock:read','stock:liste'])]
    private ?int $Entre = null;

    #[ORM\Column]
    #[Groups(['stock:read','stock:liste'])]
    private ?int $Sortie = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIngredient(): ?Ingredient
    {
        return $this->ingredient;
    }

    public function setIngredient(?Ingredient $ingredient): self
    {
        $this->ingredient = $ingredient;

        return $this;
    }

    public function getEntre(): ?int
    {
        return $this->Entre;
    }

    public function setEntre(int $Entre): static
    {
        $this->Entre = $Entre;

        return $this;
    }

    public function getSortie(): ?int
    {
        return $this->Sortie;
    }

    public function setSortie(int $Sortie): static
    {
        $this->Sortie = $Sortie;

        return $this;
    }
}
