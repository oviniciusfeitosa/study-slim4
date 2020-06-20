<?php

use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

require __DIR__ . "/../config/settings.php";
require __DIR__ . "/../config/container.php";
require __DIR__ . "/../config/routes.php";

$app->run();
