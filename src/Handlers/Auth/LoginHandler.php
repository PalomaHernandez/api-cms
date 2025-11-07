<?php

namespace App\Handlers\Auth;

use App\Abstracts\HandlerAbstract;
use App\Domain\User\Data\LoginUserData;
use App\Services\AuthService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class LoginHandler extends HandlerAbstract
{
    public function __construct(
        private readonly AuthService $authService,
    ) {
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        try {
            $username = $args['username'];
            $password = $args['password'];
            $dto = (new LoginUserData($username, $password));

            $accessToken = $this->authService->authenticate($dto);

            return $this->respond(true, 'login', ['access_token' => $accessToken], 201);
        } catch (\Throwable $exception) {
            return $this->respond(false, $exception->getMessage(), [], 500);
        }
    }

}