<?php

namespace App\Domain\ArticleCategory\Repository;

use App\Domain\ArticleCategory\Data\SetArticleCategoryData;

interface ArticleCategoryRepositoryInterface
{
    public function set(SetArticleCategoryData $data): void;
    public function getByArticle(int $articleId): array;
}
