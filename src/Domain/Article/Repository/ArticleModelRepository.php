<?php

namespace App\Domain\Article\Repository;

use App\Domain\Article\Data\UpdateArticleData;
use App\Domain\Article\Data\CreateArticleData;
use App\Domain\Article\Data\ArticleData;
use App\Domain\Article\Repository\ArticleModel;
use App\Exceptions\ArticleNotFoundException;
use Carbon\Carbon;

class ArticleModelRepository implements ArticleRepositoryInterface
{

    public function create(CreateArticleData $dto): ArticleData
    {
        $created = ArticleModel::create([
            'title' => $dto->title,
            'content' => $dto->content,
            'slug' => $dto->slug,
            'status' => $dto->status,
            'author_id' => $dto->authorId,
            'published_at' => $dto->status === 'published' ? Carbon::now() : null,
        ]);

        return (new ArticleData())->loadFromArray($created->toArray());
    }

    public function findById(int $id): ArticleData
    {
        $article = ArticleModel::with('categories', 'author')->find($id);

        if (!$article) {
            throw new ArticleNotFoundException("Article not found", 404);
        }

        return (new ArticleData())->loadFromArray($article->toArray());
    }

    public function findAll(): array
    {
        return ArticleModel::with('categories', 'author')
            ->get()
            ->map(fn($a) => (new ArticleData())->loadFromArray($a->toArray()))
            ->toArray();
    }

    public function delete(int $id): bool
    {
        $article = ArticleModel::with('categories')->find($id);

        if (!$article) {
            throw new ArticleNotFoundException("Article not found", 404);
        }

        return $article->delete();
    }

    public function update(int $id, UpdateArticleData $dto): ArticleData
    {
        $article = ArticleModel::find($id);

        if (!$article) {
            throw new ArticleNotFoundException("Article not found", 404);
        }

        $article->update([
            'title' => $dto->title,
            'content' => $dto->content,
            'slug' => $dto->slug,
            'status' => $dto->status,
            'published_at' => $dto->status === 'published' ? Carbon::now() : null,
        ]);

        return (new ArticleData())->loadFromArray($article->toArray());
    }
}
