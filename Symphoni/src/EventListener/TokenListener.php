<?php

namespace App\EventListener;

use App\Service\JwtTokenManager;
use App\Attribute\TokenRequired;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Annotations\AnnotationReader;

class TokenListener
{
    private $jwtTokenManager;
    private $reader;

    public function __construct(JwtTokenManager $jwtTokenManager)
    {
        $this->jwtTokenManager = $jwtTokenManager;
        $this->reader = new AnnotationReader(); // Initialisez le reader ici
    }


    public function onKernelController(ControllerEvent $event)
    {
        $controller = $event->getController();

        if (!is_array($controller)) {
            return;
        }

        $object = new \ReflectionObject($controller[0]);
        $method = $object->getMethod($controller[1]);

        // Vérifiez si l'attribut TokenRequired est présent
        $attributes = $method->getAttributes(TokenRequired::class);

        if (count($attributes) > 0) {
            // Récupérer la requête
            $request = $event->getRequest();

            // Extraire et valider le token
            $tokenString = $this->jwtTokenManager->extractTokenFromRequest($request);
            $parsedToken = $this->jwtTokenManager->parseToken($tokenString);

            if (!$parsedToken || !$this->jwtTokenManager->validateToken($parsedToken)) {
                // Si le token est invalide, retournez une réponse 401
                $event->setController(function () {
                    return new JsonResponse(['error' => 'Invalid or expired token'], Response::HTTP_UNAUTHORIZED);
                });
            }
        }
    }
}
