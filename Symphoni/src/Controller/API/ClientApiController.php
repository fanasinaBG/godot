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

class ClientApiController extends AbstractController
{
    #[Route("/api/clients", methods: "POST")]
    // #[TokenRequired]
    public function create(Request $request, EntityManagerInterface $entityManager)
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['nom'], $data['email'], $data['mdp'])) {
            return new JsonResponse(['error' => 'Invalid data'], 400);
        }

        $client = new Client();
        $client->setNom($data['nom']);
        $client->setEmail($data['email']);
        $client->setMdp($data['mdp']);

        $entityManager->persist($client);
        $entityManager->flush();

        return new JsonResponse(['status' => 'Client created'], 201);
    }

    #[Route("/api/clients/{id}", methods: ["GET"])]
    public function findById(ClientRepository $repository, int $id)
    {
        $client = $repository->find($id);

        if (!$client) {
            return new JsonResponse(['message' => 'Client not found'], Response::HTTP_NOT_FOUND);
        }

        return $this->json($client);
    }

    #[Route("/api/clients/login", methods: ["POST"])]
    public function login(Request $request, ClientRepository $repository, EntityManagerInterface $em)
    {
        $data = json_decode($request->getContent(), true);
        $email = $data['email'] ?? '';
        $password = $data['mdp'] ?? '';

        $client = $repository->findOneBy(['email' => $email]);

        if (!$client || $client->getMdp() !== $password) {
            return new JsonResponse(['message' => 'Invalid credentials'], Response::HTTP_UNAUTHORIZED);
        }

        // Génération d'un token basé sur l'objet client
        $tokenData = $client->getId() . $client->getNom() . $client->getEmail() . time();
        $token = hash('sha256', $tokenData);

        return new JsonResponse(['token' => $token]);
    }
}
