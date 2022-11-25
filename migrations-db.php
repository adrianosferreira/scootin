<?php

/** @var \Psr\Container\ContainerInterface $container */
$container = require 'config/container.php';
$config = $container->get('config');

return [
    'dbname' => $config['db']['core']['dbname'],
    'user' => $config['db']['core']['user'],
    'password' => $_ENV['ADMIN_DB_ROOT_PASSWORD'],
    'host' => $config['db']['core']['host'],
    'driver' => $config['db']['core']['driver'],
];