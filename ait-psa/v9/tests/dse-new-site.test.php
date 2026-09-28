<?php
declare(strict_types=1);
require __DIR__ . '/../dse_new_archive.php';
require __DIR__ . '/../dse_new_news.php';
ob_start();
require __DIR__ . '/../dse_fundamentals.php';
ob_end_clean();

function checkNew(bool $condition, string $message): void
{
    if (!$condition) throw new RuntimeException($message);
}

$row = ['date' => '2026-09-28', 'tradingCode' => 'GP', 'openp' => 242.0,
    'high' => 243.0, 'low' => 242.0, 'closep' => 242.4, 'volume' => 41913];
$page = json_encode(['rows' => [$row], 'total' => 1, 'page' => 1, 'pageSize' => 500], JSON_THROW_ON_ERROR);
$parsed = DseNewArchive::parsePage($page, '2026-09-20', '2026-09-28', 'GP');
checkNew($parsed['rows']['GP'][0]['close'] === 242.4, 'Day-end close mapping');
checkNew($parsed['rows']['GP'][0]['volume'] === 41913.0, 'Day-end volume mapping');
$count = 0;
$collected = DseNewArchive::fetch('2026-09-20', '2026-09-28', ['GP' => true], function (string $url) use ($page, &$count): string {
    $count++;
    checkNew(str_contains($url, 'inst=GP'), 'Archive must request only the selected symbol');
    return $page;
});
checkNew($count === 1 && count($collected['GP']) === 1, 'Scoped archive download');
$instantJson = json_encode(['cols' => ['code', 'ltp', 'open', 'high', 'low', 'ycp', 'volume'],
    'rows' => [['GP', 242.4, 242.0, 243.0, 242.0, 241.0, 41913]]], JSON_THROW_ON_ERROR);
$instant = DseNewArchive::parseInstant($instantJson, ['GP' => true], ['GP' => 242.2], '2026-09-28');
checkNew($instant['GP'][0]['open'] === 242.2 && $instant['GP'][0]['provisional'] === true,
    'Live price mapping must preserve AmarStock opening-price policy');
try {
    DseNewArchive::parsePage(str_replace('"tradingCode":"GP"', '"tradingCode":"ROBI"', $page), '2026-09-20', '2026-09-28', 'GP');
    throw new LogicException('Mismatched symbol was accepted');
} catch (RuntimeException $error) {
    checkNew(!($error instanceof LogicException), 'Wrong archive rejection');
}

$news = json_encode(['rows' => [['code' => 'GP', 'filedAt' => '2026-09-21',
    'summary' => 'GP: Dividend', 'body' => 'Cash dividend paid.']], 'truncated' => false], JSON_THROW_ON_ERROR);
$rows = DseNewNews::fetch('GP', '2026-09-20', '2026-09-28', fn(string $url): string => $news);
checkNew(count($rows) === 1 && $rows[0]['date'] === '2026-09-21', 'News date and title mapping');
$calls = 0;
$split = DseNewNews::fetch('GP', '2026-09-20', '2026-09-21', function (string $url) use (&$calls, $news): string {
    $calls++;
    parse_str((string) parse_url($url, PHP_URL_QUERY), $query);
    if ($query['from'] !== $query['to']) return '{"rows":[],"truncated":true}';
    return $query['from'] === '2026-09-20' ? '{"rows":[],"truncated":false}' : $news;
});
checkNew($calls === 3 && count($split) === 1, 'Truncated news must split and deduplicate');

$profile = '<html><h1>Grameenphone Ltd.</h1><div><dt>Year-end</dt><dd>December</dd>'
    . '<dt>Last AGM</dt><dd>20-04-2026</dd></div></html>';
$method = new ReflectionMethod(DseFundamentalProvider::class, 'parse');
$fundamentals = $method->invoke(new DseFundamentalProvider(), 'GP', $profile);
checkNew($fundamentals['yearEnd'] === 'December' && $fundamentals['lastAgmDate'] === '20-04-2026',
    'New company profile terms must map to existing fundamental fields');

echo "New DSE archive and news mapping passed.\n";
