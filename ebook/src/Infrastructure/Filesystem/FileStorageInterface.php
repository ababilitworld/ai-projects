<?php
declare(strict_types=1);

namespace AIT\Publishing\Infrastructure\Filesystem;

interface FileStorageInterface
{
    public function read(string $path): string;
    public function writeAtomic(string $path, string $contents): void;
    public function exists(string $path): bool;
    public function delete(string $path): void;
    public function list(string $path): array;
}
