<?php

namespace App\Domain\Category\Service;

use App\Domain\Category\Data\CategoryData;
use App\Domain\Category\Data\CreateCategoryData;
use App\Domain\Category\Data\UpdateCategoryData;
use App\Domain\Category\Repository\CategoryRepositoryInterface;

final class CategoryService
{
    public function __construct(
        private readonly CategoryRepositoryInterface $repository
    ) {
    }

    public function create(CreateCategoryData $dto): CategoryData
    {
        $dto->validate();

        return $this->repository->create($dto);
    }

    public function update(int $id, UpdateCategoryData $dto): CategoryData
    {
        $dto->validate();

        return $this->repository->update($id, $dto);
    }

    public function delete(int $id): bool
    {
        return $this->repository->delete($id);
    }

    public function findById(int $id): CategoryData
    {
        return $this->repository->findById($id);
    }

    public function findAll(): array
    {
        return $this->repository->findAll();
    }
}
