<?php
declare(strict_types=1);

header('X-Content-Type-Options: nosniff');
header('Cache-Control: no-store, max-age=0');

const DSE_URL = 'https://dsebd.org/day_end_archive.php';
const DSE_LIVE_URL = 'https://dsebd.org/latest_share_price_scroll_by_ltp.php';
const AMARSTOCK_LIVE_URL = 'https://www.amarstock.com/latest-share-price';
const MAX_RANGE_DAYS = 370;
const CACHE_TTL = 21600; // 6 hours

final class ApiError extends RuntimeException
{
    public function __construct(string $message, public int $status = 400)
    {
        parent::__construct($message);
    }
}

/**
 * Applies an active-watch-list scope to a normalized DSE archive dataset.
 * The underlying full-market source cache remains shared, while responses and
 * generated CSV files contain only the explicitly requested trading codes.
 */
final class ArchiveScope
{
    /** @param array<string,true> $requestedCodes */
    public function __construct(private array $requestedCodes)
    {
        ksort($this->requestedCodes);
    }

    /** @return array<string,true> */
    public function codes(): array
    {
        return $this->requestedCodes;
    }

    public function isRestricted(): bool
    {
        return $this->requestedCodes !== [];
    }

    /** @param array<string,array<int,array<string,mixed>>> $dataset */
    public function filter(array $dataset): array
    {
        if (!$this->isRestricted()) {
            return $dataset;
        }

        $filtered = array_intersect_key($dataset, $this->requestedCodes);
        ksort($filtered);

        return $filtered;
    }

    public function cacheSuffix(): string
    {
        if (!$this->isRestricted()) {
            return '-all';
        }

        return '-watch-' . substr(hash('sha256', implode('|', array_keys($this->requestedCodes))), 0, 16);
    }
}

function jsonResponse(array $payload, int $status = 200): never
{
    http_response_code($status);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    exit;
}

function getString(string $key, string $default = ''): string
{
    $value = $_GET[$key] ?? $default;
    return is_string($value) ? trim($value) : $default;
}

function parseDateValue(string $value, string $field): DateTimeImmutable
{
    $date = DateTimeImmutable::createFromFormat('!Y-m-d', $value);
    $errors = DateTimeImmutable::getLastErrors();

    if (
        !$date ||
        ($errors !== false && ($errors['warning_count'] > 0 || $errors['error_count'] > 0)) ||
        $date->format('Y-m-d') !== $value
    ) {
        throw new ApiError("Invalid {$field}; expected YYYY-MM-DD.");
    }

    return $date;
}

function normalizeCode(string $code): string
{
    return preg_replace('/[^A-Z0-9().&_-]/', '', strtoupper(trim($code))) ?? '';
}

/** @return array<string,true> */
function requestedCodes(): array
{
    $raw = getString('codes');
    if ($raw === '') {
        return [];
    }

    $codes = [];
    foreach (preg_split('/[\s,;|]+/', $raw) ?: [] as $code) {
        $code = normalizeCode($code);
        if ($code !== '') {
            $codes[$code] = true;
        }
    }

    if (count($codes) > 1000) {
        throw new ApiError('Too many trading codes requested.');
    }

    return $codes;
}

function cacheDirectory(): string
{
    $dir = __DIR__ . '/storage/dse-cache';

    if (!is_dir($dir) && !mkdir($dir, 0775, true) && !is_dir($dir)) {
        throw new ApiError('Could not create storage/dse-cache.', 500);
    }

    if (!is_writable($dir)) {
        throw new ApiError('storage/dse-cache is not writable by PHP.', 500);
    }

    return $dir;
}

function archiveUrl(string $startDate, string $endDate): string
{
    return DSE_URL . '?' . http_build_query([
        'startDate' => $startDate,
        'endDate' => $endDate,
        'inst' => 'All Instrument',
        'archive' => 'data',
    ], '', '&', PHP_QUERY_RFC3986);
}


function isLocalDevelopment(): bool
{
    $host = strtolower((string) ($_SERVER['HTTP_HOST'] ?? $_SERVER['SERVER_NAME'] ?? ''));
    $host = preg_replace('/:\d+$/', '', $host) ?? $host;

    return $host === 'localhost'
        || $host === '127.0.0.1'
        || $host === '::1'
        || str_ends_with($host, '.test')
        || str_ends_with($host, '.localhost')
        || str_ends_with($host, '.local');
}

