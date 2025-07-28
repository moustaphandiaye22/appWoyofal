<?php

namespace App\Core;

use App\Core\Abstract\Singleton;

class App extends Singleton
{
    private static ?Container $container = null;
    private static bool $initialized = false;

    public static function initialize(): void
    {
        if (!self::$initialized) {
            self::$container = Container::getInstance();
            
            // Enregistrer les services
            $serviceProvider = new ServiceProvider(self::$container);
            $serviceProvider->register();
            
            self::$initialized = true;
        }
    }

    public static function get(string $serviceName)
    {
        self::initialize();
        
        // Mapping des anciens noms vers les nouvelles classes
        $serviceMap = [
            'AchatController' => \App\Controller\AchatController::class,
            'ClientController' => \App\Controller\ClientController::class,
            'JournalController' => \App\Controller\JournalController::class,
        ];

        $className = $serviceMap[$serviceName] ?? $serviceName;
        
        return self::$container->resolve($className);
    }

    public static function getContainer(): Container
    {
        self::initialize();
        return self::$container;
    }

    // Pour compatibilité descendante
    public static function getDependency(string $key): mixed
    {
        return self::get($key);
    }
}
