<?php

declare(strict_types=1);

namespace Logger;

use Psr\Log\LoggerInterface;

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
     *
     * @return array<mixed>
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
     *
     * @return array<mixed>
     */
    public function getDependencies(): array
    {
        return [
            'invokables' => [],
            'factories'  => [
                LoggerInterface::class => LoggerFactory::class,
            ],
        ];
    }

    /**
     * Returns the templates configuration
     *
     * @return array<mixed>
     */
    public function getTemplates(): array
    {
        return [
            'paths' => [],
        ];
    }
}
