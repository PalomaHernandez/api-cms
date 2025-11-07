<?php

namespace App\Handlers\Article;

use App\Abstracts\HandlerAbstract;
use App\Domain\Article\Data\UpdateArticleData;
use App\Domain\Article\Service\ArticleService;
use App\Exceptions\InactiveUserException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class UpdateArticleHandler extends HandlerAbstract
{
    public function __construct(
        private readonly ArticleService $service,
    ) {
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        try {
            $user = $request->getAttribute('user');

            if (!$user->isActive) {
                throw new InactiveUserException('Inactive users cannot update articles', 400);
            }

            $articleId = $args['id'] ?? null;

            if (!$articleId) {
                return $this->respond(false, 'missing_article_id', [], 400);
            }

            $data = $request->getParsedBody() ?? [];

            $dto = (new UpdateArticleData())->loadFromArray($data);

            $article = $this->service->update($articleId, $dto);

            return $this->respond(true, 'article_updated', $article->toArray(), 200);

        } catch (\Throwable $exception) {
            return $this->respond(false, $exception->getMessage(), [], 500);
        }
    }
}
