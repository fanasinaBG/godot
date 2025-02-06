<?php

namespace App\Controller\API;

use App\Entity\Client;
use App\Repository\ClientRepository;
use App\Attribute\TokenRequired;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;  
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use App\Service\JwtTokenManager;

class ClientApiController extends AbstractController
{
    private $jwtTokenManager;

    public function __construct(JwtTokenManager $jwtTokenManager)
    {
        $this->jwtTokenManager = $jwtTokenManager;
    }

    
    #[Route("/api/clients", methods: "POST")]
    #[TokenRequired]
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
    #[TokenRequired]
    public function findById(ClientRepository $repository, int $id)
    {
        $client = $repository->find($id);

        if (!$client) {
            return new JsonResponse(['message' => 'Client not found'], Response::HTTP_NOT_FOUND);
        }

        return $this->json($client);
    }

    #[Route("/api/clients", methods: ["GET"])]
    #[TokenRequired]
    public function findByAll(ClientRepository $repository)
    {
        $clients = $repository->findAll();

        if (!$clients) {
            return new JsonResponse(['message' => 'No clients found'], Response::HTTP_NOT_FOUND);
        }

        // return new JsonResponse(['message' => 'Token is valid']);
        return $this->json($clients, 200, [], [
            'groups' => ['client.list']
        ]);
    }

    #[Route("/api/clients/login", methods: ["POST"])]
    public function login(Request $request, ClientRepository $repository, EntityManagerInterface $em)
    {
        $data = json_decode($request->getContent(), true);
        $email = $data['email'] ?? '';
        $password = $data['mdp'] ?? '';

        $admin = $repository->findOneBy(['email' => $email]);

        if (!$admin || $admin->getMdp() !== $password) {
            return new JsonResponse(['message' => 'Invalid credentials'], Response::HTTP_UNAUTHORIZED);
        }
        $claims = [
            'userId' => $admin->getId(),
            // 'email' => $user->getEmail(),
        ];
        $token = $this->jwtTokenManager->createToken($claims, 3600);

        $admin->setApiToken($token->toString());
        $em->persist($admin);
        $em->flush();

        return new JsonResponse(['token' => $admin->getApiToken()]);
    }
}
