<?php

namespace App\Domain\User\Service;

use App\Domain\User\Repository\UserRepositoryInterface;
use App\Domain\User\Data\UserData;
use App\Domain\User\Data\CreateUserData;
use App\Domain\User\Data\UpdateUserData;

final class UserService
{
    public function __construct(
        private readonly UserRepositoryInterface $repository
    ) {
    }

    public function create(CreateUserData $dto): UserData
    {
        $dto->validate();
        return $this->repository->create($dto);
    }

    public function update(int $id, UpdateUserData $dto): UserData
    {
        $dto->validate();
        return $this->repository->update($id, $dto);
    }

    public function delete(int $id): bool
    {
        return $this->repository->delete($id);
    }

    public function findById(int $id): ?UserData
    {
        return $this->repository->findById($id);
    }

    public function findByEmail(string $email): ?UserData
    {
        return $this->repository->findByEmail($email);
    }

    public function findAll(): array
    {
        return $this->repository->findAll();
    }
}
