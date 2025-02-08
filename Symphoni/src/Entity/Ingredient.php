<?php
// Ingredient.php
namespace App\Entity;

use App\Repository\IngredientRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: IngredientRepository::class)]
class Ingredient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['stock:liste'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['stock:liste'])]
    private ?string $nom = null;

    #[ORM\ManyToOne(inversedBy: 'idIngredient')]
    private ?RelationIngredientRecette $relationIngredientRecette = null;

    /**
     * @var Collection<int, StockIngredient>
     */
    #[ORM\OneToMany(mappedBy: 'ingredient', targetEntity: StockIngredient::class)]
    private Collection $stockIngredients;

    public function __construct()
    {
        $this->stockIngredients = new ArrayCollection();
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

    public function getRelationIngredientRecette(): ?RelationIngredientRecette
    {
        return $this->relationIngredientRecette;
    }

    public function setRelationIngredientRecette(?RelationIngredientRecette $relationIngredientRecette): static
    {
        $this->relationIngredientRecette = $relationIngredientRecette;
        return $this;
    }

    /**
     * @return Collection<int, StockIngredient>
     */
    public function getStockIngredients(): Collection
    {
        return $this->stockIngredients;
    }

    public function addStockIngredient(StockIngredient $stockIngredient): static
    {
        if (!$this->stockIngredients->contains($stockIngredient)) {
            $this->stockIngredients->add($stockIngredient);
            $stockIngredient->setIngredient($this); // Relation ManyToOne inversée
        }

        return $this;
    }

    public function removeStockIngredient(StockIngredient $stockIngredient): static
    {
        $this->stockIngredients->removeElement($stockIngredient);
        // set the owning side to null (unless already changed)
        if ($stockIngredient->getIngredient() === $this) {
            $stockIngredient->setIngredient(null);
        }

        return $this;
    }
}  