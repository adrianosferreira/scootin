<?php

namespace Scooter\Handler\Factory;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Scooter\Handler\ScooterHandler;

class ScooterHandlerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): ScooterHandler
    {
        return new ScooterHandler($container->get(LoggerInterface::class));
    }
}