function configuredCaBundle(): ?string
{
    $candidates = [
        getenv('DSE_CACERT_PATH') ?: '',
        (string) ini_get('curl.cainfo'),
        (string) ini_get('openssl.cafile'),
        __DIR__ . '/cacert.pem',
        __DIR__ . '/storage/cacert.pem',
        'C:\\xampp\\apache\\bin\\curl-ca-bundle.crt',
        'C:\\xampp\\php\\extras\\ssl\\cacert.pem',
        '/etc/ssl/certs/ca-certificates.crt',
        '/etc/pki/tls/certs/ca-bundle.crt',
        '/etc/ssl/cert.pem',
    ];

    foreach ($candidates as $candidate) {
        $candidate = trim($candidate);
        if ($candidate !== '' && is_file($candidate) && is_readable($candidate)) {
            return $candidate;
        }
    }

    return null;
}

/** @return array{body:string,status:int,type:string,error:string,errno:int} */
function executeCurl(string $url, bool $verifySsl, ?string $caBundle): array
{
    $ch = curl_init($url);
    if ($ch === false) {
        throw new ApiError('Unable to initialize cURL.', 500);
    }

    $options = [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_MAXREDIRS => 5,
        CURLOPT_CONNECTTIMEOUT => 20,
        CURLOPT_TIMEOUT => 90,
        CURLOPT_ENCODING => '',
        CURLOPT_SSL_VERIFYPEER => $verifySsl,
        CURLOPT_SSL_VERIFYHOST => $verifySsl ? 2 : 0,
        CURLOPT_HTTPHEADER => [
            'Accept: text/html,application/xhtml+xml',
            'Accept-Language: en-US,en;q=0.9',
            'Cache-Control: no-cache',
        ],
        CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 Chrome/126 Safari/537.36',
    ];

    if ($verifySsl && $caBundle !== null) {
        $options[CURLOPT_CAINFO] = $caBundle;
    }

    curl_setopt_array($ch, $options);

    $body = curl_exec($ch);
    $result = [
        'body' => is_string($body) ? $body : '',
        'status' => (int) curl_getinfo($ch, CURLINFO_RESPONSE_CODE),
        'type' => (string) curl_getinfo($ch, CURLINFO_CONTENT_TYPE),
        'error' => curl_error($ch),
        'errno' => curl_errno($ch),
    ];
    curl_close($ch);

    return $result;
}

function downloadHtml(string $url): string
{
    if (!extension_loaded('curl')) {
        throw new ApiError('PHP cURL extension is not enabled.', 500);
    }

    $caBundle = configuredCaBundle();
    $result = executeCurl($url, true, $caBundle);
    $usedInsecureFallback = false;

    $sslErrors = [35, 51, 53, 54, 58, 59, 60, 64, 66, 77, 80, 82, 83, 90, 91];
    $allowInsecure = isLocalDevelopment() || getenv('DSE_ALLOW_INSECURE_SSL') === '1';

    if (
        $result['body'] === ''
        && $allowInsecure
        && in_array($result['errno'], $sslErrors, true)
    ) {
        $result = executeCurl($url, false, null);
        $usedInsecureFallback = true;
    }

    if ($result['body'] === '') {
        $help = in_array($result['errno'], $sslErrors, true)
            ? ' Configure curl.cainfo in php.ini or place cacert.pem beside dse_archive.php.'
            : '';

        throw new ApiError(
            'DSE returned an empty response: ' . ($result['error'] ?: 'unknown error') . $help,
            502
        );
    }

    if ($result['status'] < 200 || $result['status'] >= 400) {
        throw new ApiError("DSE returned HTTP {$result['status']}.", 502);
    }

    if (
        stripos($result['type'], 'text/html') === false
        && stripos($result['body'], '<table') === false
    ) {
        throw new ApiError('DSE response was not an HTML archive table.', 502);
    }

    header(
        'X-DSE-SSL-Mode: ' .
        ($usedInsecureFallback
            ? 'local-development-insecure-fallback'
            : ($caBundle !== null ? 'verified-custom-ca' : 'verified-system-ca'))
    );

    return $result['body'];
}

