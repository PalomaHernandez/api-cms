<?php

namespace App\Handlers\Article;

use App\Abstracts\HandlerAbstract;
use App\Domain\Article\Service\ArticleService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class DeleteArticleHandler extends HandlerAbstract
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
                return $this->respond(false, 'article_id_missing', [], 400);
            }

            $this->service->delete($articleId);

            return $this->respond(true, 'article_deleted', [], 200);

        } catch (\Throwable $exception) {
            return $this->respond(false, $exception->getMessage(), [], 500);
        }
    }
}
