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

class PlatApiController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/api/plats', methods: ['GET'])]
    #[TokenRequired]
    public function getAllPlats(PlatRepository $platRepository,EntityManagerInterface $entityManager): JsonResponse
    {
        $plats = $platRepository->findAll();
        $data = [];

        foreach ($plats as $plat) {
            $data[] = [
                'id' => $plat->getId(),
                'nom' => $plat->getNom(),
                'prix' => $plat->getPrix(),
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

    #[Route('/api/plats/{id}', methods: ['GET'])]
    #[TokenRequired]
    public function getPlat(int $id, PlatRepository $platRepository,EntityManagerInterface $entityManager): JsonResponse
    {
        $plat = $platRepository->find($id);

        if (!$plat) {
            return new JsonResponse(['message' => 'Plat not found'], Response::HTTP_NOT_FOUND);
        }

        $data = [
            'id' => $plat->getId(),
            'nom' => $plat->getNom(),
            'prix' => $plat->getPrix(),
        ];

        return new JsonResponse($data, Response::HTTP_OK);
    }

    #[Route('/api/plats', methods: ['POST'])]
    #[TokenRequired]
    public function createPlat(Request $request,EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $nom = $data['nom'] ?? null;
        $prix = $data['prix'] ?? null;

        if (!$nom || !$prix) {
            return new JsonResponse(['message' => 'Missing data'], Response::HTTP_BAD_REQUEST);
        }

        $plat = new Plat();
        $plat->setNom($nom);
        $plat->setPrix($prix);

        $this->entityManager->persist($plat);
        $this->entityManager->flush();

        return new JsonResponse(['message' => 'Plat created'], Response::HTTP_CREATED);
    }

    #[Route('/api/plats/{id}', methods: ['PUT'])]
    #[TokenRequired]
    public function updatePlat(int $id, Request $request, PlatRepository $platRepository,EntityManagerInterface $entityManager): JsonResponse
    {
        $plat = $platRepository->find($id);

        if (!$plat) {
            return new JsonResponse(['message' => 'Plat not found'], Response::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);

        $nom = $data['nom'] ?? $plat->getNom();
        $prix = $data['prix'] ?? $plat->getPrix();

        $plat->setNom($nom);
        $plat->setPrix($prix);

        $this->entityManager->flush();

        return new JsonResponse(['message' => 'Plat updated'], Response::HTTP_OK);
    }

    #[Route('/api/plats/{id}', methods: ['DELETE'])]
    #[TokenRequired]
    public function deletePlat(int $id, PlatRepository $platRepository,EntityManagerInterface $entityManager): JsonResponse
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
