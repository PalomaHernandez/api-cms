<?php

use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use App\Middleware\AuthorizationMiddleware;
use App\Handlers\Auth\LoginHandler;
use App\Handlers\User\ListUsersHandler;
use App\Handlers\User\ReadUserHandler;
use App\Handlers\User\CreateUserHandler;
use App\Handlers\User\UpdateUserHandler;
use App\Handlers\User\DeleteUserHandler;
use App\Handlers\Category\ListCategoriesHandler;
use App\Handlers\Category\ReadCategoryHandler;
use App\Handlers\Category\CreateCategoryHandler;
use App\Handlers\Category\UpdateCategoryHandler;
use App\Handlers\Category\DeleteCategoryHandler;
use App\Handlers\Article\ListArticlesHandler;
use App\Handlers\Article\ReadArticleHandler;
use App\Handlers\Article\CreateArticleHandler;
use App\Handlers\Article\UpdateArticleHandler;
use App\Handlers\Article\DeleteArticleHandler;

return function (App $app) {
    $app->post('/login', LoginHandler::class);

    $app->group('', function (RouteCollectorProxy $group) {
        $group->group('/users', function (RouteCollectorProxy $users) {
            $users->get('', ListUsersHandler::class);
            $users->get('/{id}', ReadUserHandler::class);
            $users->post('', CreateUserHandler::class);
            $users->put('/{id}', UpdateUserHandler::class);
            $users->delete('/{id}', DeleteUserHandler::class);
        });
        $group->group('/categories', function (RouteCollectorProxy $categories) {
            $categories->get('', ListCategoriesHandler::class);
            $categories->get('/{id}', ReadCategoryHandler::class);
            $categories->post('', CreateCategoryHandler::class);
            $categories->put('/{id}', UpdateCategoryHandler::class);
            $categories->delete('/{id}', DeleteCategoryHandler::class);
        });
        $group->group('/articles', function (RouteCollectorProxy $articles) {
            $articles->get('', ListArticlesHandler::class);
            $articles->get('/{id}', ReadArticleHandler::class);
            $articles->post('', CreateArticleHandler::class);
            $articles->put('/{id}', UpdateArticleHandler::class);
            $articles->delete('/{id}', DeleteArticleHandler::class);
        });
    })->add(AuthorizationMiddleware::class);
};
