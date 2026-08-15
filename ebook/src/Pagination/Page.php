<?php
declare(strict_types=1);

namespace AIT\Publishing\Pagination;

use AIT\Publishing\Domain\Document\Block;

final readonly class Page
{
    /** @param Block[] $blocks */
    public function __construct(
        public int $number,
        public float $width,
        public float $height,
        public float $marginTop,
        public float $marginRight,
        public float $marginBottom,
        public float $marginLeft,
        public array $blocks = [],
    ) {}

    public function bodyHeight(): float
    {
        return $this->height - $this->marginTop - $this->marginBottom;
    }
}
