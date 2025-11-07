<?php

namespace App\Domain\User\Data;

final class UpdateUserData
{
    public ?int $id = null;
    public ?string $name = null;
    public ?string $email = null;
    public ?string $role = null;
    public ?bool $active = null;

    public function loadFromArray(array $data): self
    {
        $this->name = $data['name'] ?? null;
        $this->email = $data['email'] ?? null;
        $this->role = $data['role'] ?? null;
        $this->active = isset($data['active']) ? (bool) $data['active'] : null;

        return $this;
    }

    public function validate(): void
    {
        if ($this->email && !filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Invalid email format.');
        }
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'active' => $this->active,
        ];
    }
}
