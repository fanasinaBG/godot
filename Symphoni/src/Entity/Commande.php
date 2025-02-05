<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, Client>
     */
    #[ORM\OneToMany(targetEntity: Client::class, mappedBy: 'commande')]
    private Collection $idClient;

    #[ORM\Column]
    private ?int $PrixTotal = null;

    #[ORM\Column(length: 255)]
    private ?string $Statue = null;

    #[ORM\ManyToOne(inversedBy: 'idCommade')]
    private ?RelationplatCommande $relationplatCommande = null;

    public function __construct()
    {
        $this->idClient = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Client>
     */
    public function getIdClient(): Collection
    {
        return $this->idClient;
    }

    public function addIdClient(Client $idClient): static
    {
        if (!$this->idClient->contains($idClient)) {
            $this->idClient->add($idClient);
            $idClient->setCommande($this);
        }

        return $this;
    }

    public function removeIdClient(Client $idClient): static
    {
        if ($this->idClient->removeElement($idClient)) {
            // set the owning side to null (unless already changed)
            if ($idClient->getCommande() === $this) {
                $idClient->setCommande(null);
            }
        }

        return $this;
    }

    public function getPrixTotal(): ?int
    {
        return $this->PrixTotal;
    }

    public function setPrixTotal(int $PrixTotal): static
    {
        $this->PrixTotal = $PrixTotal;

        return $this;
    }

    public function getStatue(): ?string
    {
        return $this->Statue;
    }

    public function setStatue(string $Statue): static
    {
        $this->Statue = $Statue;

        return $this;
    }

    public function getRelationplatCommande(): ?RelationplatCommande
    {
        return $this->relationplatCommande;
    }

    public function setRelationplatCommande(?RelationplatCommande $relationplatCommande): static
    {
        $this->relationplatCommande = $relationplatCommande;

        return $this;
    }
}
