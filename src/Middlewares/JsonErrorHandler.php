<?php

namespace App\Middlewares;

use App\Factory\AppFactory;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Handlers\ErrorHandler;

class JsonErrorHandler
{

    public function __invoke(ServerRequestInterface $request, \Throwable $exception, bool $showErrorsDetail): \Psr\Http\Message\ResponseInterface
    {
        $payload = [
            'ts' => time(),
            'success' => false,
            'message' => $exception->getMessage(),
            'code' => $exception->getCode(),
        ];

        if ($showErrorsDetail) {
            $payload['result'] = $exception->getTrace();
        }

        $response = AppFactory::$app->getResponseFactory()->createResponse();
        $response->getBody()->write(json_encode($payload, JSON_UNESCAPED_UNICODE));

        return $response->withHeader('Content-Type', 'application/json');
    }
}