function cleanHeader(string $value): string
{
    return preg_replace('/[^a-z0-9]/', '', strtolower(trim($value))) ?? '';
}

function numericValue(string $value): ?float
{
    $value = str_replace([',', ' '], '', trim($value));
    if ($value === '' || !is_numeric($value)) {
        return null;
    }
    return (float) $value;
}

function normalizeDate(string $value): ?string
{
    $value = trim($value);
    $formats = ['Y-m-d', 'd-m-Y', 'd/m/Y', 'm/d/Y', 'd M Y', 'M d, Y'];

    foreach ($formats as $format) {
        $date = DateTimeImmutable::createFromFormat('!' . $format, $value);
        $errors = DateTimeImmutable::getLastErrors();
        if (
            $date &&
            ($errors === false || ($errors['warning_count'] === 0 && $errors['error_count'] === 0))
        ) {
            return $date->format('Y-m-d');
        }
    }

    $timestamp = strtotime($value);
    return $timestamp !== false ? date('Y-m-d', $timestamp) : null;
}

/**
 * @return array<int,array<int,string>>
 */
function extractRows(string $html): array
{
    if (!extension_loaded('dom')) {
        throw new ApiError('PHP DOM extension is not enabled.', 500);
    }

    libxml_use_internal_errors(true);
    $dom = new DOMDocument();
    $loaded = $dom->loadHTML('<?xml encoding="utf-8" ?>' . $html);
    libxml_clear_errors();

    if (!$loaded) {
        throw new ApiError('Unable to parse the DSE HTML response.', 502);
    }

    $rows = [];
    foreach ($dom->getElementsByTagName('tr') as $tr) {
        $cells = [];
        foreach ($tr->childNodes as $child) {
            if ($child instanceof DOMElement && in_array(strtolower($child->tagName), ['th', 'td'], true)) {
                $cells[] = trim(preg_replace('/\s+/u', ' ', $child->textContent) ?? '');
            }
        }
        if (count($cells) >= 5) {
            $rows[] = $cells;
        }
    }

    if (!$rows) {
        throw new ApiError('No tabular archive rows were found in the DSE response.', 502);
    }

    return $rows;
}

/**
 * @param array<int,string> $headers
 * @return array<string,int>
 */
function detectColumns(array $headers): array
{
    $aliases = [
        'code' => ['tradingcode', 'tradecode', 'instrument', 'instrumentcode', 'symbol', 'code'],
        'date' => ['date', 'tradedate', 'tradingdate'],
        'open' => ['open', 'openp', 'openprice', 'openingprice'],
        'high' => ['high', 'highp', 'highprice'],
        'low' => ['low', 'lowp', 'lowprice'],
        'close' => ['close', 'closep', 'closeprice', 'closingprice', 'ltp', 'lasttradedprice'],
        'volume' => ['volume', 'totalvolume', 'totalvol', 'vol'],
    ];

    $normalized = array_map('cleanHeader', $headers);
    $map = [];

    foreach ($aliases as $key => $names) {
        foreach ($normalized as $index => $header) {
            if (in_array($header, $names, true)) {
                $map[$key] = $index;
                break;
            }
        }
    }

    return $map;
}

/**
 * @return array<string,array<int,array{date:string,open:float,high:float,low:float,close:float,volume:float}>>
 */
