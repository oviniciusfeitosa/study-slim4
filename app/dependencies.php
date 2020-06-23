<?php

declare(strict_types=1);

use App\Auth\JwtAuth;
use DI\ContainerBuilder;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Log\LoggerInterface;
use Slim\Factory\AppFactory;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        LoggerInterface::class => function (ContainerInterface $c) {
            $settings = $c->get('settings');

            $loggerSettings = $settings['logger'];
            $logger = new Logger($loggerSettings['name']);

            $processor = new UidProcessor();
            $logger->pushProcessor($processor);

            $handler = new StreamHandler($loggerSettings['path'], $loggerSettings['level']);
            $logger->pushHandler($handler);

            return $logger;
        },
        JwtAuth::class => function (ContainerInterface $container) {
            $jwtConfig = $container->get('settings')['jwt'];
            $issuer = (string) $jwtConfig['issuer'];
            $lifetime = (int) $jwtConfig['lifetime'];
            $privateKey = (string) $jwtConfig['private_key'];
            $publicKey = (string) $jwtConfig['public_key'];

            return new JwtAuth($issuer, $lifetime, $privateKey, $publicKey);
        },
        ResponseFactoryInterface::class => function (ContainerInterface $container) {
            AppFactory::setContainer($container);
            $app = AppFactory::create();
            return $app->getResponseFactory();
        },
    ]);
};
