<?php
declare(strict_types=1);

require dirname(__DIR__) . '/vendor/autoload.php';

use AIT\Publishing\Application\Application;
use AIT\Publishing\Infrastructure\Filesystem\LocalFileStorage;
use AIT\Publishing\Infrastructure\Persistence\FileDocumentRepository;
use AIT\Publishing\Domain\Document\Document;

$root = dirname(__DIR__);
$storage = new LocalFileStorage($root . '/storage');
$documents = new FileDocumentRepository($storage, 'documents/books');
$app = new Application($storage, $documents);

$book = $documents->find('demo-book');
if (!$book) {
    $book = Document::demo();
    $documents->save($book);
}

$app->run($book);
