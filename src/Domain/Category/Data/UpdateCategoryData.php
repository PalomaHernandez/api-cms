<?php

namespace App\Domain\Category\Data;

class UpdateCategoryData
{
    public ?string $name = null;
    public ?string $description = null;
    public ?bool $status;

    public function validate(): void
    {
        if (empty($this->name)) {
            throw new \InvalidArgumentException('Category name cannot be empty');
        }
    }

    public function loadFromArray(array $data): self
    {
        $this->name = $data['name'] ?? null;
        $this->description = $data['description'] ?? null;
        $this->status = isset($data['status']) ? (bool) $data['status'] : null;

        return $this;
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
