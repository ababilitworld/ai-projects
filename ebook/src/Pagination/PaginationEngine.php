<?php
declare(strict_types=1);

namespace AIT\Publishing\Pagination;

use AIT\Publishing\Domain\Document\Block;
use AIT\Publishing\Domain\Document\Document;

final class PaginationEngine
{
    /**
     * Deterministic planning engine using block estimates.
     * Rendering engines can later replace measurements with browser/PDF measurements
     * without changing the document model.
     *
     * @return Page[]
     */
    public function paginate(Document $document): array
    {
        $pages = [];
        $pageNumber = 1;
        $page = $this->newPage($pageNumber);
        $used = 0.0;

        foreach ($document->chapters as $chapter) {
            foreach ($chapter->blocks as $block) {
                $remaining = $this->estimateHeight($block);

                if ($remaining <= $this->availableHeight($page, $used)) {
                    $page = $this->addBlock($page, $block);
                    $used += $remaining;
                    continue;
                }

                if ($block->canSplit && $remaining > $this->availableHeight($page, $used)) {
                    $fit = $this->availableHeight($page, $used);
                    if ($fit > 40 && $remaining > $fit) {
                        [$first, $continuation] = $this->splitBlock($block, $fit, $remaining);
                        if ($first !== null) {
                            $page = $this->addBlock($page, $first);
                            $pages[] = $page;
                            $pageNumber++;
                            $page = $this->newPage($pageNumber);
                            $used = 0;
                            if ($continuation !== null) {
                                $page = $this->addBlock($page, $continuation);
                                $used += $this->estimateHeight($continuation);
                            }
                            continue;
                        }
                    }
                }

                if ($page->blocks !== []) {
                    $pages[] = $page;
                    $pageNumber++;
                    $page = $this->newPage($pageNumber);
                    $used = 0;
                }

                $page = $this->addBlock($page, $block);
                $used = min($this->estimateHeight($block), $this->availableHeight($page, 0));
            }
        }

        if ($page->blocks !== [] || $pages === []) {
            $pages[] = $page;
        }

        return $pages;
    }

    private function newPage(int $number): Page
    {
        return new Page($number, 794, 1123, 64, 64, 64, 64);
    }

    private function availableHeight(Page $page, float $used): float
    {
        return max(0, $page->bodyHeight() - $used);
    }

    private function addBlock(Page $page, Block $block): Page
    {
        return new Page(
            $page->number,
            $page->width,
            $page->height,
            $page->marginTop,
            $page->marginRight,
            $page->marginBottom,
            $page->marginLeft,
            [...$page->blocks, $block]
        );
    }

    private function estimateHeight(Block $block): float
    {
        $text = (string) ($block->content['text'] ?? '');
        if ($block->type === 'panel') {
            $text = (string) ($block->content['title'] ?? '') . ' ' . $text;
            return max(120, 72 + (ceil(mb_strlen($text) / 70) * 24));
        }
        if ($block->type === 'heading') {
            return 58;
        }
        if ($block->type === 'table') {
            return max(120, 42 + count($block->content['rows'] ?? []) * 34);
        }
        return max(42, 28 + ceil(mb_strlen($text) / 85) * 22);
    }

    private function splitBlock(Block $block, float $available, float $total): array
    {
        $text = (string) ($block->content['text'] ?? '');
        if ($text === '') {
            return [null, null];
        }

        $ratio = max(0.1, min(0.9, $available / $total));
        $cut = max(20, (int) floor(mb_strlen($text) * $ratio));
        $firstText = mb_substr($text, 0, $cut);
        $restText = mb_substr($text, $cut);

        return [
            new Block($block->id . '-part1', $block->type, [...$block->content, 'text' => trim($firstText)], $block->configuration, $block->variant, $block->style, false, false),
            $restText !== ''
                ? new Block($block->id . '-cont', $block->type, [...$block->content, 'text' => trim($restText)], $block->configuration, 'continuation', $block->style, true, false)
                : null,
        ];
    }
}
