<?php

namespace App\Auth\Middleware;

use App\Auth\JwtAuth;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class JwtClaimMiddleware implements MiddlewareInterface
{
    private JwtAuth $jwtAuth;

    public function __construct(JwtAuth $jwtAuth)
    {
        $this->jwtAuth = $jwtAuth;
    }

    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        $authorization = explode(' ', (string)$request->getHeaderLine('Authorization'));
        $type = $authorization[0] ?? '';
        $credentials = $authorization[1] ?? '';

        if ($type === 'Bearer' && $this->jwtAuth->validateToken($credentials)) {
            $parsedToken = $this->jwtAuth->createParsedToken($credentials);
            $request = $request->withAttribute('token', $parsedToken);
            $request = $request->withAttribute('uid', $parsedToken->getClaim('uid'));

            // Add more claim values as attribute...
            //$request = $request->withAttribute('locale', $parsedToken->getClaim('locale'));
        }

        return $handler->handle($request);
    }

}

