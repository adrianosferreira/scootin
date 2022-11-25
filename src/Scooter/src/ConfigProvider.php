<?php

declare(strict_types=1);

namespace Scooter;

use Mezzio\Application;
use Scooter\Entities\Factory\ScooterHistoryRepositoryFactory;
use Scooter\Entities\Factory\ScooterRepositoryFactory;
use Scooter\Entities\ScooterHistoryRepository;
use Scooter\Entities\ScooterRepository;
use Scooter\Handler\Factory\ScooterHandlerFactory;
use Scooter\Handler\Factory\ScooterNearbyHandlerFactory;
use Scooter\Handler\ScooterHandler;
use Scooter\Handler\ScooterNearbyHandler;

/**
 * The configuration provider for the App module
 *
 * @see https://docs.laminas.dev/laminas-component-installer/
 */
class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     */
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'templates'    => $this->getTemplates(),
        ];
    }

    /**
     * Returns the container dependencies
     */
    public function getDependencies(): array
    {
        return [
            'factories'  => [
                ScooterHandler::class => ScooterHandlerFactory::class,
                ScooterNearbyHandler::class => ScooterNearbyHandlerFactory::class,
                ScooterHistoryRepository::class => ScooterHistoryRepositoryFactory::class,
                ScooterRepository::class => ScooterRepositoryFactory::class,
            ],
            'delegators' => [
                Application::class => [
                    RoutesDelegator::class,
                ]
            ],
        ];
    }

    /**
     * Returns the templates configuration
     */
    public function getTemplates(): array
    {
        return [
            'paths' => [
                'app'    => [__DIR__ . '/../templates/app'],
                'error'  => [__DIR__ . '/../templates/error'],
                'layout' => [__DIR__ . '/../templates/layout'],
            ],
        ];
    }
}
