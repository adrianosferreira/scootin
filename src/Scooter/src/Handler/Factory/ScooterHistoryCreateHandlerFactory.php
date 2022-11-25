<?php

declare(strict_types=1);

namespace Scooter\Handler\Factory;

use Psr\Container\ContainerInterface;
use Scooter\Entities\ScooterHistoryRepository;
use Scooter\Handler\ScooterHistoryCreateHandler;

class ScooterHistoryCreateHandlerFactory
{
    public function __invoke(ContainerInterface $container) : ScooterHistoryCreateHandler
    {
        return new ScooterHistoryCreateHandler(
            $container->get(ScooterHistoryRepository::class),
        );
    }
}
