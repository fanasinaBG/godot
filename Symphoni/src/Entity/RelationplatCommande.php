<?php

namespace App\Entity;

use App\Repository\RelationplatCommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: RelationplatCommandeRepository::class)]
class RelationplatCommande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['relationplatcommande:read', 'relationplatcommande:write'])]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Commande::class, inversedBy: 'relationplatCommandes')]
    #[ORM\JoinColumn(name: "commande_id", referencedColumnName: "id", nullable: false)]
    private ?Commande $commande = null;

    #[ORM\ManyToOne(targetEntity: Plat::class, inversedBy: 'relationplatCommandes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Plat $plat = null;

    #[ORM\Column]
    #[Groups(['relationplatcommande:read', 'relationplatcommande:write'])]
    private ?int $nombre = null;

    #[ORM\Column]
    #[Groups(['relationplatcommande:read', 'relationplatcommande:write'])]
    private ?int $prix = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommande(): ?Commande
    {
        return $this->commande;
    }

    public function setCommande(?Commande $commande): static
    {
        $this->commande = $commande;

        return $this;
    }

    public function getPlat(): ?Plat
    {
        return $this->plat;
    }

    public function setPlat(?Plat $plat): static
    {
        $this->plat = $plat;

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
        return $this->prix;
    }

    public function setPrix(int $prix): static
    {
        $this->prix = $prix;

        return $this;
    }
}
