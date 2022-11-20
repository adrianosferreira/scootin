<?php
// bootstrap.php
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

require_once "vendor/autoload.php";

// Create a simple "default" Doctrine ORM configuration for Attributes
$config = ORMSetup::createAttributeMetadataConfiguration(
    paths: array(__DIR__."/src"),
    isDevMode: true,
);
// or if you prefer annotation, YAML or XML
// $config = ORMSetup::createAnnotationMetadataConfiguration(
//    paths: array(__DIR__."/src"),
//    isDevMode: true,
// );
// $config = ORMSetup::createXMLMetadataConfiguration(
//    paths: array(__DIR__."/config/xml"),
//    isDevMode: true,
//);
// $config = ORMSetup::createYAMLMetadataConfiguration(
//    paths: array(__DIR__."/config/yaml"),
//    isDevMode: true,
// );

// database configuration parameters
$conn = array(
    'driver' => 'pdo_mysql',
    'host' => '127.0.0.1',
    'dbname' => 'core',
    'user' => 'admin',
    'password' => '4q#m1H4m%QkLdOY#c!uD&',
);

// obtaining the entity manager
$entityManager = EntityManager::create($conn, $config);