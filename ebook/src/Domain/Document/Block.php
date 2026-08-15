<?php
declare(strict_types=1);

namespace AIT\Publishing\Domain\Document;

final readonly class Block
{
    public function __construct(
        public string $id,
        public string $type,
        public array $content = [],
        public array $configuration = [],
        public string $variant = 'default',
        public array $style = [],
        public bool $canSplit = true,
        public bool $keepWithNext = false,
    ) {}

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'content' => $this->content,
            'configuration' => $this->configuration,
            'variant' => $this->variant,
            'style' => $this->style,
            'pagination' => [
                'can_split' => $this->canSplit,
                'keep_with_next' => $this->keepWithNext,
            ],
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            (string) ($data['id'] ?? uniqid('block-', true)),
            (string) ($data['type'] ?? 'paragraph'),
            (array) ($data['content'] ?? []),
            (array) ($data['configuration'] ?? []),
            (string) ($data['variant'] ?? 'default'),
            (array) ($data['style'] ?? []),
            (bool) ($data['pagination']['can_split'] ?? true),
            (bool) ($data['pagination']['keep_with_next'] ?? false),
        );
    }
}
