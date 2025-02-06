<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['client.list'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['client.list'])]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    #[Groups(['client.list'])]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $mdp = null;

    #[ORM\ManyToOne(inversedBy: 'idClient')]
    private ?Commande $commande = null;

    #[ORM\Column(length: 255)]
    private ?string $apiToken = null;

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getMdp(): ?string
    {
        return $this->mdp;
    }

    public function setMdp(string $mdp): static
    {
        $this->mdp = $mdp;

        return $this;
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
    
    public function __toString(): string
    {
        // Crée une représentation sous forme de chaîne de caractères de l'objet
        return $this->getId() . $this->getNom() . $this->getEmail();
    }

    // public function generateToken(): string
    // {
    //     // Utilise la méthode __toString() pour obtenir la chaîne de l'objet
    //     $data = $this->__toString() . uniqid('', true);
        
    //     // Crée un hash sécurisé basé sur la représentation de l'objet
    //     $token = hash('sha256', $data);

    //     return $token;
    // }

    public function getApiToken(): ?string
    {
        return $this->apiToken;
    }

    public function setApiToken(string $apiToken): static
    {
        $this->apiToken = $apiToken;

        return $this;
    }
}
