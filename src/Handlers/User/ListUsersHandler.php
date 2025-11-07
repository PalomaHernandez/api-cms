<?php

namespace App\Handlers\User;

use App\Abstracts\HandlerAbstract;
use App\Domain\User\Service\UserService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ListUsersHandler extends HandlerAbstract
{
    public function __construct(
        private readonly UserService $service,
    ) {
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        try {
            $users = $this->service->findAll();

            return $this->respond(true, 'users_listed', $users, 200);

        } catch (\Throwable $exception) {
            return $this->respond(false, $exception->getMessage(), [], 500);
        }
    }
}
