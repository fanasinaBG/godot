<?php

namespace App\Controller\API;

use App\Entity\Commande;
use App\Repository\CommandeRepository;
use App\Repository\ClientRepository;
use App\Entity\RelationplatCommande;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/commandes', name: 'commande_')]
class CommandeController extends AbstractController
{
    private $commandeRepository;
    private $entityManager;
    private $clientRepository;

    public function __construct(CommandeRepository $commandeRepository, EntityManagerInterface $entityManager, ClientRepository $clientRepository)
    {
        $this->commandeRepository = $commandeRepository;
        $this->entityManager = $entityManager;
        $this->clientRepository = $clientRepository;
    }

    #[Route('', name: 'create', methods: ['POST'])]
    public function createCommande(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $commande = new Commande();
        $commande->setPrixTotal($data['prix_total']);
        $commande->setStatue($data['statue']);

        // Utilisez ClientRepository pour récupérer le client
        $client = $this->clientRepository->find($data['client_id']);
        if (!$client) {
            return new JsonResponse(['message' => 'Client not found'], JsonResponse::HTTP_NOT_FOUND);
        }
        $commande->setClient($client);

        // Supposons que RelationplatCommande est passé dans les données
        // $relationplatCommande = $this->entityManager->getRepository(RelationplatCommande::class)->find($data['relationplat_commande']);
        // $commande->addRelationplatCommande($relationplatCommande);

        $this->entityManager->persist($commande);
        $this->entityManager->flush();

        return new JsonResponse(['message' => 'Commande created successfully', 'id' => $commande->getId()], JsonResponse::HTTP_CREATED);
    }

    #[Route('/{id}', name: 'get', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function getCommande(int $id): JsonResponse
    {
        $commande = $this->commandeRepository->find($id);

        if (!$commande) {
            return new JsonResponse(['message' => 'Commande not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        return new JsonResponse([
            'id' => $commande->getId(),
            'prix_total' => $commande->getPrixTotal(),
            'statue' => $commande->getStatue(),
            'client_id' => $commande->getClient()->getId(),
            'relationplat_commandes' => $commande->getRelationplatCommandes()->toArray(),
        ]);
    }

    #[Route('/{id}', name: 'update', methods: ['PUT'])]
    public function updateCommande(Request $request, int $id): JsonResponse
    {
        $commande = $this->commandeRepository->find($id);

        if (!$commande) {
            return new JsonResponse(['message' => 'Commande not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);

        $commande->setPrixTotal($data['prix_total'] ?? $commande->getPrixTotal());
        $commande->setStatue($data['statue'] ?? $commande->getStatue());

        // Mise à jour de la relationplatCommande si nécessaire
        if (isset($data['relationplat_commande'])) {
            $relationplatCommande = $this->entityManager->getRepository(RelationplatCommande::class)->find($data['relationplat_commande']);
            if ($relationplatCommande) {
                $commande->addRelationplatCommande($relationplatCommande);
            }
        }

        $this->entityManager->flush();

        return new JsonResponse(['message' => 'Commande updated successfully']);
    }

    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    public function deleteCommande(int $id): JsonResponse
    {
        $commande = $this->commandeRepository->find($id);

        if (!$commande) {
            return new JsonResponse(['message' => 'Commande not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($commande);
        $this->entityManager->flush();

        return new JsonResponse(['message' => 'Commande deleted successfully']);
    }

    #[Route('', name: 'list', methods: ['GET'])]
    public function listCommandes(): JsonResponse
    {
        $commandes = $this->commandeRepository->findAll();

        $data = [];
        foreach ($commandes as $commande) {
            $data[] = [
                'id' => $commande->getId(),
                'prix_total' => $commande->getPrixTotal(),
                'statue' => $commande->getStatue(),
                'client_id' => $commande->getClient()->getId(),
                'relationplat_commandes' => $commande->getRelationplatCommandes()->toArray(),
            ];
        }

        return new JsonResponse($data);
    }

    // API - Get statistiques
    #[Route('/statistiques', name: 'api_statistiques', methods: ['GET'])]
    public function getStatistiques(CommandeRepository $commandeRepository): JsonResponse
    {
        // Montant total des ventes
        $totalVentes = $commandeRepository->getTotalVentes();

        // Nombre total de plats servis
        $totalPlatsServis = $commandeRepository->getTotalPlatsServis();

        return new JsonResponse([
            'montant_total_ventes' => $totalVentes,
            'nombre_plats_servis' => $totalPlatsServis,
        ]);
    }
}
