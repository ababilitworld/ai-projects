<?php
declare(strict_types=1);

namespace AIT\Publishing\Domain\Document;

use AIT\Publishing\Support\Uuid;

final readonly class Document
{
    /** @param Chapter[] $chapters */
    public function __construct(
        public string $schemaVersion,
        public string $id,
        public string $title,
        public string $template,
        public string $theme,
        public array $metadata,
        public array $chapters,
    ) {}

    public function toArray(): array
    {
        return [
            'schema_version' => $this->schemaVersion,
            'id' => $this->id,
            'title' => $this->title,
            'template' => $this->template,
            'theme' => $this->theme,
            'metadata' => $this->metadata,
            'chapters' => array_map(static fn(Chapter $chapter) => $chapter->toArray(), $this->chapters),
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            (string) ($data['schema_version'] ?? '1.0.0'),
            (string) $data['id'],
            (string) $data['title'],
            (string) ($data['template'] ?? 'professional'),
            (string) ($data['theme'] ?? 'ait-pha'),
            (array) ($data['metadata'] ?? []),
            array_map(static fn(array $chapter) => Chapter::fromArray($chapter), $data['chapters'] ?? [])
        );
    }

    public static function demo(): self
    {
        $chapter = new Chapter(
            Uuid::v4(),
            'Introduction',
            [
                new Block(Uuid::v4(), 'heading', ['text' => 'A Professional Publishing Foundation'], [], 'chapter'),
                new Block(Uuid::v4(), 'paragraph', ['text' => 'This document demonstrates the file-based document model, reusable blocks and deterministic page planning.']),
                new Block(Uuid::v4(), 'panel', ['title' => 'Architecture', 'text' => 'Content remains independent from pages. Templates, themes and pagination produce the final page collection.']),
                new Block(Uuid::v4(), 'paragraph', ['text' => 'The system is designed for local small-to-medium publishing projects and does not require a database.']),
            ]
        );

        return new self(
            '1.0.0',
            'demo-book',
            'AIT Professional Publishing System',
            'professional',
            'ait-pha',
            ['author' => 'Ababil IT', 'description' => 'File-based publishing engine demonstration'],
            [$chapter]
        );
    }
}
