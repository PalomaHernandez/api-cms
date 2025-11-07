<?php

namespace App\Domain\Category\Repository;

use App\Domain\Category\Data\CategoryData;
use App\Domain\Category\Data\CreateCategoryData;
use App\Domain\Category\Data\UpdateCategoryData;

interface CategoryRepositoryInterface
{
    public function create(CreateCategoryData $data): CategoryData;
    public function update(int $id, UpdateCategoryData $data): CategoryData;
    public function delete(int $id): bool;
    public function findById(int $id): CategoryData;
    public function findAll(): array;
}
