<?php

namespace App\Domain\ArticleCategory\Data;

final class SetArticleCategoryData
{
    public function __construct(
        private int $articleId,
        private array $categoryIds
    ) {
    }

    public function getArticleId(): int
    {
        return $this->articleId;
    }

    public function getCategoryIds(): array
    {
        return $this->categoryIds;
    }
}
