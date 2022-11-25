<?php

namespace Scooter;

use Mezzio\Application;
use Psr\Container\ContainerInterface;
use Scooter\Handler\ScooterHandler;

class RoutesDelegator
{
    public function __invoke(ContainerInterface $container, string $serviceName, callable $callback): Application
    {
        $app = $callback();
        $app->get('/api/scooter', ScooterHandler::class, 'scooter');
        $app->get('/api/scooter/history', ScooterHandler::class, 'scooter.history');

        return $app;
    }
}