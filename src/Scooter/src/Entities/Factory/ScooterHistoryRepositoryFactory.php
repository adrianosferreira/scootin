<?php

declare(strict_types=1);

namespace Scooter\Entities\Factory;

use Doctrine\ORM\EntityManagerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Scooter\Entities\ScooterHistoryRepository;

class ScooterHistoryRepositoryFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        return new ScooterHistoryRepository(
            $container->get(LoggerInterface::class),
            $container->get(EntityManagerInterface::class),
        );
    }
}
