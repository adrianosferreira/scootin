<?php

namespace Scooter\Handler\Factory;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;
use Scooter\Entities\ScooterRepository;
use Scooter\Handler\ScooterNearbyHandler;

class ScooterNearbyHandlerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        return new ScooterNearbyHandler($container->get(ScooterRepository::class));
    }
}