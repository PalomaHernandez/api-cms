<?php

namespace App\Handlers\Category;

use App\Abstracts\HandlerAbstract;
use App\Domain\Category\Service\CategoryService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ListCategoriesHandler extends HandlerAbstract
{
    public function __construct(
        private readonly CategoryService $service,
    ) {
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        try {
            $categories = $this->service->findAll();

            $data = array_map(fn($category) => $category->toArray(), $categories);

            return $this->respond(true, 'categories_listed', $data, 200);
        } catch (\Throwable $exception) {
            return $this->respond(false, $exception->getMessage(), [], 500);
        }
    }
}
