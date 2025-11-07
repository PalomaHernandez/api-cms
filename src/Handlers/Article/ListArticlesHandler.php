<?php

namespace App\Handlers\Article;

use App\Abstracts\HandlerAbstract;
use App\Domain\Article\Service\ArticleService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ListArticlesHandler extends HandlerAbstract
{
    public function __construct(
        private readonly ArticleService $service,
    ) {
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        try {
            $articles = $this->service->findAll();

            return $this->respond(true, 'articles_listed', $articles, 200);

        } catch (\Throwable $exception) {
            return $this->respond(false, $exception->getMessage(), [], 500);
        }
    }
}