function parseArchive(string $html, array $filterCodes): array
{
    $rows = extractRows($html);
    $headerIndex = -1;
    $map = [];

    foreach ($rows as $index => $row) {
        $candidate = detectColumns($row);
        if (isset($candidate['code'], $candidate['date'], $candidate['open'], $candidate['high'], $candidate['low'], $candidate['close'])) {
            $headerIndex = $index;
            $map = $candidate;
            break;
        }
    }

    if ($headerIndex < 0) {
        throw new ApiError('Could not identify DSE archive columns.', 502);
    }

    $result = [];
    $processedRows = 0; $rejectedRows = 0; $filteredRows = 0;
    foreach (array_slice($rows, $headerIndex + 1) as $row) {
        $processedRows++;
        $requiredMax = max($map);
        if (count($row) <= $requiredMax) {
            continue;
        }

        $code = normalizeCode($row[$map['code']] ?? '');
        if ($code === '') { $rejectedRows++; continue; }
        if ($filterCodes && !isset($filterCodes[$code])) { $filteredRows++; continue; }

        $date = normalizeDate($row[$map['date']] ?? '');
        $open = numericValue($row[$map['open']] ?? '');
        $high = numericValue($row[$map['high']] ?? '');
        $low = numericValue($row[$map['low']] ?? '');
        $close = numericValue($row[$map['close']] ?? '');
        $volume = isset($map['volume']) ? numericValue($row[$map['volume']] ?? '') : 0.0;

        if ($date === null || $open === null || $high === null || $low === null || $close === null) { $rejectedRows++; continue; }

        if ($high < $low || $high < max($open, $close) || $low > min($open, $close)) { $rejectedRows++; continue; }

        $result[$code][] = [
            'date' => $date,
            'open' => $open,
            'high' => $high,
            'low' => $low,
            'close' => $close,
            'volume' => $volume ?? 0.0,
        ];
    }

    foreach ($result as &$records) {
        $byDate = [];
        foreach ($records as $record) {
            $byDate[$record['date']] = $record;
        }
        ksort($byDate);
        $records = array_values($byDate);
    }
    unset($records);

    if (!$result) {
        throw new ApiError('DSE archive returned no usable OHLC records.', 502);
    }

    ksort($result);
    $GLOBALS['DSE_PARSE_STATS'] = ['tableRows'=>count($rows),'processedRows'=>$processedRows,'rejectedRows'=>$rejectedRows,'filteredRows'=>$filteredRows,'headerIndex'=>$headerIndex,'columnMap'=>$map];
    return $result;
}


/**
 * Parse AmarStock's latest-share-price table and return positive OpenP values.
 * Only the opening price is consumed from this provider. All remaining live
 * market fields continue to come from the official DSE table.
 *
 * @return array<string,float>
 */
function parseAmarstockOpenPrices(string $html, array $filterCodes): array
{
    $rows = extractRows($html);
    $headerIndex = -1;
    $codeIndex = null;
    $openIndex = null;

    foreach ($rows as $index => $row) {
        foreach ($row as $column => $label) {
            $header = cleanHeader((string) $label);
            if (in_array($header, ['tradingcode', 'tradecode', 'code', 'symbol', 'instrument'], true)) {
                $codeIndex = $column;
            }
            if (in_array($header, ['open', 'openp', 'openingprice', 'openprice'], true)) {
                $openIndex = $column;
            }
        }
        if ($codeIndex !== null && $openIndex !== null) {
            $headerIndex = $index;
            break;
        }
    }

    if ($headerIndex < 0 || $codeIndex === null || $openIndex === null) {
        throw new ApiError('Could not identify AmarStock Trading Code and OpenP columns.', 502);
    }

    $opens = [];
    foreach (array_slice($rows, $headerIndex + 1) as $row) {
        if (!isset($row[$codeIndex], $row[$openIndex])) {
            continue;
        }
        $code = normalizeCode((string) $row[$codeIndex]);
        if ($code === '' || ($filterCodes && !isset($filterCodes[$code]))) {
            continue;
        }
        $open = numericValue((string) $row[$openIndex]);
        if ($open !== null && $open > 0) {
            $opens[$code] = $open;
        }
    }

    if (!$opens) {
        throw new ApiError('AmarStock latest-share-price page returned no usable OpenP values.', 502);
    }

    ksort($opens);
    return $opens;
}

/**
 * Parse the DSE latest-share-price page into provisional intraday OHLC rows.
 * DSE does not publish an opening price on this table, so YCP (previous close)
 * is used as the server-side opening reference. The browser replaces it with
 * the last archived close when that value is available locally.
 *
 * @return array<string,array<int,array<string,mixed>>>
 */
