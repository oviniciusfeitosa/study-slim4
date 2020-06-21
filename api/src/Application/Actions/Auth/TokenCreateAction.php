<?php

namespace App\Application\Actions\Auth;

use App\Auth\JwtAuth;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class TokenCreateAction
{
    private JwtAuth $jwtAuth;

    public function __construct(JwtAuth $jwtAuth)
    {
        $this->jwtAuth = $jwtAuth;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface
    {
        $data = (array)$request->getParsedBody();

        $username = (string)($data['username'] ?? '');
        $password = (string)($data['password'] ?? '');

        /**
         * @todo Authenticate using correct way... >_<"
         * $userAuthData = $this->userAuth->authenticate($username, $password);
         */
        $isValidLogin = ($username === 'user' && $password === 'secret');

        if (!$isValidLogin) {
            // Invalid authentication credentials
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(401, 'Unauthorized');
        }

        // Create a fresh token
        $token = $this->createFreshToken($username,);

        $lifetime = $this->jwtAuth->getLifetime();

        $result = [
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => $lifetime,
        ];

        $response = $response->withHeader('Content-Type', 'application/json');
        $response->getBody()->write((string)json_encode($result));

        return $response->withStatus(201);
    }

    private function createFreshToken(string $username, ...$claims): ?string
    {
        $claims = [
            'uid' => $username,
            ...$claims
        ];
        return $this->jwtAuth->createJwt($claims);
    }
}
