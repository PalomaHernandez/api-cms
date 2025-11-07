<?php

namespace App\Domain\Article\Service;

use App\Domain\Article\Data\ArticleData;
use App\Domain\Article\Data\CreateArticleData;
use App\Domain\Article\Data\UpdateArticleData;
use App\Domain\Article\Repository\ArticleRepositoryInterface;
use App\Domain\ArticleCategory\Service\ArticleCategoryService;
use Cocur\Slugify\Slugify;

final class ArticleService
{
    public function __construct(
        private readonly ArticleRepositoryInterface $repository,
        private readonly ArticleCategoryService $articleCategoryService
    ) {
    }

    /**
     * Crear un nuevo artículo
     */
    public function create(CreateArticleData $dto): ArticleData
    {
        $dto->validate();

        $slugify = new Slugify();
        $slug = $slugify->slugify($dto->title);
        $dto->setSlug($slug);

        $article = $this->repository->create($dto);

        if (!empty($dto->categories)) {
            $this->articleCategoryService->syncCategories($article->id, $dto->categories);
        }

        return $article;
    }

    /**
     * Obtener un artículo por su ID
     */
    public function findById(int $id): ArticleData
    {
        return $this->repository->findById($id);
    }

    /**
     * Listar todos los artículos
     */
    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    /**
     * Actualizar un artículo existente
     */
    public function update(int $id, UpdateArticleData $dto): ArticleData
    {
        $dto->validate();

        if ($dto->title) {
            $slugify = new Slugify();
            $dto->setSlug($slugify->slugify($dto->title));
        }

        $article = $this->repository->update($id, $dto);

        if (!empty($dto->categories)) {
            $this->articleCategoryService->syncCategories($id, $dto->categories);
        }

        return $article;
    }

    /**
     * Eliminar un artículo
     */
    public function delete(int $id): bool
    {
        return $this->repository->delete($id);
    }
}
