<?php

namespace App\Handlers\Category;

use App\Abstracts\HandlerAbstract;
use App\Domain\Category\Service\CategoryService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class DeleteCategoryHandler extends HandlerAbstract
{
    public function __construct(
        private readonly CategoryService $service,
    ) {
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        try {
            $categoryId = $args['id'] ?? null;

            if (!$categoryId) {
                return $this->respond(false, 'missing_category_id', [], 400);
            }

            $this->service->delete($categoryId);

            return $this->respond(true, 'category_deleted', [], 200);
        } catch (\Throwable $exception) {
            return $this->respond(false, $exception->getMessage(), [], 500);
        }
    }
}
