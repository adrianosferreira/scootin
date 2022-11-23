<?php

declare(strict_types=1);

namespace Logger;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Monolog\Formatter\LogstashFormatter;
use Monolog\Handler\SocketHandler;
use Monolog\Logger;
use Psr\Container\ContainerInterface;

final class LoggerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): Logger
    {
        $logger = new Logger('core');
        $config = $container->get('config');
        $socketHandler = new SocketHandler($config['logstash']['socketConnection']);
        $formatter = new LogstashFormatter('core');
        $socketHandler->setFormatter($formatter);
        $logger->pushHandler($socketHandler);

        return $logger;
    }
}
