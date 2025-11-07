<?php

namespace App\Factory;

use DI\ContainerBuilder;
use DI\DependencyException;
use DI\NotFoundException;
use Exception;
use Slim\App;

final class AppFactory
{
    public static App $app;

    /**
     * @throws DependencyException
     * @throws NotFoundException
     * @throws Exception
     */
    public static function create(): App
    {
        $containerBuilder = new ContainerBuilder();

        // Configura el contenedor
        (require __DIR__ . '/../../config/container.php')($containerBuilder);

        // Construye el contenedor y crea la aplicación
        $container = $containerBuilder->build();
        self::$app = $container->get(App::class);

        return self::$app;
    }
}