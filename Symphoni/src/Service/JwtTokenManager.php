<?php

namespace App\Service;

use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Token;
use Lcobucci\JWT\Validation\Constraint\SignedWith;
use Lcobucci\JWT\Validation\Constraint\LooseValidAt;
use Lcobucci\Clock\SystemClock;
use Psr\Clock\ClockInterface;
use Symfony\Component\HttpFoundation\Request;

class JwtTokenManager
{
    private $config;

    public function __construct(string $secretKey)
    {
        $this->config = Configuration::forSymmetricSigner(
            new Sha256(),
            InMemory::plainText($secretKey)
        );
    }

    public function createToken(array $claims, int $expirationInSeconds): Token
    {
        $now = new \DateTimeImmutable();
        $builder = $this->config->builder()
            ->issuedBy('your-app') // émetteur
            ->permittedFor('your-client') // destinataire
            ->issuedAt($now) // date d'émission
            ->expiresAt($now->modify("+$expirationInSeconds seconds")); // date d'expiration

        foreach ($claims as $key => $value) {
            $builder->withClaim($key, $value);
        }

        return $builder->getToken($this->config->signer(), $this->config->signingKey());
    }

    public function validateToken(Token $token): bool
    {
        // Utilisation de SystemClock de lcobucci
        $clock = new SystemClock(new \DateTimeZone('UTC'));

        $constraints = [
            new SignedWith($this->config->signer(), $this->config->signingKey()),
            new LooseValidAt($clock)
        ];

        return $this->config->validator()->validate($token, ...$constraints);
    }

    public function parseToken(string $tokenString): ?Token
    {
        try {
            return $this->config->parser()->parse($tokenString);
        } catch (\Throwable $e) {
            return null;
        }
    }

    public function extractTokenFromRequest(Request $request): ?string
    {
        $authHeader = $request->headers->get('Authorization');
        if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            return $matches[1];
        }
        return null;
    }
}
