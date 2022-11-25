<?php

declare(strict_types=1);

namespace Database;

use Database\CustomFunctions\AcosCustomFunction;
use Database\CustomFunctions\AnyValueCustomFunction;
use Database\CustomFunctions\CosCustomFunction;
use Database\CustomFunctions\RadiansCustomFunction;
use Database\CustomFunctions\SinCustomFunction;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class EntityManagerServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $paths     = ["/path/to/entity-files"];
        $isDevMode = false;

        // the connection configuration
        $dbParams = [
            'driver'   => 'pdo_mysql',
            'host'     => 'db',
            'dbname'   => 'core',
            'user'     => 'admin',
            'password' => $_ENV['ADMIN_DB_ROOT_PASSWORD'],
        ];

        $config = ORMSetup::createAttributeMetadataConfiguration($paths, $isDevMode);
        $config->addCustomNumericFunction('acos', AcosCustomFunction::class);
        $config->addCustomNumericFunction('cos', CosCustomFunction::class);
        $config->addCustomNumericFunction('radians', RadiansCustomFunction::class);
        $config->addCustomNumericFunction('sin', SinCustomFunction::class);
        $config->addCustomNumericFunction('any_value', AnyValueCustomFunction::class);

        return EntityManager::create($dbParams, $config);
    }
}
