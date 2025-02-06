<?php

namespace App\Controller\API;

use App\Entity\Client;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;  
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class AdminApiController extends AbstractController
{
    #[Route("/api/admins", methods: "POST")]
    // #[TokenRequired]
    public function create(Request $request, EntityManagerInterface $entityManager)
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['nom'], $data['email'], $data['mdp'])) {
            return new JsonResponse(['error' => 'Invalid data'], 400);
        }

        $Amdin = new Admin();
        $client->setNom($data['nom']);
        $client->setEmail($data['email']);
        $client->setMdp($data['mdp']);

        $entityManager->persist($client);
        $entityManager->flush();

        return new JsonResponse(['status' => 'Admin created'], 201);
    }

    #[Route("/api/admins/{id}", methods: ["GET"])]
    public function findById(ClientRepository $repository, int $id)
    {
        $client = $repository->find($id);

        if (!$client) {
            return new JsonResponse(['message' => 'Client not found'], Response::HTTP_NOT_FOUND);
        }

        return $this->json($client);
    }

    #[Route("/api/admins/login", methods: ["POST"])]
    public function login(Request $request, ClientRepository $repository, EntityManagerInterface $em)
    {
        $data = json_decode($request->getContent(), true);
        $email = $data['email'] ?? '';
        $password = $data['mdp'] ?? '';

        $admin = $repository->findOneBy(['email' => $email]);

        if (!$admin || $admin->getMdp() !== $password) {
            return new JsonResponse(['message' => 'Invalid credentials'], Response::HTTP_UNAUTHORIZED);
        }

        // Génération d'un token basé sur l'objet admin
        $tokenData = $admin->getId() . $admin->getNom() . $admin->getEmail() . time();
        $token = hash('sha256', $tokenData);

        return new JsonResponse(['token' => $token]);
    }
}
