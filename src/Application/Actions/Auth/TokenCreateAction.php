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
        if (!$this->isValidLogin($username, $password)) {
            return $this->unauthorizedResponse($response);
        }

        $token = $this->createFreshToken(new JWTClaims($username));
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

    private function isValidLogin($username, $password): bool
    {
        return ($username === 'user' && $password === 'secret');
    }

    private function createFreshToken(JWTClaims $jwtClaims): ?string
    {
        return $this->jwtAuth->createJwt($jwtClaims());
    }

    private function unauthorizedResponse(ResponseInterface $response) : ResponseInterface
    {
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(401, 'Unauthorized');
    }

}
