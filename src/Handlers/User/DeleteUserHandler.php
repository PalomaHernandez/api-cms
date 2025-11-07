<?php

namespace App\Handlers\User;

use App\Abstracts\HandlerAbstract;
use App\Domain\User\Service\UserService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class DeleteUserHandler extends HandlerAbstract
{
    public function __construct(
        private readonly UserService $service,
    ) {
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        try {
            $id = (int) ($args['id']);

            if (!$id) {
                return $this->respond(false, 'missing_user_id', [], 400);
            }

            $this->service->delete($id);

            return $this->respond(true, 'user_deleted', [], 200);

        } catch (\Throwable $exception) {
            return $this->respond(false, $exception->getMessage(), [], 500);
        }
    }
}
