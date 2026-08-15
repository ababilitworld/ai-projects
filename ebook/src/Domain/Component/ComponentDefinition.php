<?php
declare(strict_types=1);

namespace AIT\Publishing\Domain\Component;

final readonly class ComponentDefinition
{
    public function __construct(
        public string $type,
        public string $name,
        public string $category,
        public string $version,
        public bool $canSplit = true,
        public bool $repeatHeader = false,
    ) {}
}
