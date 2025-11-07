<?php

namespace App\Domain\Article\Repository;


use App\Domain\Article\Data\UpdateArticleData;
use App\Domain\Article\Data\CreateArticleData;
use App\Domain\Article\Data\ArticleData;

interface ArticleRepositoryInterface
{
    public function create(CreateArticleData $data): ArticleData;
    public function update(int $id, UpdateArticleData $data): ArticleData;
    public function delete(int $id): bool;
    public function findById(int $id): ArticleData;
    public function findAll(): array;
}
