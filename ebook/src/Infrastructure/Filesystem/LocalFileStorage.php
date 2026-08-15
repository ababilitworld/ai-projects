<?php
declare(strict_types=1);

namespace AIT\Publishing\Infrastructure\Filesystem;

use RuntimeException;

final class LocalFileStorage implements FileStorageInterface
{
    public function __construct(private readonly string $root)
    {
        if (!is_dir($this->root) && !mkdir($this->root, 0775, true) && !is_dir($this->root)) {
            throw new RuntimeException('Unable to create storage root.');
        }
    }

    public function read(string $path): string
    {
        $file = $this->resolve($path);
        if (!is_file($file)) {
            throw new RuntimeException("File not found: {$path}");
        }
        return (string) file_get_contents($file);
    }

    public function writeAtomic(string $path, string $contents): void
    {
        $file = $this->resolve($path);
        $directory = dirname($file);

        if (!is_dir($directory) && !mkdir($directory, 0775, true) && !is_dir($directory)) {
            throw new RuntimeException("Unable to create directory: {$directory}");
        }

        $tmp = tempnam($directory, '.ait-');
        if ($tmp === false) {
            throw new RuntimeException('Unable to create temporary file.');
        }

        try {
            $handle = fopen($tmp, 'wb');
            if ($handle === false) {
                throw new RuntimeException('Unable to open temporary file.');
            }
            if (!flock($handle, LOCK_EX)) {
                fclose($handle);
                throw new RuntimeException('Unable to lock temporary file.');
            }
            fwrite($handle, $contents);
            fflush($handle);
            flock($handle, LOCK_UN);
            fclose($handle);

            if (!rename($tmp, $file)) {
                throw new RuntimeException('Atomic rename failed.');
            }
        } finally {
            if (is_file($tmp)) {
                @unlink($tmp);
            }
        }
    }

    public function exists(string $path): bool
    {
        return file_exists($this->resolve($path));
    }

    public function delete(string $path): void
    {
        $file = $this->resolve($path);
        if (is_file($file)) {
            unlink($file);
        }
    }

    public function list(string $path): array
    {
        $directory = $this->resolve($path);
        if (!is_dir($directory)) {
            return [];
        }

        return array_values(array_diff(scandir($directory) ?: [], ['.', '..']));
    }

    private function resolve(string $path): string
    {
        $path = ltrim(str_replace('\\', '/', $path), '/');
        if (str_contains($path, '..')) {
            throw new RuntimeException('Invalid storage path.');
        }
        return $this->root . '/' . $path;
    }
}
