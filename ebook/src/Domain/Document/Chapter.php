<?php
declare(strict_types=1);

namespace AIT\Publishing\Domain\Document;

final readonly class Chapter
{
    /** @param Block[] $blocks */
    public function __construct(
        public string $id,
        public string $title,
        public array $blocks = []
    ) {}

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'blocks' => array_map(static fn(Block $block) => $block->toArray(), $this->blocks),
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            (string) $data['id'],
            (string) $data['title'],
            array_map(static fn(array $block) => Block::fromArray($block), $data['blocks'] ?? [])
        );
    }
}
