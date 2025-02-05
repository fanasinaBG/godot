<?php

namespace App\Entity;

use App\Repository\StockIngredientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StockIngredientRepository::class)]
class StockIngredient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, ingredient>
     */
    #[ORM\OneToMany(targetEntity: ingredient::class, mappedBy: 'stockIngredient')]
    private Collection $idIngredient;

    #[ORM\Column]
    private ?int $Entre = null;

    #[ORM\Column]
    private ?int $Sortie = null;

    public function __construct()
    {
        $this->idIngredient = new ArrayCollection();
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
            $idIngredient->setStockIngredient($this);
        }

        return $this;
    }

    public function removeIdIngredient(ingredient $idIngredient): static
    {
        if ($this->idIngredient->removeElement($idIngredient)) {
            // set the owning side to null (unless already changed)
            if ($idIngredient->getStockIngredient() === $this) {
                $idIngredient->setStockIngredient(null);
            }
        }

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
