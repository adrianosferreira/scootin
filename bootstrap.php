<?php
// bootstrap.php
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Symfony\Component\Dotenv\Dotenv;

require_once "vendor/autoload.php";

$dotenv = new Dotenv();
$dotenv->load(__DIR__.'/.env');

$container = require 'config/container.php';
$configService = $container->get('config');

// database configuration parameters
$conn = array(
    'dbname' => $configService['db']['core']['dbname'],
    'user' => $configService['db']['core']['user'],
    'password' => $_ENV['ADMIN_DB_ROOT_PASSWORD'],
    'host' => $configService['db']['core']['host'],
    'driver' => $configService['db']['core']['driver'],
);

$config = ORMSetup::createAttributeMetadataConfiguration(
    paths: array(__DIR__."/src"),
    isDevMode: true,
);

// obtaining the entity manager
$entityManager = EntityManager::create($conn, $config);