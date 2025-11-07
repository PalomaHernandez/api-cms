<?php

namespace App\Domain\Article\Data;

final class ArticleData
{
    public ?int $id = null;
    public ?string $title = null;
    public ?string $content = null;
    public ?string $slug = null;
    public ?string $status = null;
    public ?string $publishedAt = null;
    public ?int $authorId = null;
    public array $categories = [];

    public function loadFromArray(array $data): self
    {
        $this->id = $data['id'] ?? null;
        $this->title = $data['title'] ?? null;
        $this->content = $data['content'] ?? null;
        $this->slug = $data['slug'] ?? null;
        $this->status = $data['status'] ?? null;
        $this->publishedAt = $data['published_at'] ?? null;
        $this->authorId = $data['author_id'] ?? null;
        $this->categories = $data['categories'] ?? [];

        return $this;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'slug' => $this->slug,
            'status' => $this->status,
            'published_at' => $this->publishedAt,
            'author_id' => $this->authorId,
            'categories' => $this->categories,
        ];
    }
}