function parseInstantMarket(string $html, array $filterCodes, array $amarstockOpens = []): array
{
    $rows = extractRows($html);
    $headerIndex = -1;
    $map = [];

    foreach ($rows as $index => $row) {
        $normalized = array_map('cleanHeader', $row);
        $candidate = detectColumns($row);
        foreach ($normalized as $column => $header) {
            if (in_array($header, ['ycp', 'yesterdayclose', 'previousclose', 'prevclose'], true)) {
                $candidate['ycp'] = $column;
            }
        }
        if (isset($candidate['code'], $candidate['high'], $candidate['low'], $candidate['close'])) {
            $headerIndex = $index;
            $map = $candidate;
            break;
        }
    }

    if ($headerIndex < 0) {
        throw new ApiError('Could not identify DSE latest-share-price columns.', 502);
    }

    $marketDate = (new DateTimeImmutable('now', new DateTimeZone('Asia/Dhaka')))->format('Y-m-d');
    $result = [];
    foreach (array_slice($rows, $headerIndex + 1) as $row) {
        if (count($row) <= max($map)) {
            continue;
        }
        $code = normalizeCode($row[$map['code']] ?? '');
        if ($code === '' || ($filterCodes && !isset($filterCodes[$code]))) {
            continue;
        }
        $close = numericValue($row[$map['close']] ?? '');
        $high = numericValue($row[$map['high']] ?? '');
        $low = numericValue($row[$map['low']] ?? '');
        $dseOpen = isset($map['open']) ? numericValue($row[$map['open']] ?? '') : null;
        $amarstockOpen = $amarstockOpens[$code] ?? null;
        $ycp = isset($map['ycp']) ? numericValue($row[$map['ycp']] ?? '') : null;
        $volume = isset($map['volume']) ? numericValue($row[$map['volume']] ?? '') : 0.0;

        if ($close === null || $close <= 0) {
            continue;
        }
        $open = ($amarstockOpen !== null && $amarstockOpen > 0)
            ? $amarstockOpen
            : (($dseOpen !== null && $dseOpen > 0)
                ? $dseOpen
                : (($ycp !== null && $ycp > 0) ? $ycp : $close));
        $high = ($high !== null && $high > 0) ? max($high, $open, $close) : max($open, $close);
        $low = ($low !== null && $low > 0) ? min($low, $open, $close) : min($open, $close);

        $result[$code] = [[
            'date' => $marketDate,
            'open' => $open,
            'high' => $high,
            'low' => $low,
            'close' => $close,
            'volume' => $volume ?? 0.0,
            'provisional' => true,
            'source' => ($amarstockOpen !== null && $amarstockOpen > 0)
                ? 'Hybrid: AmarStock OpenP + DSE live market'
                : 'DSE live market (OpenP fallback)',
            'openSource' => ($amarstockOpen !== null && $amarstockOpen > 0) ? 'AmarStock' : 'DSE/YCP fallback',
            'marketSource' => 'DSE',
        ]];
    }

    if (!$result) {
        throw new ApiError('DSE latest-share-price page returned no usable live rows.', 502);
    }
    ksort($result);
    return $result;
}

/**
 * @param array<string,array<int,array<string,float|string>>> $data
 */
function writeCsv(string $path, array $data): int
{
    $fp = fopen($path, 'wb');
    if ($fp === false) {
        throw new ApiError('Unable to create the cached CSV file.', 500);
    }

    fputcsv($fp, ['TRADING_CODE', 'DATE', 'OPEN', 'HIGH', 'LOW', 'CLOSE', 'VOLUME']);
    $count = 0;

    foreach ($data as $code => $records) {
        foreach ($records as $record) {
            fputcsv($fp, [
                $code,
                $record['date'],
                $record['open'],
                $record['high'],
                $record['low'],
                $record['close'],
                $record['volume'],
            ]);
            $count++;
        }
    }

    fclose($fp);
    return $count;
}

function dateChunks(DateTimeImmutable $start, DateTimeImmutable $end, int $chunkDays = 14): array
{
    $chunks = [];
    $cursor = $start;

    while ($cursor <= $end) {
        $chunkEnd = $cursor->modify('+' . ($chunkDays - 1) . ' days');
        if ($chunkEnd > $end) {
            $chunkEnd = $end;
        }
        $chunks[] = [$cursor, $chunkEnd];
        $cursor = $chunkEnd->modify('+1 day');
    }

    return $chunks;
}

