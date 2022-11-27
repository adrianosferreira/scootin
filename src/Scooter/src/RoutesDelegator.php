<?php

declare(strict_types=1);

namespace Scooter;

use Mezzio\Application;
use Mezzio\Helper\BodyParams\BodyParamsMiddleware;
use Psr\Container\ContainerInterface;
use Scooter\Handler\ScooterHistoryCreateHandler;
use Scooter\Handler\ScooterNearbyHandler;

class RoutesDelegator
{
    public function __invoke(ContainerInterface $container, string $serviceName, callable $callback): Application
    {
        $app = $callback();
        $app->get('/api/scooters/nearby', ScooterNearbyHandler::class, 'scooter.nearby');

        $app->post(
            '/api/scooter/{id:\d+}/history',
            [
                BodyParamsMiddleware::class,
                ScooterHistoryCreateHandler::class,
            ],
            'scooter.history.create'
        );

        return $app;
    }
}
