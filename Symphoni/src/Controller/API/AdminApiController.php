<?php

namespace App\Controller\API;

use App\Entity\Admin;
use App\Repository\AdminRepository;
use App\Attribute\TokenRequired;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;  
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use App\Service\JwtTokenManager;

class AdminApiController extends AbstractController
{
    private $jwtTokenManager;

    public function __construct(JwtTokenManager $jwtTokenManager)
    {
        $this->jwtTokenManager = $jwtTokenManager;
    }

    #[Route("/api/admins", methods: "POST")]
    #[TokenRequired]
    public function create(Request $request, EntityManagerInterface $entityManager)
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['nom'], $data['email'], $data['mdp'])) {
            return new JsonResponse(['error' => 'Invalid data'], 400);
        }

        $Admin = new Admin();
        $Admin->setNom($data['nom']);
        $Admin->setEmail($data['email']);
        $Admin->setMdp($data['mdp']);

        $entityManager->persist($Admin);
        $entityManager->flush();

        return new JsonResponse(['status' => 'Admin created'], 201);
    }

    #[Route("/api/admins/{id}", methods: ["GET"])]
    #[TokenRequired]
    public function findById(AdminRepository $repository, int $id)
    {
        $client = $repository->find($id);

        if (!$client) {
            return new JsonResponse(['message' => 'Client not found'], Response::HTTP_NOT_FOUND);
        }

        return $this->json($client);
    }

    #[Route("/api/admins", methods: ["GET"])]
    #[TokenRequired]
    public function findByAll(AdminRepository $repository)
    {
        $admins = $repository->findAll();

        if (!$admins) {
            return new JsonResponse(['message' => 'No admins found'], Response::HTTP_NOT_FOUND);
        }

        // return new JsonResponse(['message' => 'Token is valid']);
        return $this->json($admins);
    }

    #[Route("/api/admins/login", methods: ["POST"])]
    public function login(Request $request, AdminRepository $repository, EntityManagerInterface $em)
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
        // Génération d'un token basé sur l'objet admin
        // $token = $admin->generateToken();
        // $token = hash('sha256', $tokenData);

        return new JsonResponse(['token' => $admin->getApiToken()]);
    }
}
