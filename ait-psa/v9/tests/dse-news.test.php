<?php
require __DIR__ . '/../dse_news.php';
function check($condition, $message) {if (!$condition) throw new RuntimeException($message);}
$provider = new DseNewsProvider();
$record = '<tr><th>Trading Code:</th><td>GP</td></tr><tr><th>News Title:</th><td>GP: Q1 &amp; results</td></tr><tr><th>News:</th><td>EPS <b>10.50</b> &amp; NAV 25</td></tr><tr><th>Post Date:</th><td>2026-08-02</td></tr>';
$html = '<html><body><table>' . $record . $record . '</table></body></html>';
$rows = $provider->parse($html, 'GP', '2026-01-01', '2026-09-06');
check(count($rows) === 1, 'Duplicate rows should merge');
check($rows[0]['body'] === 'EPS 10.50 & NAV 25', 'HTML must be normalized to text');
check($rows[0]['date'] === '2026-08-02', 'Publication date must be retained');
foreach ([$html . '', str_replace('</html>', '', $html), '<html>Access denied</html>'] as $i => $invalid) {
    try {$provider->parse($invalid, $i === 0 ? 'BATBC' : 'GP', '2026-01-01', '2026-09-06'); throw new LogicException('Invalid response was accepted');}
    catch (RuntimeException $e) {check(!($e instanceof LogicException), $e->getMessage());}
}
check($provider->parse('<html><body>No news found</body></html>', 'GP', '2026-01-01', '2026-09-06') === [], 'Valid empty archive');
check($provider->parse('<html><body><table class="table-news"><tr><th>No new news found</th></tr></table></body></html>', 'GP', '2026-01-01', '2026-09-06') === [], 'DSE empty archive wording');
foreach (['2026-02-30','not-a-date'] as $date) {try {DseNewsProvider::date($date); throw new RuntimeException('Invalid date accepted');} catch (InvalidArgumentException $e) {}}
if (is_file(__DIR__ . '/../storage/dse-news-source.html')) {
    $live = $provider->parse(file_get_contents(__DIR__ . '/../storage/dse-news-source.html'), 'GP', '2025-01-01', '2026-09-06');
    check(count($live) > 20, 'Live DSE fixture should contain real archive news');
    echo 'Live captured DSE archive parsed: ' . count($live) . " articles\n";
}
echo "DSE parser validation, scope, duplicates and error handling passed.\n";
