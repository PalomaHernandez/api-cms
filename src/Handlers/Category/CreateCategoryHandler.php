<?php

namespace App\Handlers\Category;

use App\Abstracts\HandlerAbstract;
use App\Domain\Category\Data\CreateCategoryData;
use App\Domain\Category\Service\CategoryService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class CreateCategoryHandler extends HandlerAbstract
{
    public function __construct(
        private readonly CategoryService $service,
    ) {
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        try {
            $data = $request->getParsedBody() ?? [];

            $dto = (new CreateCategoryData())->loadFromArray($data);

            $category = $this->service->create($dto);

            return $this->respond(true, 'category_created', $category->toArray(), 201);
        } catch (\Throwable $exception) {
            return $this->respond(false, $exception->getMessage(), [], 500);
        }
    }
}
