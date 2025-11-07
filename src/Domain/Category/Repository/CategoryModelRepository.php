<?php

namespace App\Domain\Category\Repository;

use App\Domain\Category\Data\CreateCategoryData;
use App\Domain\Category\Data\UpdateCategoryData;
use App\Domain\Category\Data\CategoryData;
use App\Domain\Category\Repository\CategoryModel;
use App\Exceptions\CategoryNotFoundException;
use App\Exceptions\DeleteCategoryWithArticlesException;

class CategoryModelRepository implements CategoryRepositoryInterface
{
    public function create(CreateCategoryData $dto): CategoryData
    {
        $created = CategoryModel::create($dto->toArray());
        return (new CategoryData())->loadFromArray($created->toArray());
    }


    public function update(int $id, UpdateCategoryData $dto): CategoryData
    {
        $category = CategoryModel::find($id);

        if (!$category) {
            throw new CategoryNotFoundException("Category not found", 404);
        }

        $category->update($dto->toArray());

        return (new CategoryData())->loadFromArray($category->fresh()->toArray());
    }

    public function delete(int $id): bool
    {
        $category = CategoryModel::find($id);

        if (!$category) {
            throw new CategoryNotFoundException("Category not found", 404);
        }

        if ($category->articles->count() > 0) {
            throw new DeleteCategoryWithArticlesException("Cannot delete category with associated articles", 400);
        }

        return $category->delete();
    }

    public function findById(int $id): CategoryData
    {
        $category = CategoryModel::find($id);

        if (!$category) {
            throw new CategoryNotFoundException("Category not found", 404);
        }

        return (new CategoryData())->loadFromArray($category->toArray());
    }

    public function findAll(): array
    {
        $categories = CategoryModel::all();

        return $categories->map(
            fn($cat) =>
            (new CategoryData())->loadFromArray($cat->toArray())
        )->toArray();
    }
}
