<?php
$app->get('/withdraw', '\Xshifty\CashMachine\App\Controller\MainController:withdraw');

$app->add(function ($request, $response, $next) {
    try {
        $response = $next($request, $response);
        return $response->withHeader('Content-Type', 'application/json');
    } catch (\Exception $e) {
        $response->getBody()->write(json_encode([
            'error' => true,
            'response' => get_class($e) . ': ' . $e->getMessage(),
        ]));

        return $response->withHeader('Content-Type', 'application/json');
    }
});