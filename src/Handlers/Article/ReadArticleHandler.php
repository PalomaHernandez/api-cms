<?php

namespace App\Handlers\Article;

use App\Abstracts\HandlerAbstract;
use App\Domain\Article\Service\ArticleService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ReadArticleHandler extends HandlerAbstract
{
    public function __construct(
        private readonly ArticleService $service,
    ) {
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        try {
            $articleId = $args['id'] ?? null;

            if (!$articleId) {
                return $this->respond(false, 'missing_article_id', [], 400);
            }

            $article = $this->service->findById($articleId);

            return $this->respond(true, 'article_retrieved', $article->toArray(), 200);

        } catch (\Throwable $exception) {
            return $this->respond(false, $exception->getMessage(), [], 500);
        }
    }
}
