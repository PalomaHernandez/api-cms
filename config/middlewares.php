<?php
return function (\Slim\App $app) {

    $errorMiddleware = $app->addErrorMiddleware(true, true, true);
    $errorMiddleware->setDefaultErrorHandler(new \App\Middlewares\JsonErrorHandler());

    $app->addBodyParsingMiddleware();
    $app->addRoutingMiddleware();

};