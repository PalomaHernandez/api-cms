<?php

namespace App\Middleware;

use App\Services\JwtService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Response;

final class AuthorizationMiddleware implements MiddlewareInterface
{
	public function __construct(private readonly JwtService $jwtService)
	{
	}

	public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
	{
		$authHeader = $request->getHeaderLine('Authorization');

		if (empty($authHeader) || !str_starts_with($authHeader, 'Bearer ')) {
			return $this->unauthorized('Missing or invalid Authorization header');
		}

		$token = substr($authHeader, 7);

		try {
			$userData = $this->jwtService->decode($token);
		} catch (\Throwable $e) {
			return $this->unauthorized($e->getMessage());
		}

		$request = $request->withAttribute('user', $userData);
		return $handler->handle($request);
	}

	private function unauthorized(string $message): ResponseInterface
	{
		$response = new Response();
		$response->getBody()->write(json_encode(['error' => $message]));
		return $response->withStatus(401)->withHeader('Content-Type', 'application/json');
	}
}