/** @param array<string,array<int,array<string,mixed>>> $target
 *  @param array<string,array<int,array<string,mixed>>> $source */
function mergeArchiveData(array &$target, array $source): void
{
    foreach ($source as $code => $records) {
        foreach ($records as $record) {
            $target[$code][$record['date']] = $record;
        }
    }
}

/** @param array<string,array<string,array<string,mixed>>> $data */
function finalizeArchiveData(array $data): array
{
    $final = [];
    ksort($data);
    foreach ($data as $code => $recordsByDate) {
        ksort($recordsByDate);
        $final[$code] = array_values($recordsByDate);
    }
    return $final;
}

@set_time_limit(0);
ignore_user_abort(true);

try {
    $requestStartedAt = microtime(true);
    $scope = new ArchiveScope(requestedCodes());
    $codes = $scope->codes();
    $action = strtolower(getString('action'));
    if ($action === 'instant') {
        $dseHtml = downloadHtml(DSE_LIVE_URL);
        $amarstockOpens = [];
        $amarstockError = null;
        try {
            $amarstockHtml = downloadHtml(AMARSTOCK_LIVE_URL);
            $amarstockOpens = parseAmarstockOpenPrices($amarstockHtml, $codes);
        } catch (Throwable $error) {
            $amarstockError = $error->getMessage();
        }

        $instant = parseInstantMarket($dseHtml, $codes, $amarstockOpens);
        $recordCount = array_sum(array_map('count', $instant));
        $marketDate = (new DateTimeImmutable('now', new DateTimeZone('Asia/Dhaka')))->format('Y-m-d');
        $amarstockMatched = 0;
        foreach ($instant as $code => $records) {
            if (isset($amarstockOpens[$code])) {
                $amarstockMatched++;
            }
        }
        jsonResponse([
            'success' => true,
            'mode' => 'instant',
            'provisional' => true,
            'sourceUrl' => DSE_LIVE_URL,
            'openSourceUrl' => AMARSTOCK_LIVE_URL,
            'sourcePolicy' => 'OpenP from AmarStock; High, Low, Close/LTP, Volume and other live fields from DSE.',
            'marketDate' => $marketDate,
            'symbolCount' => count($instant),
            'recordCount' => $recordCount,
            'scope' => $scope->isRestricted() ? 'watch-list' : 'all',
            'requestedCodes' => array_keys($codes),
            'amarstockOpenMatched' => $amarstockMatched,
            'openFallbackCount' => max(0, count($instant) - $amarstockMatched),
            'amarstockWarning' => $amarstockError,
            'availableCodes' => array_keys($instant),
            'completedAt' => date(DATE_ATOM),
            'data' => $instant,
        ]);
    }
    $startText = getString('startDate');
    $endText = getString('endDate');
    $format = strtolower(getString('format', 'json'));
    $refresh = getString('refresh') === '1';

    $start = parseDateValue($startText, 'startDate');
    $end = parseDateValue($endText, 'endDate');

    if ($start > $end) {
        throw new ApiError('startDate must be before or equal to endDate.');
    }

    $days = (int) $start->diff($end)->format('%a');
    if ($days > MAX_RANGE_DAYS) {
        throw new ApiError('Date range cannot exceed ' . MAX_RANGE_DAYS . ' days.');
    }

    if (!in_array($format, ['json', 'csv'], true)) {
        throw new ApiError('format must be json or csv.');
    }

    $dir = cacheDirectory();
    $scopeHash = '-all';
    $baseName = 'dse-v7-' . $startText . '-to-' . $endText . $scopeHash;
    $csvPath = $dir . '/' . $baseName . '.csv';
    $jsonPath = $dir . '/' . $baseName . '.json';
    $rawPath = $dir . '/' . $baseName . '.html';

    $fresh = !$refresh && is_file($jsonPath) && (time() - filemtime($jsonPath) < CACHE_TTL);

    if ($fresh) {
        $decoded = json_decode((string) file_get_contents($jsonPath), true);
        if (!is_array($decoded)) {
            $fresh = false;
        }
    }

    $chunkReport = [];

    if (!$fresh) {
        $merged = [];
        $chunkNumber = 0;

        foreach (dateChunks($start, $end, 14) as [$chunkStart, $chunkEnd]) {
            $chunkNumber++;
            $chunkStartText = $chunkStart->format('Y-m-d');
            $chunkEndText = $chunkEnd->format('Y-m-d');
            $chunkUrl = archiveUrl($chunkStartText, $chunkEndText);
            $chunkBase = 'dse-v7-chunk-' . $chunkStartText . '-to-' . $chunkEndText . $scopeHash;
            $chunkRawPath = $dir . '/' . $chunkBase . '.html';

            try {
                if (
                    !$refresh
                    && is_file($chunkRawPath)
                    && filesize($chunkRawPath) > 1000
                    && (time() - filemtime($chunkRawPath) < CACHE_TTL)
                ) {
                    $html = (string) file_get_contents($chunkRawPath);
                } else {
                    $html = downloadHtml($chunkUrl);
                    file_put_contents($chunkRawPath, $html, LOCK_EX);
                }

                $chunkData = parseArchive($html, []);
                mergeArchiveData($merged, $chunkData);

                $chunkRecords = 0;
                foreach ($chunkData as $records) {
                    $chunkRecords += count($records);
                }
                $chunkReport[] = [
                    'chunk' => $chunkNumber,
                    'startDate' => $chunkStartText,
                    'endDate' => $chunkEndText,
                    'symbols' => count($chunkData),
                    'records' => $chunkRecords,
                    'success' => true,
                ];
            } catch (Throwable $chunkError) {
                $chunkReport[] = [
                    'chunk' => $chunkNumber,
                    'startDate' => $chunkStartText,
                    'endDate' => $chunkEndText,
                    'symbols' => 0,
                    'records' => 0,
                    'success' => false,
                    'message' => $chunkError->getMessage(),
                ];
            }
        }

        $decoded = finalizeArchiveData($merged);
        if (!$decoded) {
            throw new ApiError('No usable DSE records were returned from any date chunk.', 502);
        }

        file_put_contents(
            $jsonPath,
            json_encode($decoded, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
            LOCK_EX
        );
        writeCsv($csvPath, $decoded);
    }

    if (!isset($decoded) || !is_array($decoded)) {
        throw new ApiError('Cached archive data is invalid.', 500);
    }

    $responseData = $scope->filter($decoded);
    if ($scope->isRestricted() && $responseData === []) {
        throw new ApiError('No DSE archive records matched the requested active watch list.', 404);
    }

    $recordCount = 0;
    foreach ($responseData as $records) {
        $recordCount += is_array($records) ? count($records) : 0;
    }

    $responseCsvPath = $scope->isRestricted()
        ? $dir . '/dse-v8-' . $startText . '-to-' . $endText . $scope->cacheSuffix() . '.csv'
        : $csvPath;

    if ($format === 'csv') {
        if (
            !is_file($responseCsvPath)
            || $refresh
            || (is_file($jsonPath) && filemtime($responseCsvPath) < filemtime($jsonPath))
        ) {
            writeCsv($responseCsvPath, $responseData);
        }

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . basename($responseCsvPath) . '"');
        header('Content-Length: ' . filesize($responseCsvPath));
        readfile($responseCsvPath);
        exit;
    }

    jsonResponse([
        'success' => true,
        'sourceUrl' => archiveUrl($startText, $endText),
        'startDate' => $startText,
        'endDate' => $endText,
        'symbolCount' => count($responseData),
        'recordCount' => $recordCount,
        'csvFile' => 'storage/dse-cache/' . basename($responseCsvPath),
        'scope' => $scope->isRestricted() ? 'watch-list' : 'all',
        'requestedCodes' => array_keys($codes),
        'cached' => $fresh,
        'parseStats' => $GLOBALS['DSE_PARSE_STATS'] ?? null,
        'chunks' => $chunkReport ?? [],
        'availableCodes' => array_keys($responseData),
        'processingSeconds' => round(microtime(true) - $requestStartedAt, 3),
        'completedAt' => date(DATE_ATOM),
        'data' => $responseData,
    ]);
} catch (Throwable $e) {
    $status = $e instanceof ApiError ? $e->status : 500;
    jsonResponse([
        'success' => false,
        'message' => $e->getMessage(),
    ], $status);
}
