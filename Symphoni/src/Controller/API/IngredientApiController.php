<?php

namespace App\Controller\Api;

use App\Entity\Ingredient;
use App\Repository\IngredientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/api/ingredients')]
class IngredientApiController extends AbstractController
{

    #[Route('', methods: ['GET'])]
    #[TokenRequired]
    public function index(IngredientRepository $ingredientRepository,EntityManagerInterface $entityManager): JsonResponse
    {
        $ingredients = $ingredientRepository->findAll();
        $data = array_map(fn(Ingredient $ingredient) => [
            'id' => $ingredient->getId(),
            'nom' => $ingredient->getNom(),
        ], $ingredients);

        return $this->json($data);
    }

    #[Route('/{id}', methods: ['GET'])]
    #[TokenRequired]
    public function show(Ingredient $ingredient = null,EntityManagerInterface $entityManager): JsonResponse
    {
        if (!$ingredient) {
            return $this->json(['error' => 'Ingredient not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        return $this->json([
            'id' => $ingredient->getId(),
            'nom' => $ingredient->getNom(),
        ]);
    }

    #[Route('', methods: ['POST'])]
    #[TokenRequired]
    public function create(Request $request,EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $nom = $data['nom'] ?? null;

        if (!$nom) {
            return $this->json(['error' => 'Missing required field: nom'], JsonResponse::HTTP_BAD_REQUEST);
        }

        $ingredient = new Ingredient();
        $ingredient->setNom($nom);

        $this->entityManager->persist($ingredient);
        $this->entityManager->flush();

        return $this->json([
            'message' => 'Ingredient created successfully',
            'id' => $ingredient->getId(),
        ], JsonResponse::HTTP_CREATED);
    }

    #[Route('/{id}', methods: ['PUT'])]
    #[TokenRequired]
    public function update(Request $request, Ingredient $ingredient = null,EntityManagerInterface $entityManager): JsonResponse
    {
        if (!$ingredient) {
            return $this->json(['error' => 'Ingredient not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);
        $nom = $data['nom'] ?? null;

        if (!$nom) {
            return $this->json(['error' => 'Missing required field: nom'], JsonResponse::HTTP_BAD_REQUEST);
        }

        $ingredient->setNom($nom);
        $this->entityManager->flush();

        return $this->json(['message' => 'Ingredient updated successfully']);
    }

    #[Route('/{id}', methods: ['DELETE'])]
    #[TokenRequired]
    public function delete(Ingredient $ingredient = null,EntityManagerInterface $entityManager): JsonResponse
    {
        if (!$ingredient) {
            return $this->json(['error' => 'Ingredient not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($ingredient);
        $this->entityManager->flush();

        return $this->json(['message' => 'Ingredient deleted successfully']);
    }
}
