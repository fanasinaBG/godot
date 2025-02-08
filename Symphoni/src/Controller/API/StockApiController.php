<?php

namespace App\Controller\API;

use App\Entity\StockIngredient;
use App\Entity\Ingredient;
use App\Repository\StockIngredientRepository;
use App\Repository\IngredientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/api/stocks')]
class StockApiController extends AbstractController
{
    private StockIngredientRepository $repository;
    private IngredientRepository $ingredientRepository;
    private EntityManagerInterface $entityManager; // Ajout de EntityManagerInterface
    private SerializerInterface $serializer;

    public function __construct(
        StockIngredientRepository $repository, 
        IngredientRepository $ingredientRepository, 
        EntityManagerInterface $entityManager, // Injection de EntityManager
        SerializerInterface $serializer
    ) {
        $this->repository = $repository;
        $this->ingredientRepository = $ingredientRepository;
        $this->entityManager = $entityManager; // Initialisation
        $this->serializer = $serializer;
    }

    #[Route('', name: 'api_stock_index', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $stocks = $this->repository->findAll();
        return $this->json($stocks, Response::HTTP_OK, [], ['groups' => 'stock:read']);
    }

    #[Route('/all', name: 'stock_list', methods: ['GET'])]
    public function getAll(): JsonResponse
    {
        $stocks = $this->repository->findStockWithIngredients();
        return $this->json($stocks, Response::HTTP_OK, [], ['groups' => 'stock:liste']);
    }

    #[Route('/{id}', name: 'api_stock_show', methods: ['GET'])]
    public function show(StockIngredient $stock): JsonResponse
    {
        return $this->json($stock, Response::HTTP_OK, [], ['groups' => 'stock:read']);
    }

    #[Route('/entre', name: 'api_stock_new_entre', methods: ['POST'])]
    public function createEntrer(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['idIngredient'])) {
            return $this->json(['message' => 'L\'ID de l\'ingredient est requis'], Response::HTTP_BAD_REQUEST);
        }

        $ingredient = $this->ingredientRepository->find($data['idIngredient']);

        if (!$ingredient) {
            return $this->json(['message' => 'Ingrédient non trouvé'], Response::HTTP_NOT_FOUND);
        }

        $stock = new StockIngredient();
        $stock->setEntre($data['entre'] ?? 0);
        $stock->setSortie(0);
        $stock->setIngredient($ingredient);  // Associer l'ingrédient au stock

        $this->entityManager->persist($stock);
        $this->entityManager->flush();

        return $this->json(['message' => 'Stock créé avec succès'], Response::HTTP_CREATED);
    }

    #[Route('/sortie', name: 'api_stock_new_sortie', methods: ['POST'])]
    public function createSortie(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['idIngredient'])) {
            return $this->json(['message' => 'L\'ID de l\'ingredient est requis'], Response::HTTP_BAD_REQUEST);
        }

        $ingredient = $this->ingredientRepository->find($data['idIngredient']);

        if (!$ingredient) {
            return $this->json(['message' => 'Ingrédient non trouvé'], Response::HTTP_NOT_FOUND);
        }

        $stock = new StockIngredient();
        $stock->setSortie($data['sortie'] ?? 0);
        $stock->setEntre(0);
        $stock->setIngredient($ingredient);  // Associer l'ingrédient au stock

        $this->entityManager->persist($stock);
        $this->entityManager->flush();

        return $this->json(['message' => 'Stock créé avec succès'], Response::HTTP_CREATED);
    }


    #[Route('/{id}', name: 'api_stock_edit', methods: ['PUT'])]
    public function update(Request $request, StockIngredient $stock): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $stock->setEntre($data['entre'] ?? $stock->getEntre());
        $stock->setSortie($data['sortie'] ?? $stock->getSortie());

        $this->entityManager->persist($stock);
        $this->entityManager->flush();

        return $this->json(['message' => 'Stock mis à jour avec succès']);
    }

    #[Route('/{id}', name: 'api_stock_delete', methods: ['DELETE'])]
    public function delete(StockIngredient $stock): JsonResponse
    {
        $this->entityManager->remove($stock);
        $this->entityManager->flush();

        return $this->json(['message' => 'Stock supprimé avec succès']);
    }

}
