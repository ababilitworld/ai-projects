<?php
declare(strict_types=1);

namespace AIT\Publishing\Tests;

use AIT\Publishing\Domain\Document\Block;
use AIT\Publishing\Domain\Document\Chapter;
use AIT\Publishing\Domain\Document\Document;
use AIT\Publishing\Pagination\PaginationEngine;
use PHPUnit\Framework\TestCase;

final class PaginationEngineTest extends TestCase
{
    public function testDocumentProducesAtLeastOnePage(): void
    {
        $document = Document::demo();
        $pages = (new PaginationEngine())->paginate($document);
        self::assertNotEmpty($pages);
        self::assertSame(1, $pages[0]->number);
    }

    public function testLongParagraphCanContinue(): void
    {
        $text = str_repeat('Long publishing content. ', 2500);
        $document = new Document(
            '1.0.0', 'test', 'Test', 'professional', 'ait-pha', [],
            [new Chapter('c1', 'Chapter', [
                new Block('b1', 'paragraph', ['text' => $text])
            ])]
        );

        $pages = (new PaginationEngine())->paginate($document);
        self::assertGreaterThan(1, count($pages));
    }
}
