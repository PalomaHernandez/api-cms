<?php

namespace App\Domain\ArticleCategory\Service;

use App\Domain\ArticleCategory\Data\SetArticleCategoryData;
use App\Domain\ArticleCategory\Repository\ArticleCategoryRepositoryInterface;

class ArticleCategoryService
{
    public function __construct(
        private readonly ArticleCategoryRepositoryInterface $articleCategoryRepository
    ) {
    }

    /**
     * Sincroniza las categorías de un artículo.
     * Elimina las existentes y agrega las nuevas.
     */
    public function syncCategories(int $articleId, array $categoryIds): void
    {
        $articleCategoryData = new SetArticleCategoryData(
            $articleId,
            $categoryIds
        );

        $this->articleCategoryRepository->set($articleCategoryData);

    }

    /**
     * Devuelve los IDs de categorías asociadas a un artículo.
     */
    public function getCategoriesByArticleId(int $articleId): array
    {
        return $this->articleCategoryRepository->getByArticle($articleId);
    }
}
