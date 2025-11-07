<?php

use App\Domain\Article\Repository\ArticleModelRepository;
use App\Domain\Article\Service\ArticleService;
use App\Domain\ArticleCategory\Repository\ArticleCategoryModelRepository;
use App\Domain\ArticleCategory\Service\ArticleCategoryService;
use App\Domain\Category\Repository\CategoryModelRepository;
use App\Domain\Category\Service\CategoryService;
use App\Domain\User\Repository\UserModelRepository;
use App\Domain\User\Service\UserService;
use App\Middleware\AuthorizationMiddleware;
use App\Services\JwtService;
use DI\ContainerBuilder;
use Slim\App;
use Psr\Container\ContainerInterface;
use Slim\Factory\AppFactory;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        'settings' => function (ContainerInterface $container) {
            $settings = require_once __DIR__ . '/settings.php';
            date_default_timezone_set($settings['timezone']);
            return $settings;
        },

        App::class => function (ContainerInterface $container) {
            $app = AppFactory::createFromContainer($container);
            (require_once __DIR__ . '/middlewares.php')($app);
            (require_once __DIR__ . '/routes.php')($app);
            (require_once __DIR__ . '/database.php');

            return $app;
        },

        AuthorizationMiddleware::class => function (ContainerInterface $container) {
            return new AuthorizationMiddleware(
                new JwtService()
            );
        },

        ArticleCategoryService::class => function (ContainerInterface $container) {
            return new ArticleCategoryService(
                new ArticleCategoryModelRepository()
            );
        },

        ArticleService::class => function (ContainerInterface $container) {
            return new ArticleService(
                new ArticleModelRepository(),
                $this->container(ArticleCategoryService::class)
            );
        },

        UserService::class => function (ContainerInterface $container) {
            return new UserService(
                new UserModelRepository()
            );
        },

        ArticleService::class => function (ContainerInterface $container) {
            return new ArticleService(
                new ArticleModelRepository(),
                $this->container(ArticleCategoryService::class)
            );
        },

        CategoryService::class => function (ContainerInterface $container) {
            return new CategoryService(
                new CategoryModelRepository()
            );
        },
    ]);
};