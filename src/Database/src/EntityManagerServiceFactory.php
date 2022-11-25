<?php

namespace Database;

use Database\Services\EntityManagerService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class EntityManagerServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $paths = array("/path/to/entity-files");
        $isDevMode = false;

        // the connection configuration
        $dbParams = array(
            'driver' => 'pdo_mysql',
            'host' => 'db',
            'dbname' => 'core',
            'user' => 'admin',
            'password' => $_ENV['ADMIN_DB_ROOT_PASSWORD'],
        );

        $config = ORMSetup::createAttributeMetadataConfiguration($paths, $isDevMode);
        return EntityManager::create($dbParams, $config);
    }
}