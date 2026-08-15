<?php
declare(strict_types=1);

namespace AIT\Publishing\Infrastructure\Persistence;

use AIT\Publishing\Domain\Document\Document;

interface DocumentRepositoryInterface
{
    public function find(string $id): ?Document;
    public function save(Document $document): void;
    public function delete(string $id): void;
}
