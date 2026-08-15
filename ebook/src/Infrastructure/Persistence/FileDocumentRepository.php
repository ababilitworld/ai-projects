<?php
declare(strict_types=1);

namespace AIT\Publishing\Infrastructure\Persistence;

use AIT\Publishing\Domain\Document\Document;
use AIT\Publishing\Infrastructure\Filesystem\FileStorageInterface;
use RuntimeException;

final class FileDocumentRepository implements DocumentRepositoryInterface
{
    public function __construct(
        private readonly FileStorageInterface $storage,
        private readonly string $basePath
    ) {}

    public function find(string $id): ?Document
    {
        $path = $this->basePath . '/' . $id . '/document.json';
        if (!$this->storage->exists($path)) {
            return null;
        }

        $data = json_decode($this->storage->read($path), true);
        if (!is_array($data)) {
            throw new RuntimeException('Invalid document JSON.');
        }

        return Document::fromArray($data);
    }

    public function save(Document $document): void
    {
        $base = $this->basePath . '/' . $document->id;
        $this->storage->writeAtomic(
            $base . '/document.json',
            json_encode($document->toArray(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR)
        );
        $this->storage->writeAtomic(
            $base . '/manifest.json',
            json_encode([
                'schema_version' => $document->schemaVersion,
                'id' => $document->id,
                'title' => $document->title,
                'template' => $document->template,
                'theme' => $document->theme,
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR)
        );
    }

    public function delete(string $id): void
    {
        $this->storage->delete($this->basePath . '/' . $id . '/document.json');
        $this->storage->delete($this->basePath . '/' . $id . '/manifest.json');
    }
}
