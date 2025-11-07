<?php

namespace App\Handlers\User;

use App\Abstracts\HandlerAbstract;
use App\Domain\User\Data\CreateUserData;
use App\Domain\User\Service\UserService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class CreateUserHandler extends HandlerAbstract
{
    public function __construct(
        private readonly UserService $service,
    ) {
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        try {
            $data = $request->getParsedBody() ?? [];

            $dto = (new CreateUserData())->loadFromArray($data);

            $user = $this->service->create($dto);

            return $this->respond(true, 'user_created', $user->toArray(), 201);

        } catch (\Throwable $exception) {
            return $this->respond(false, $exception->getMessage(), [], 500);
        }
    }
}
