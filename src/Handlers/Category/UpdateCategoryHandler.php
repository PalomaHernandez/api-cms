<?php

namespace App\Handlers\Category;

use App\Abstracts\HandlerAbstract;
use App\Domain\Category\Data\UpdateCategoryData;
use App\Domain\Category\Service\CategoryService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class UpdateCategoryHandler extends HandlerAbstract
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

            $data = $request->getParsedBody() ?? [];

            $dto = (new UpdateCategoryData())->loadFromArray($data);

            $category = $this->service->update($categoryId, $dto);

            return $this->respond(true, 'category_updated', $category->toArray(), 200);
        } catch (\Throwable $exception) {
            return $this->respond(false, $exception->getMessage(), [], 500);
        }
    }
}
