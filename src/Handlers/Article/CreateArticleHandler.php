<?php

namespace App\Handlers\Article;

use App\Abstracts\HandlerAbstract;
use App\Domain\Article\Data\CreateArticleData;
use App\Domain\Article\Service\ArticleService;
use App\Exceptions\InactiveUserException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class CreateArticleHandler extends HandlerAbstract
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
                throw new InactiveUserException('Inactive users cannot create articles', 400);
            }

            $data = $request->getParsedBody() ?? [];

            $dto = (new CreateArticleData())->loadFromArray($data);
            $dto->setAuthorId($user->id);

            $article = $this->service->create($dto);

            return $this->respond(true, 'article_created', $article->toArray(), 201);

        } catch (\Throwable $exception) {
            return $this->respond(false, $exception->getMessage(), [], 500);
        }
    }
}
