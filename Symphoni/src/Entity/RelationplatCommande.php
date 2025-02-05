<?php

namespace App\Entity;

use App\Repository\RelationplatCommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RelationplatCommandeRepository::class)]
class RelationplatCommande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, Commande>
     */
    #[ORM\OneToMany(targetEntity: Commande::class, mappedBy: 'relationplatCommande')]
    private Collection $idCommade;

    /**
     * @var Collection<int, Plat>
     */
    #[ORM\OneToMany(targetEntity: Plat::class, mappedBy: 'relationplatCommande')]
    private Collection $idPlat;

    #[ORM\Column]
    private ?int $nombre = null;

    #[ORM\Column]
    private ?int $Prix = null;

    public function __construct()
    {
        $this->idCommade = new ArrayCollection();
        $this->idPlat = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Commande>
     */
    public function getIdCommade(): Collection
    {
        return $this->idCommade;
    }

    public function addIdCommade(Commande $idCommade): static
    {
        if (!$this->idCommade->contains($idCommade)) {
            $this->idCommade->add($idCommade);
            $idCommade->setRelationplatCommande($this);
        }

        return $this;
    }

    public function removeIdCommade(Commande $idCommade): static
    {
        if ($this->idCommade->removeElement($idCommade)) {
            // set the owning side to null (unless already changed)
            if ($idCommade->getRelationplatCommande() === $this) {
                $idCommade->setRelationplatCommande(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Plat>
     */
    public function getIdPlat(): Collection
    {
        return $this->idPlat;
    }

    public function addIdPlat(Plat $idPlat): static
    {
        if (!$this->idPlat->contains($idPlat)) {
            $this->idPlat->add($idPlat);
            $idPlat->setRelationplatCommande($this);
        }

        return $this;
    }

    public function removeIdPlat(Plat $idPlat): static
    {
        if ($this->idPlat->removeElement($idPlat)) {
            // set the owning side to null (unless already changed)
            if ($idPlat->getRelationplatCommande() === $this) {
                $idPlat->setRelationplatCommande(null);
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

    public function getPrix(): ?int
    {
        return $this->Prix;
    }

    public function setPrix(int $Prix): static
    {
        $this->Prix = $Prix;

        return $this;
    }
}
