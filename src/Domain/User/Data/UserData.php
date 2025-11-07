<?php

namespace App\Domain\User\Data;

final class UserData
{
    public ?int $id = null;
    public ?string $name = null;
    public ?string $email = null;
    public ?string $password = null;
    public bool $isActive = true;

    public function loadFromArray(array $data): self
    {
        $this->id = $data['id'] ?? null;
        $this->name = $data['name'] ?? null;
        $this->email = $data['email'] ?? null;
        $this->password = $data['password'] ?? null;
        $this->isActive = $data['is_active'] ?? true;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }
}
