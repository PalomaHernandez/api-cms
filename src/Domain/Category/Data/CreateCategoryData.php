<?php

namespace App\Domain\Category\Data;

final class CreateCategoryData
{
    public ?string $name = null;
    public ?string $description = null;
    public ?bool $status;

    public function loadFromArray(array $data): self
    {
        $this->name = $data['name'] ?? null;
        $this->description = $data['description'] ?? null;
        $this->status = $data['status'];

        return $this;
    }

    public function validate(): void
    {
        if (empty($this->name)) {
            throw new \InvalidArgumentException('Category name is required');
        }
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'status' => $this->status,
        ];
    }
}
