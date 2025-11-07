<?php

namespace App\Domain\Article\Data;

final class CreateArticleData
{
    public ?string $title = null;
    public ?string $content = null;
    public ?string $status = null;
    public ?int $authorId = null;
    public array $categories = [];
    public ?string $slug;

    public function loadFromArray(array $data): self
    {
        $this->title = $data['title'] ?? null;
        $this->content = $data['content'] ?? null;
        $this->status = $data['status'] ?? 'draft';
        $this->categories = $data['categories'] ?? [];

        return $this;
    }

    public function validate(): void
    {
        if (empty($this->title)) {
            throw new \InvalidArgumentException('Title is required');
        }

        if (empty($this->authorId)) {
            throw new \InvalidArgumentException('Author ID is required');
        }
    }

    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'content' => $this->content,
            'status' => $this->status,
            'author_id' => $this->authorId,
            'categories' => $this->categories,
        ];
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;
        return $this;
    }

    public function setAuthorId(?int $id): self
    {
        $this->authorId = $id;
        return $this;
    }
}
