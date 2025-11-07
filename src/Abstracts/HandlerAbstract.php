<?php

namespace App\Abstracts;

use App\Factory\AppFactory;

abstract class HandlerAbstract
{
    public function respond(bool $success, string $message, array $result, int $code,): \Psr\Http\Message\MessageInterface|\Psr\Http\Message\ResponseInterface
    {
        $response = AppFactory::$app->getResponseFactory()->createResponse();

        $payload = [
            'ts' => time(),
            'success' => $success,
            'message' => $message,
            'code' => $code,
            'result' => $result,
        ];

        $response->getBody()->write(json_encode($payload));
        return $response->withHeader('Content-Type', 'application/json')->withStatus($code);
    }
}