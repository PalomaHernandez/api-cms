<?php

namespace App\Domain\User\Repository;

use App\Domain\User\Data\UserData;
use App\Domain\User\Repository\UserModel;
use App\Exceptions\UserNotFoundException;
use App\Domain\User\Data\CreateUserData;
use App\Domain\User\Data\UpdateUserData;

class UserModelRepository implements UserRepositoryInterface
{
    public function create(CreateUserData $dto): UserData
    {
        $created = UserModel::create($dto->toArray());
        return (new UserData())->loadFromArray($created->toArray());
    }

    public function update(int $id, UpdateUserData $dto): UserData
    {
        $user = UserModel::where('id', $id)->first();
        if (!$user) {
            throw new UserNotFoundException("User not found", 404);
        }

        $user->update($dto->toArray());

        return (new UserData())->loadFromArray($user->toArray());
    }

    public function delete(int $id): bool
    {
        $user = UserModel::where('id', $id)->first();

        if (!$user) {
            throw new UserNotFoundException("User not found", 404);
        }

        return $user->delete();
    }

    public function findById(int $id): ?UserData
    {
        $user = UserModel::where('id', $id)->first();

        if (!$user) {
            throw new UserNotFoundException("User not found", 404);
        }

        return (new UserData())->loadFromArray($user->toArray());
    }

    public function findByEmail(string $email): ?UserData
    {
        $user = UserModel::where('email', $email)->first();


        if (!$user) {
            throw new UserNotFoundException("User not found", 404);
        }

        return (new UserData())->loadFromArray($user->toArray());
    }

    public function findAll(): array
    {
        return UserModel::all()
            ->map(fn($u) => (new UserData())->loadFromArray($u->toArray()))
            ->toArray();
    }
}
