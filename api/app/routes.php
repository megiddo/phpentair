<?php

declare(strict_types=1);

use App\Application\Actions\Signal\RecentSignalsAction;
use \App\Application\Actions\Control\CircuitAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/api', function (Request $request, Response $response) {
        $response->getBody()->write('Hello world!');
        return $response;
    });

    $app->group('/api/signals', function(Group $group) {
        $group->get('', RecentSignalsAction::class);
        $group->get('/{count:\d+}', RecentSignalsAction::class);
    });

    $app->group('/api/control', function(Group $group) {
       $group->put('/circuit/{circuit}', CircuitAction::class);
    });
};
