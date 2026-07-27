<?php
declare(strict_types=1);
header('Content-Type: application/json; charset=utf-8');

$dir = __DIR__ . '/storage/dse-cache';
$files = [];
foreach (glob($dir . '/*') ?: [] as $file) {
    if (!is_file($file)) continue;
    $files[] = [
        'name' => basename($file),
        'bytes' => filesize($file),
        'modified' => date(DATE_ATOM, filemtime($file)),
    ];
}
usort($files, fn(array $a, array $b): int => strcmp($b['modified'], $a['modified']));

echo json_encode([
    'success' => true,
    'cacheDirectoryWritable' => is_dir($dir) && is_writable($dir),
    'files' => $files,
], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
