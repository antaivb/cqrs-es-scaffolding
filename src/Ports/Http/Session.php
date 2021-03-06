<?php

declare(strict_types=1);

namespace App\Ports\Http;

use App\Domain\User\Exception\InvalidCredentialsException;
use App\Infrastructure\User\Auth\Auth;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

final class Session
{
    private TokenStorageInterface $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public function get(): Auth
    {
        $token = $this->tokenStorage->getToken();

        if (!$token) {
            throw new InvalidCredentialsException();
        }

        $user = $token->getUser();

        if (!$user instanceof Auth) {
            throw new InvalidCredentialsException();
        }

        return $user;
    }
}
