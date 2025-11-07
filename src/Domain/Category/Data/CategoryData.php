<?php

namespace App\Domain\Category\Data;

final class CategoryData
{
    public ?int $id = null;
    public ?string $name = null;
    public ?string $description = null;
    public ?bool $status;

    public function loadFromArray(array $data): self
    {
        $this->id = $data['id'] ?? null;
        $this->name = $data['name'] ?? null;
        $this->description = $data['description'] ?? null;
        $this->status = $data['status'] ?? null;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'status' => $this->status,
        ];
    }
}
