<?php

namespace Scooter\Entities\Factory;

use Doctrine\ORM\EntityManagerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;
use Scooter\Entities\ScooterRepository;

class ScooterRepositoryFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        return new ScooterRepository($container->get(EntityManagerInterface::class));
    }
}