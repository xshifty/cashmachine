<?php
include __DIR__ . '/../../vendor/autoload.php';

$app = new \Slim\App();
$container = $app->getContainer();

include __DIR__ . '/../config/container.php';
include __DIR__ . '/../config/routes.php';

$app->run();
