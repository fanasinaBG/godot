<?php

namespace App\Controller\API;

use App\Entity\Plat;
use App\Repository\PlatRepository;
use App\Attribute\TokenRequired;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use App\Service\JwtTokenManager;
use App\Entity\Vilany;

class PlatApiController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/api/plats', methods: ['GET'])]
    #[TokenRequired]
    public function getAllPlats(PlatRepository $platRepository): JsonResponse
    {
        $plats = $platRepository->findAll();
        $data = [];

        foreach ($plats as $plat) {
            $data[] = [
                'id' => $plat->getId(),
                'nom' => $plat->getNom(),
                'prix' => $plat->getPrix(),
                'idRecette' => $plat->getIdRecette() ? $plat->getIdRecette()->getId() : null,
                'relationplatCommande' => $plat->getRelationplatCommande() ? $plat->getRelationplatCommande()->getId() : null,
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

    #[Route('/api/plats/{id}', methods: ['GET'])]
    #[TokenRequired]
    public function getPlat(int $id, PlatRepository $platRepository): JsonResponse
    {
        $plat = $platRepository->find($id);

        if (!$plat) {
            return new JsonResponse(['message' => 'Plat not found'], Response::HTTP_NOT_FOUND);
        }

        $data = [
            'id' => $plat->getId(),
            'nom' => $plat->getNom(),
            'prix' => $plat->getPrix(),
            'idRecette' => $plat->getIdRecette() ? $plat->getIdRecette()->getId() : null,
            'relationplatCommande' => $plat->getRelationplatCommande() ? $plat->getRelationplatCommande()->getId() : null,
        ];

        return new JsonResponse($data, Response::HTTP_OK);
    }

    #[Route('/api/plats', methods: ['POST'])]
    #[TokenRequired]
    public function createPlat(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $nom = $data['nom'] ?? null;
        $prix = $data['prix'] ?? null;
        $idRecette = $data['idRecette'] ?? null;
        $relationplatCommandeId = $data['relationplatCommande'] ?? null;

        if (!$nom || !$prix) {
            return new JsonResponse(['message' => 'Missing data'], Response::HTTP_BAD_REQUEST);
        }

        $plat = new Plat();
        $plat->setNom($nom);
        $plat->setPrix($prix);

        if ($idRecette) {
            $recette = $this->entityManager->getRepository(Recette::class)->find($idRecette);
            if ($recette) {
                $plat->setIdRecette($recette);
            }
        }

        if ($relationplatCommandeId) {
            $relationplatCommande = $this->entityManager->getRepository(RelationplatCommande::class)->find($relationplatCommandeId);
            if ($relationplatCommande) {
                $plat->setRelationplatCommande($relationplatCommande);
            }
        }

        $this->entityManager->persist($plat);
        $this->entityManager->flush();

        return new JsonResponse(['message' => 'Plat created'], Response::HTTP_CREATED);
    }

    #[Route('/api/plats/{id}', methods: ['PUT'])]
    #[TokenRequired]
    public function updatePlat(int $id, Request $request, PlatRepository $platRepository): JsonResponse
    {
        $plat = $platRepository->find($id);

        if (!$plat) {
            return new JsonResponse(['message' => 'Plat not found'], Response::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);

        $nom = $data['nom'] ?? $plat->getNom();
        $prix = $data['prix'] ?? $plat->getPrix();
        $idRecette = $data['idRecette'] ?? null;
        $relationplatCommandeId = $data['relationplatCommande'] ?? null;

        $plat->setNom($nom);
        $plat->setPrix($prix);

        if ($idRecette) {
            $recette = $this->entityManager->getRepository(Recette::class)->find($idRecette);
            if ($recette) {
                $plat->setIdRecette($recette);
            }
        }

        if ($relationplatCommandeId) {
            $relationplatCommande = $this->entityManager->getRepository(RelationplatCommande::class)->find($relationplatCommandeId);
            if ($relationplatCommande) {
                $plat->setRelationplatCommande($relationplatCommande);
            }
        }

        $this->entityManager->flush();

        return new JsonResponse(['message' => 'Plat updated'], Response::HTTP_OK);
    }

    #[Route('/api/plats/{id}/add-recette', methods: ['POST'])]
    public function addRecetteToPlat(int $id, Request $request, PlatRepository $platRepository): JsonResponse
    {
        // Get the Plat entity
        $plat = $platRepository->find($id);

        if (!$plat) {
            return new JsonResponse(['message' => 'Plat not found'], Response::HTTP_NOT_FOUND);
        }

        // Get the Recette ID from the request
        $data = json_decode($request->getContent(), true);
        $idRecette = $data['idRecette'] ?? null;

        if (!$idRecette) {
            return new JsonResponse(['message' => 'Missing recette ID'], Response::HTTP_BAD_REQUEST);
        }

        // Get the Recette entity
        $recette = $this->entityManager->getRepository(Recette::class)->find($idRecette);

        if (!$recette) {
            return new JsonResponse(['message' => 'Recette not found'], Response::HTTP_NOT_FOUND);
        }

        // Set the recette on the Plat entity
        $plat->setIdRecette($recette);

        // Persist changes and flush
        $this->entityManager->flush();

        return new JsonResponse(['message' => 'Recette added to Plat'], Response::HTTP_OK);
    }

    #[Route('/api/plats/{id}', methods: ['DELETE'])]
    #[TokenRequired]
    public function deletePlat(int $id, PlatRepository $platRepository): JsonResponse
    {
        $plat = $platRepository->find($id);

        if (!$plat) {
            return new JsonResponse(['message' => 'Plat not found'], Response::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($plat);
        $this->entityManager->flush();

        return new JsonResponse(['message' => 'Plat deleted'], Response::HTTP_OK);
    }
}
