<?php

namespace App\Domain\Article\Data;

final class UpdateArticleData
{
    public ?string $title = null;
    public ?string $content = null;
    public ?string $status = null;
    public array $categories = [];
    public ?string $slug;


    public function loadFromArray(array $data): self
    {
        $this->title = $data['title'] ?? null;
        $this->content = $data['content'] ?? null;
        $this->status = $data['status'] ?? null;
        $this->categories = $data['categories'] ?? [];

        return $this;
    }

    public function validate(): void
    {
        if (empty($this->id)) {
            throw new \InvalidArgumentException('Article ID is required for update');
        }

        if ($this->status !== null && !in_array($this->status, ['draft', 'published'])) {
            throw new \InvalidArgumentException('Invalid status value');
        }
    }

    public function toArray(): array
    {
        return array_filter([
            'title' => $this->title,
            'content' => $this->content,
            'status' => $this->status,
        ], fn($value) => $value !== null);
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;
        return $this;
    }
}
