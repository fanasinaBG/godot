<?php

namespace App\Controller\API;

use App\Entity\RelationplatCommande;
use App\Repository\RelationplatCommandeRepository;
use App\Repository\CommandeRepository;
use App\Repository\PlatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/api/relationplatcommandes', name: 'relationplatcommande_')]
class RelationplatCommandeController extends AbstractController
{
    private $relationplatCommandeRepository;
    private $entityManager;
    private $commandeRepository;
    private $platRepository;

    public function __construct(
        RelationplatCommandeRepository $relationplatCommandeRepository,
        EntityManagerInterface $entityManager,
        CommandeRepository $commandeRepository,
        PlatRepository $platRepository
    ) {
        $this->relationplatCommandeRepository = $relationplatCommandeRepository;
        $this->entityManager = $entityManager;
        $this->commandeRepository = $commandeRepository;
        $this->platRepository = $platRepository;
    }

    #[Route('', name: 'create', methods: ['POST'])]
    public function createRelationplatCommande(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        // Vérification des données et création de la relation
        $relationplatCommande = new RelationplatCommande();
        $relationplatCommande->setNombre($data['nombre']);
        $relationplatCommande->setPrix($data['prix']);
        
        $commande = $this->commandeRepository->find($data['commande_id']);
        $plat = $this->platRepository->find($data['plat_id']);
        
        if (!$plat) {
            return new JsonResponse(['message' => 'Commande or Plat not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        $relationplatCommande->setCommande($commande);
        $relationplatCommande->setPlat($plat);

        $this->entityManager->persist($relationplatCommande);
        $this->entityManager->flush();

        return new JsonResponse(['message' => 'RelationplatCommande created successfully', 'id' => $relationplatCommande->getId()], JsonResponse::HTTP_CREATED);
    }

    #[Route('/{id}', name: 'get', methods: ['GET'])]
    public function getRelationplatCommande(int $id): JsonResponse
    {
        $relationplatCommande = $this->relationplatCommandeRepository->find($id);

        if (!$relationplatCommande) {
            return new JsonResponse(['message' => 'RelationplatCommande not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        return new JsonResponse([
            'id' => $relationplatCommande->getId(),
            'nombre' => $relationplatCommande->getNombre(),
            'prix' => $relationplatCommande->getPrix(),
            'commande_id' => $relationplatCommande->getCommande()->getId(),
            'plat_id' => $relationplatCommande->getPlat()->getId(),
        ]);
    }

    #[Route('/{id}', name: 'update', methods: ['PUT'])]
    public function updateRelationplatCommande(Request $request, int $id): JsonResponse
    {
        $relationplatCommande = $this->relationplatCommandeRepository->find($id);

        if (!$relationplatCommande) {
            return new JsonResponse(['message' => 'RelationplatCommande not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);

        $relationplatCommande->setNombre($data['nombre'] ?? $relationplatCommande->getNombre());
        $relationplatCommande->setPrix($data['prix'] ?? $relationplatCommande->getPrix());

        if (isset($data['commande_id'])) {
            $commande = $this->commandeRepository->find($data['commande_id']);
            if ($commande) {
                $relationplatCommande->setCommande($commande);
            }
        }

        if (isset($data['plat_id'])) {
            $plat = $this->platRepository->find($data['plat_id']);
            if ($plat) {
                $relationplatCommande->setPlat($plat);
            }
        }

        $this->entityManager->flush();

        return new JsonResponse(['message' => 'RelationplatCommande updated successfully']);
    }

    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    public function deleteRelationplatCommande(int $id): JsonResponse
    {
        $relationplatCommande = $this->relationplatCommandeRepository->find($id);

        if (!$relationplatCommande) {
            return new JsonResponse(['message' => 'RelationplatCommande not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($relationplatCommande);
        $this->entityManager->flush();

        return new JsonResponse(['message' => 'RelationplatCommande deleted successfully']);
    }

    #[Route('', name: 'list', methods: ['GET'])]
    public function listRelationplatCommandes(): JsonResponse
    {
        $relationplatCommandes = $this->relationplatCommandeRepository->findAll();

        $data = [];
        foreach ($relationplatCommandes as $relationplatCommande) {
            $data[] = [
                'id' => $relationplatCommande->getId(),
                'nombre' => $relationplatCommande->getNombre(),
                'prix' => $relationplatCommande->getPrix(),
                'commande_id' => $relationplatCommande->getCommande()->getId(),
                'plat_id' => $relationplatCommande->getPlat()->getId(),
            ];
        }

        return new JsonResponse($data);
    }
}