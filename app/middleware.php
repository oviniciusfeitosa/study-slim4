<?php
declare(strict_types=1);

use App\Application\Middleware\SessionMiddleware;
use App\Auth\Middleware\{JwtAuthMiddleware, JwtClaimMiddleware};
use Slim\App;

return function (App $app) {
    $app->add(SessionMiddleware::class);
    $app->add(JwtAuthMiddleware::class);
    $app->add(JwtClaimMiddleware::class);
};
