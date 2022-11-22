<?php

declare(strict_types=1);

// Delegate static file requests back to the PHP built-in webserver
if (PHP_SAPI === 'cli-server' && $_SERVER['SCRIPT_FILENAME'] !== __FILE__) {
    return false;
}

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

$logger = new \Monolog\Logger('test');
$socketHandler = new \Monolog\Handler\SocketHandler('logstash:50000');

$formatter = new \Monolog\Formatter\LogstashFormatter('core');

$socketHandler->setFormatter($formatter);

$logger->pushHandler($socketHandler);

$logger->info('Test aaa');

use App\Product;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Scooter\Entities\Scooter;

$paths = array("/path/to/entity-files");
$isDevMode = false;

// the connection configuration
$dbParams = array(
    'driver' => 'pdo_mysql',
    'host' => 'db',
    'dbname' => 'core',
    'user' => 'admin',
    'password' => '4q#m1H4m%QkLdOY#c!uD&',
);

$config = ORMSetup::createAttributeMetadataConfiguration($paths, $isDevMode);
$entityManager = EntityManager::create($dbParams, $config);

$user = new \User\Entities\User();
$user->setEmail('fdsafasd');
$entityManager->persist($user);
$entityManager->flush();

/**
 * Self-called anonymous function that creates its own scope and keeps the global namespace clean.
 */
(function () {
    /** @var \Psr\Container\ContainerInterface $container */
    $container = require 'config/container.php';

    /** @var \Mezzio\Application $app */
    $app = $container->get(\Mezzio\Application::class);
    $factory = $container->get(\Mezzio\MiddlewareFactory::class);

    // Execute programmatic/declarative middleware pipeline and routing
    // configuration statements
    (require 'config/pipeline.php')($app, $factory, $container);
    (require 'config/routes.php')($app, $factory, $container);

    $app->run();
})();
