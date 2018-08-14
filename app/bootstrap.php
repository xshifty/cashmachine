<?php
include __DIR__ . '/../vendor/autoload.php';

final class Bootstrap
{
    private static $app = null;
    private static $settings = null;
    
    public static function init()
    {
        if (empty(self::$app)) {
            $app = new \Slim\App([
                'determineRouteBeforeAppMiddleware' => true,
                'displayErrorDetails' => true,
            ]);
           
            $container = $app->getContainer();
            
            include __DIR__ . '/config/container.php';
            include __DIR__ . '/config/routes.php';

            self::$app = $app;
        }
        
        return self::$app;
    }
}
