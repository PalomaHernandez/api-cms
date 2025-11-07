<?php

namespace App\Handlers\User;

use App\Abstracts\HandlerAbstract;
use App\Domain\User\Data\UpdateUserData;
use App\Domain\User\Service\UserService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class UpdateUserHandler extends HandlerAbstract
{
    public function __construct(
        private readonly UserService $service,
    ) {
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        try {
            $id = (int) ($args['id']);
            $data = $request->getParsedBody() ?? [];

            if (!$id) {
                return $this->respond(false, 'missing_user_id', [], 400);
            }

            $dto = (new UpdateUserData())->loadFromArray($data);

            $user = $this->service->update($id, $dto);

            return $this->respond(true, 'user_updated', $user->toArray(), 200);

        } catch (\Throwable $exception) {
            return $this->respond(false, $exception->getMessage(), [], 500);
        }
    }
}
