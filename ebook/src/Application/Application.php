<?php
declare(strict_types=1);

namespace AIT\Publishing\Application;

use AIT\Publishing\Domain\Component\ComponentDefinition;
use AIT\Publishing\Domain\Component\ComponentRegistry;
use AIT\Publishing\Domain\Document\Document;
use AIT\Publishing\Infrastructure\Filesystem\FileStorageInterface;
use AIT\Publishing\Infrastructure\Persistence\DocumentRepositoryInterface;
use AIT\Publishing\Pagination\PaginationEngine;
use AIT\Publishing\Rendering\HtmlRenderer;

final class Application
{
    public function __construct(
        private readonly FileStorageInterface $storage,
        private readonly DocumentRepositoryInterface $documents
    ) {}

    public function run(Document $document): void
    {
        $registry = new ComponentRegistry();
        $registry->register(new ComponentDefinition('heading', 'Heading', 'content', '1.0.0', false));
        $registry->register(new ComponentDefinition('paragraph', 'Paragraph', 'content', '1.0.0'));
        $registry->register(new ComponentDefinition('panel', 'Panel', 'content', '1.0.0'));
        $registry->register(new ComponentDefinition('table', 'Table', 'content', '1.0.0', true, true));

        $pages = (new PaginationEngine())->paginate($document);
        $rendered = (new HtmlRenderer())->render($document, $pages);

        echo $this->shell($document, $pages, $rendered, $registry);
    }

    private function shell(Document $document, array $pages, string $rendered, ComponentRegistry $registry): string
    {
        $pageCount = count($pages);
        $componentCount = count($registry->all());
        $safeTitle = htmlspecialchars($document->title, ENT_QUOTES);
        $safeTemplate = htmlspecialchars($document->template, ENT_QUOTES);
        $safeTheme = htmlspecialchars($document->theme, ENT_QUOTES);

        return '<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">' .
            '<title>' . $safeTitle . '</title><link rel="stylesheet" href="/assets/css/app.css"></head><body>' .
            '<div class="ait-app">' .
            '<aside class="ait-app__sidebar"><div class="ait-app__brand">AIT <span>Publishing</span></div>' .
            '<nav class="ait-app__nav"><a class="is-active" href="/">Workspace</a><a href="/">eBook</a><a href="/">Components</a><a href="/">Templates</a><a href="/">Themes</a><a href="/">Print</a><a href="/">Data Center</a><a href="/">Settings</a></nav></aside>' .
            '<section class="ait-app__workspace">' .
            '<header class="ait-app__toolbar"><div><strong>Professional Publishing Terminal</strong><small> / Workspace / eBook</small></div><div class="ait-app__actions"><button onclick="window.print()">Print</button><button onclick="location.reload()">Refresh</button></div></header>' .
            '<div class="ait-app__content">' .
            '<section class="ait-app__topbar"><div><h1>' . $safeTitle . '</h1><p>File-based publishing workspace</p></div><div class="ait-app__badges"><span>NO DATABASE</span><span>' . $safeTemplate . '</span><span>' . $safeTheme . '</span></div></section>' .
            '<div class="ait-app__layout">' .
            '<aside class="ait-app__inspector"><h2>Document</h2><div class="ait-app__metric"><strong>' . $pageCount . '</strong><span>Planned pages</span></div><div class="ait-app__metric"><strong>' . $componentCount . '</strong><span>Registered blocks</span></div><hr><h3>Architecture</h3><p>Filesystem → Repository → Domain → Component Registry → Pagination → Page Collection → Preview / Print / PDF</p></aside>' .
            '<main class="ait-app__preview"><div class="ait-app__preview-head"><span>Print Preview</span><span>' . $pageCount . ' pages</span></div>' .
            '<div class="ait-app__canvas">' . preg_replace('/^.*?<main class="ait-app__print-document">(.*)<\/main>.*$/s', '$1', $rendered) . '</div></main>' .
            '</div></div><footer class="ait-app__status"><span>READY</span><span>Filesystem persistence</span><span>Pagination engine active</span><span>PHP 8.3+</span></footer>' .
            '</section></div><script type="module" src="/assets/js/app.js"></script></body></html>';
    }
}
