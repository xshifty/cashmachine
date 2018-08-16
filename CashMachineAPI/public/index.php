<?php
include __DIR__ . '/../../vendor/autoload.php';

$app = new \Slim\App();
$container = $app->getContainer();

include __DIR__ . '/../config/container.php';
include __DIR__ . '/../config/routes.php';

$app->add(function ($request, $response, $next) {
    try {
        $response = $next($request, $response);
        return $response->withHeader('Content-Type', 'application/json');
    } catch (\Exception $e) {
        $response->getBody()->write(json_encode([
            'error' => true,
            'type' => get_class($e),
            'message' => $e->getMessage(),
        ]));
        return $response->withHeader('Content-Type', 'application/json');
    }
});

$app->run();
