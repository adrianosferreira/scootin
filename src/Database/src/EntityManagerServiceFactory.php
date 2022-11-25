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
        $config = $container->get('config');

        $isDevMode = false;

        // the connection configuration
        $dbParams = [
            'driver'   => $config['db']['core']['driver'],
            'host'     => $config['db']['core']['host'],
            'dbname'   => $config['db']['core']['dbname'],
            'user'     => $config['db']['core']['user'],
            'password' => $_ENV['ADMIN_DB_ROOT_PASSWORD'],
        ];

        $config = ORMSetup::createAttributeMetadataConfiguration([], $isDevMode);
        $config->addCustomNumericFunction('acos', AcosCustomFunction::class);
        $config->addCustomNumericFunction('cos', CosCustomFunction::class);
        $config->addCustomNumericFunction('radians', RadiansCustomFunction::class);
        $config->addCustomNumericFunction('sin', SinCustomFunction::class);
        $config->addCustomNumericFunction('any_value', AnyValueCustomFunction::class);

        return EntityManager::create($dbParams, $config);
    }
}
