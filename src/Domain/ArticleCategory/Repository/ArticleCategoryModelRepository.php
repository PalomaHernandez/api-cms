<?php

namespace App\Domain\ArticleCategory\Repository;

use App\Domain\ArticleCategory\Data\SetArticleCategoryData;
use Illuminate\Database\Capsule\Manager as DB;
use Throwable;

class ArticleCategoryModelRepository implements ArticleCategoryRepositoryInterface
{
    /**
     * @throws Throwable
     */
    public function set(SetArticleCategoryData $data): void
    {
        try {
            DB::connection()->beginTransaction();

            DB::table('article_categories')
                ->where('article_id', $data->getArticleId())
                ->delete();

            foreach ($data->getCategoryIds() as $categoryId) {
                DB::table('article_categories')->insert([
                    'article_id' => $data->getArticleId(),
                    'category_id' => $categoryId,
                ]);
            }

            DB::connection()->commit();
        } catch (Throwable $e) {
            DB::connection()->rollBack();
            throw $e;
        }
    }

    public function getByArticle(int $articleId): array
    {
        return DB::table('article_categories as ac')
            ->join('categories as c', 'c.id', '=', 'ac.category_id')
            ->where('ac.article_id', $articleId)
            ->pluck('c.id')
            ->toArray();
    }
}
