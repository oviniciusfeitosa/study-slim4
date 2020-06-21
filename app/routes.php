<?php
declare(strict_types=1);

use App\Application\Actions\Auth\TokenCreateAction as TokenCreateActionAlias;
use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->options('/{routes:.*}', fn (Request $request, Response $response) => $response);

    $app->get('/hello/{name}', function (Request $request, Response $response, array $args) {
        $name = $args['name'];
        $response->getBody()->write("Hello, $name");
        return $response;
    });

    $app->get('/', fn (Request $request, Response $response) => $response->getBody()->write('Hello world!'));

    $app->group('/users', function (Group $group) {
        $group->get('', ListUsersAction::class);
        $group->get('/{id}', ViewUserAction::class);
    });

    $app->group('/jwt', function (Group $group) {
        $group->post('/create', TokenCreateActionAlias::class);
//        $group->get('/profile', TokenCreateActionAlias::class);
    });
};
