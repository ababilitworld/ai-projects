<?php
declare(strict_types=1);

namespace AIT\Publishing\Rendering;

use AIT\Publishing\Domain\Document\Block;
use AIT\Publishing\Domain\Document\Document;
use AIT\Publishing\Pagination\Page;

final class HtmlRenderer
{
    /** @param Page[] $pages */
    public function render(Document $document, array $pages): string
    {
        $html = '<!doctype html><html lang="en"><head><meta charset="utf-8">';
        $html .= '<meta name="viewport" content="width=device-width,initial-scale=1">';
        $html .= '<title>' . htmlspecialchars($document->title, ENT_QUOTES) . '</title>';
        $html .= '<link rel="stylesheet" href="/assets/css/app.css"></head><body>';
        $html .= '<main class="ait-app__print-document">';

        foreach ($pages as $page) {
            $html .= '<article class="ait-app__page" data-page="' . $page->number . '">';
            $html .= '<header class="ait-app__page-header"><span>' . htmlspecialchars($document->title) . '</span><span>Page ' . $page->number . '</span></header>';
            $html .= '<section class="ait-app__page-body">';
            foreach ($page->blocks as $block) {
                $html .= $this->block($block);
            }
            $html .= '</section>';
            $html .= '<footer class="ait-app__page-footer"><span>' . htmlspecialchars($document->theme) . '</span><span>' . $page->number . '</span></footer>';
            $html .= '</article>';
        }

        return $html . '</main></body></html>';
    }

    private function block(Block $block): string
    {
        $text = htmlspecialchars((string) ($block->content['text'] ?? ''), ENT_QUOTES);
        return match ($block->type) {
            'heading' => '<h2 class="ait-app__block ait-app__heading">' . $text . '</h2>',
            'panel' => '<section class="ait-app__block ait-app__panel"><h3>' .
                htmlspecialchars((string) ($block->content['title'] ?? 'Panel')) .
                '</h3><p>' . $text . '</p></section>',
            default => '<p class="ait-app__block">' . $text . '</p>',
        };
    }
}
