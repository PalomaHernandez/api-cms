<?php

namespace App\Domain\User\Data;

final class CreateUserData
{
    public ?string $name = null;
    public ?string $email = null;
    public ?string $password = null;
    public ?string $role = null;
    public ?bool $active = true;

    public function loadFromArray(array $data): self
    {
        $this->name = $data['name'] ?? null;
        $this->email = $data['email'] ?? null;
        $this->password = $data['password'] ?? null;
        $this->role = $data['role'] ?? 'editor';
        $this->active = isset($data['active']) ? (bool) $data['active'] : true;
        return $this;
    }

    public function validate(): void
    {
        if (empty($this->name) || empty($this->email) || empty($this->password)) {
            throw new \InvalidArgumentException('Name, email, and password are required.');
        }

        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Invalid email format.');
        }

        if (!in_array($this->role, ['admin', 'editor'], true)) {
            throw new \InvalidArgumentException('Invalid role type.');
        }
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'password' => password_hash($this->password, PASSWORD_BCRYPT),
            'role' => $this->role,
            'active' => $this->active,
        ];
    }
}
