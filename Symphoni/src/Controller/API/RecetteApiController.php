<?php

namespace App\Controller\API;

use App\Entity\Recette;
use App\Entity\Plat;
use App\Repository\RecetteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use App\Service\JwtTokenManager;

class RecetteApiController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    // API to get all Recettes
    #[Route('/api/recettes', methods: ['GET'])]
    #[TokenRequired]
    public function getAllRecettes(RecetteRepository $recetteRepository): JsonResponse
    {
        $recettes = $recetteRepository->findAll();
        $data = [];

        foreach ($recettes as $recette) {
            $data[] = [
                'id' => $recette->getId(),
                'temps' => $recette->getTemps(),
                'idPlat' => $recette->getIdPlat() ? $recette->getIdPlat()->getId() : null,
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

    // API to get a single Recette by ID
    #[Route('/api/recettes/{id}', methods: ['GET'])]
    #[TokenRequired]
    public function getRecette(int $id, RecetteRepository $recetteRepository): JsonResponse
    {
        $recette = $recetteRepository->find($id);

        if (!$recette) {
            return new JsonResponse(['message' => 'Recette not found'], Response::HTTP_NOT_FOUND);
        }

        $data = [
            'id' => $recette->getId(),
            'temps' => $recette->getTemps(),
            'idPlat' => $recette->getIdPlat() ? $recette->getIdPlat()->getId() : null,
        ];

        return new JsonResponse($data, Response::HTTP_OK);
    }

    // API to create a new Recette
    #[Route('/api/recettes', methods: ['POST'])]
    #[TokenRequired]
        public function createRecette(Request $request): JsonResponse
        {
            $data = json_decode($request->getContent(), true);

            $temps = $data['temps'] ?? null;
            $idPlat = $data['idPlat'] ?? null;

            if (!$temps || !$idPlat) {
                return new JsonResponse(['message' => 'Missing data'], Response::HTTP_BAD_REQUEST);
            }

            // Create a new Recette instance
            $recette = new Recette();
            $recette->setTemps($temps);

            // Find the Plat by its ID
            $plat = $this->entityManager->getRepository(Plat::class)->find($idPlat);

            if (!$plat) {
                return new JsonResponse(['message' => 'Plat not found'], Response::HTTP_BAD_REQUEST);
            }

            // Set the Plat in the Recette
            $recette->setIdPlat($plat);

            // Update the Plat's idRecette field to point to the new Recette
            $plat->setIdRecette($recette);

            // Persist both the Recette and Plat entities
            $this->entityManager->persist($recette);
            $this->entityManager->persist($plat); // Persist the updated Plat entity
            $this->entityManager->flush();

            return new JsonResponse(['message' => 'Recette created'], Response::HTTP_CREATED);
        }


    // API to update an existing Recette
    #[Route('/api/recettes/{id}', methods: ['PUT'])]
    #[TokenRequired]
    public function updateRecette(int $id, Request $request, RecetteRepository $recetteRepository): JsonResponse
    {
        $recette = $recetteRepository->find($id);

        if (!$recette) {
            return new JsonResponse(['message' => 'Recette not found'], Response::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);

        $temps = $data['temps'] ?? $recette->getTemps();
        $idPlat = $data['idPlat'] ?? $recette->getIdPlat()->getId();

        $recette->setTemps($temps);

        // Assuming Plat entity has an ID to link
        $plat = $this->entityManager->getRepository(Plat::class)->find($idPlat);

        if (!$plat) {
            return new JsonResponse(['message' => 'Plat not found'], Response::HTTP_BAD_REQUEST);
        }

        $recette->setIdPlat($plat);

        $this->entityManager->flush();

        return new JsonResponse(['message' => 'Recette updated'], Response::HTTP_OK);
    }

    // API to delete a Recette by ID
    #[Route('/api/recettes/{id}', methods: ['DELETE'])]
    #[TokenRequired]
    public function deleteRecette(int $id, RecetteRepository $recetteRepository): JsonResponse
    {
        $recette = $recetteRepository->find($id);

        if (!$recette) {
            return new JsonResponse(['message' => 'Recette not found'], Response::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($recette);
        $this->entityManager->flush();

        return new JsonResponse(['message' => 'Recette deleted'], Response::HTTP_OK);
    }
}
