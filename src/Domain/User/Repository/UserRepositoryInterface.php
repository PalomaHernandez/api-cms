<?php

namespace App\Domain\User\Repository;

use App\Domain\User\Data\UserData;
use App\Domain\User\Data\CreateUserData;
use App\Domain\User\Data\UpdateUserData;

interface UserRepositoryInterface
{
    public function create(CreateUserData $data): UserData;
    public function update(int $id, UpdateUserData $data): UserData;
    public function delete(int $id): bool;
    public function findById(int $id): ?UserData;
    public function findByEmail(string $email): ?UserData;
    public function findAll(): array;
}
