<?php
declare(strict_types=1);

namespace AIT\Publishing\Domain\Component;

use RuntimeException;

final class ComponentRegistry
{
    /** @var array<string, ComponentDefinition> */
    private array $components = [];

    public function register(ComponentDefinition $definition): void
    {
        $this->components[$definition->type] = $definition;
    }

    public function get(string $type): ComponentDefinition
    {
        if (!isset($this->components[$type])) {
            throw new RuntimeException("Unknown component: {$type}");
        }

        return $this->components[$type];
    }

    /** @return ComponentDefinition[] */
    public function all(): array
    {
        return array_values($this->components);
    }
}
