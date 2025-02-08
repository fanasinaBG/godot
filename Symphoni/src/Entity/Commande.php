<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $prixTotal = null;

    #[ORM\Column(length: 255)]
    private ?string $statue = null;

    #[ORM\ManyToOne(targetEntity: Client::class, inversedBy: 'commandes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Client $client = null;

    #[ORM\OneToMany(targetEntity: RelationplatCommande::class, mappedBy: 'commande')]
    private Collection $relationplatCommandes;

    public function __construct()
    {
        $this->relationplatCommandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrixTotal(): ?int
    {
        return $this->prixTotal;
    }

    public function setPrixTotal(int $prixTotal): static
    {
        $this->prixTotal = $prixTotal;

        return $this;
    }

    public function getStatue(): ?string
    {
        return $this->statue;
    }

    public function setStatue(string $statut): static
    {
        $this->statue = $statut;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): static
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @return Collection<int, RelationplatCommande>
     */
    public function getRelationplatCommandes(): Collection
    {
        return $this->relationplatCommandes;
    }

    public function addRelationplatCommande(RelationplatCommande $relationplatCommande): static
    {
        if (!$this->relationplatCommandes->contains($relationplatCommande)) {
            $this->relationplatCommandes[] = $relationplatCommande;
            $relationplatCommande->setCommande($this);
        }

        return $this;
    }
}
