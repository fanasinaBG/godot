<?php

namespace App\Controller\API;

use App\Entity\RelationIngredientRecette;
use App\Entity\Plat;
use App\Repository\RelationIngredientRecetteRepository;
use App\Entity\Recette;
use App\Entity\Ingredient;
use App\Attribute\TokenRequired;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RelationIngredientRecetteController extends AbstractController
{
    private $entityManager;
    private $relationIngredientRecetteRepository;

    public function __construct(EntityManagerInterface $entityManager, RelationIngredientRecetteRepository $relationIngredientRecetteRepository)
    {
        $this->entityManager = $entityManager;
        $this->relationIngredientRecetteRepository = $relationIngredientRecetteRepository;
    }

    #[Route('/api/relation-ingredient-recette', methods: ['POST'])]
    #[TokenRequired]
    public function createRelationIngredientRecette(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        // Assuming the data contains the necessary fields like nombre, recetteId, ingredientIds
        $nombre = $data['nombre'] ?? null;
        $recetteId = $data['recetteId'] ?? null;
        $ingredientIds = $data['ingredientIds'] ?? [];

        if (!$nombre || !$recetteId || empty($ingredientIds)) {
            return new JsonResponse(['message' => 'Missing data'], Response::HTTP_BAD_REQUEST);
        }

        // Find Recette by ID
        $recette = $this->entityManager->getRepository(Recette::class)->find($recetteId);
        if (!$recette) {
            return new JsonResponse(['message' => 'Recette not found'], Response::HTTP_BAD_REQUEST);
        }

        // Create a new RelationIngredientRecette
        $relation = new RelationIngredientRecette();
        $relation->setNombre($nombre);

        // Set Recette to RelationIngredientRecette
        $relation->setIdRecette($recette);

        // Find Ingredients by their IDs and associate with RelationIngredientRecette
            $ingredient = $this->entityManager->getRepository(Ingredient::class)->find($ingredientIds);
            if ($ingredient) {
                $relation->addIdIngredient($ingredient);
            }

        $this->entityManager->persist($relation);
        $this->entityManager->flush();

        return new JsonResponse(['message' => 'RelationIngredientRecette created'], Response::HTTP_CREATED);
    }

    #[Route('/api/relation-ingredient-recette/{id}', methods: ['GET'])]
    #[TokenRequired]
    public function getRelationIngredientRecette(int $id): JsonResponse
    {
        $relation = $this->relationIngredientRecetteRepository->find($id);

        if (!$relation) {
            return new JsonResponse(['message' => 'RelationIngredientRecette not found'], Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse([
            'id' => $relation->getId(),
            'nombre' => $relation->getNombre(),
            'recetteId' => $relation->getIdRecette()->getId(),
            'ingredientIds' => $relation->getIdIngredient()->map(fn ($ingredient) => $ingredient->getId()),
        ]);
    }

    #[Route('/api/relation-ingredient-recette/{id}', methods: ['PUT'])]
    #[TokenRequired]
    public function updateRelationIngredientRecette(Request $request, int $id): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        // Find RelationIngredientRecette by ID
        $relation = $this->relationIngredientRecetteRepository->find($id);
        if (!$relation) {
            return new JsonResponse(['message' => 'RelationIngredientRecette not found'], Response::HTTP_NOT_FOUND);
        }

        // Update fields
        if (isset($data['nombre'])) {
            $relation->setNombre($data['nombre']);
        }

        if (isset($data['recetteId'])) {
            $recette = $this->entityManager->getRepository(Recette::class)->find($data['recetteId']);
            if ($recette) {
                $relation->setIdRecette($recette);
            }
        }

        if (isset($data['ingredientIds'])) {
            foreach ($data['ingredientIds'] as $ingredientId) {
                $ingredient = $this->entityManager->getRepository(Ingredient::class)->find($ingredientId);
                if ($ingredient) {
                    $relation->addIdIngredient($ingredient);
                }
            }
        }

        $this->entityManager->flush();

        return new JsonResponse(['message' => 'RelationIngredientRecette updated']);
    }

    #[Route('/api/relation-ingredient-recette/{id}', methods: ['DELETE'])]
    #[TokenRequired]
    public function deleteRelationIngredientRecette(int $id): JsonResponse
    {
        $relation = $this->relationIngredientRecetteRepository->find($id);

        if (!$relation) {
            return new JsonResponse(['message' => 'RelationIngredientRecette not found'], Response::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($relation);
        $this->entityManager->flush();

        return new JsonResponse(['message' => 'RelationIngredientRecette deleted'], Response::HTTP_NO_CONTENT);
    }
}
