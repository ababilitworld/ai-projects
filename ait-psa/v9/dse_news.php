<?php
declare(strict_types=1);

/** Public DSE archive adapter. One symbol per request keeps retries bounded. */
final class DseNewsProvider
{
    public static function sourceUrl(string $code, string $start, string $end): string
    {
        return 'https://www.dsebd.org/old_news.php?' . http_build_query([
            'startDate' => $start, 'endDate' => $end, 'inst' => $code,
            'criteria' => '4', 'archive' => 'news',
        ], '', '&', PHP_QUERY_RFC3986);
    }

    public static function date(string $value): string
    {
        $date = DateTimeImmutable::createFromFormat('!Y-m-d', $value);
        if (!$date || $date->format('Y-m-d') !== $value) {
            throw new InvalidArgumentException('Expected a valid YYYY-MM-DD date.');
        }
        return $value;
    }

    public function parse(string $html, string $code, string $start, string $end): array
    {
        if (!str_contains(strtolower($html), '</html>')) {
            throw new RuntimeException('DSE returned an incomplete archive page. Retry this symbol.');
        }
        $doc = new DOMDocument();
        $previous = libxml_use_internal_errors(true);
        $doc->loadHTML('<?xml encoding="UTF-8">' . $html, LIBXML_NONET);
        libxml_clear_errors();
        libxml_use_internal_errors($previous);
        $xpath = new DOMXPath($doc);
        $rows = []; $current = []; $recognized = false; $recordsSeen = 0;
        foreach ($xpath->query('//tr') as $tr) {
            $cells = $xpath->query('./th|./td', $tr);
            if ($cells->length !== 2) continue;
            $label = strtolower(trim(preg_replace('/\s+/', ' ', $cells->item(0)->textContent), " \t\n\r\0\x0B:"));
            $value = trim(preg_replace('/\s+/u', ' ', $cells->item(1)->textContent));
            if ($label === 'trading code') {
                if ($current !== []) throw new RuntimeException('DSE returned an incomplete news record.');
                $recognized = true; $current = ['code' => strtoupper($value)];
            } elseif ($label === 'news title') {
                $current['title'] = $value;
            } elseif ($label === 'news') {
                $current['body'] = $value;
            } elseif ($label === 'post date') {
                $recordsSeen++;
                $date = self::date(substr($value, 0, 10));
                if (!isset($current['code'], $current['title'], $current['body'])) {
                    throw new RuntimeException('DSE news record is missing required fields.');
                }
                if ($current['code'] !== $code || $date < $start || $date > $end) {
                    throw new RuntimeException('DSE did not honor the requested symbol/date scope.');
                }
                $current['date'] = $date;
                $current['id'] = hash('sha256', implode('|', [$code, $date, $current['title'], $current['body']]));
                $current['sourceUrl'] = self::sourceUrl($code, $date, $date);
                $rows[$current['id']] = $current;
                $current = [];
            }
        }
        if ($current !== [] || ($recognized && $recordsSeen === 0)) throw new RuntimeException('Incomplete DSE news records.');
        if (!$recognized && !preg_match('/no\s+(?:new\s+)?(?:news|data|record|result)s?\s*(?:found|available|to display)?/i', strip_tags($html))) {
            throw new RuntimeException('Unrecognized DSE archive response; existing news has been preserved.');
        }
        usort($rows, fn($a, $b) => strcmp($a['date'], $b['date']) ?: strcmp($a['id'], $b['id']));
        return array_values($rows);
    }

    public function fetch(string $code, string $start, string $end, bool $force = false): array
    {
        $dir = __DIR__ . '/storage/dse-news-cache';
        if (!is_dir($dir) && !mkdir($dir, 0775, true) && !is_dir($dir)) throw new RuntimeException('Cannot create news cache.');
        $file = $dir . '/' . hash('sha256', "$code|$start|$end") . '.json';
        if (!$force && is_file($file) && filemtime($file) > time() - 21600) {
            $saved = json_decode((string) file_get_contents($file), true);
            if (is_array($saved)) return $saved + ['cached' => true];
        }
        $handle = curl_init(self::sourceUrl($code, $start, $end));
        curl_setopt_array($handle, [
            CURLOPT_RETURNTRANSFER => true, CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_CONNECTTIMEOUT => 12, CURLOPT_TIMEOUT => 60,
            CURLOPT_ENCODING => '', CURLOPT_PROTOCOLS => CURLPROTO_HTTPS,
            CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 Chrome/124 Safari/537.36',
            CURLOPT_HTTPHEADER => ['Accept: text/html', 'Accept-Language: en-US,en;q=0.9'],
        ]);
        // libcurl supports Windows native trust since 7.71, before PHP exposed
        // the named bit. Keep peer/hostname verification enabled on older Laragon.
        if (PHP_OS_FAMILY === 'Windows' && curl_version()['version_number'] >= 0x074700) {
            curl_setopt($handle, CURLOPT_SSL_OPTIONS, defined('CURLSSLOPT_NATIVE_CA') ? CURLSSLOPT_NATIVE_CA : 16);
        }
        foreach ([getenv('DSE_CACERT_PATH'), __DIR__ . '/storage/dse-news-ca.pem', __DIR__ . '/storage/cacert.pem', __DIR__ . '/cacert.pem',
            ini_get('curl.cainfo'), ini_get('openssl.cafile'), 'C:/laragon/etc/ssl/cacert.pem',
            '/etc/ssl/certs/ca-certificates.crt'] as $ca) {
            if ($ca && is_file($ca)) {curl_setopt($handle, CURLOPT_CAINFO, $ca); break;}
        }
        $html = curl_exec($handle); $status = curl_getinfo($handle, CURLINFO_RESPONSE_CODE); $error = curl_error($handle);
        curl_close($handle);
        if (!is_string($html) || $status !== 200) throw new RuntimeException($error ?: "DSE returned HTTP $status. Retry later.");
        $rows = $this->parse($html, $code, $start, $end);
        preg_match('/News from:\s*(\d{4}-\d{2}-\d{2})\s*To:\s*(\d{4}-\d{2}-\d{2})/i', strip_tags($html), $sourceRange);
        $payload = ['code' => $code, 'rows' => $rows, 'start' => $start, 'end' => $end,
            'sourceStart' => $sourceRange[1] ?? $start, 'sourceEnd' => $sourceRange[2] ?? $end,
            'downloadedAt' => gmdate('c'), 'sourceUrl' => self::sourceUrl($code, $start, $end)];
        if (file_put_contents($file, json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR), LOCK_EX) === false) {
            throw new RuntimeException('Unable to save the DSE news cache.');
        }
        return $payload + ['cached' => false];
    }
}

if (realpath($_SERVER['SCRIPT_FILENAME'] ?? '') === __FILE__) {
    header('Content-Type: application/json; charset=utf-8');
    header('Cache-Control: no-store');
    header('X-Content-Type-Options: nosniff');
    try {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') throw new InvalidArgumentException('Use POST to download news.');
        $input = json_decode(file_get_contents('php://input'), true, 32, JSON_THROW_ON_ERROR);
        $code = strtoupper(trim((string) ($input['code'] ?? '')));
        if (!preg_match('/^[A-Z0-9().&_\-]{1,30}$/', $code)) throw new InvalidArgumentException('A valid trading code is required.');
        $start = DseNewsProvider::date((string) ($input['start'] ?? '1900-01-01'));
        $today = (new DateTimeImmutable('now', new DateTimeZone('Asia/Dhaka')))->format('Y-m-d');
        $end = DseNewsProvider::date((string) ($input['end'] ?? $today));
        if ($start < '1900-01-01' || $end > $today || $start > $end) throw new InvalidArgumentException('Invalid news archive range.');
        echo json_encode(['ok' => true] + (new DseNewsProvider())->fetch($code, $start, $end, !empty($input['force'])), JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
    } catch (Throwable $e) {
        http_response_code($e instanceof InvalidArgumentException || $e instanceof JsonException ? 400 : 502);
        echo json_encode(['ok' => false, 'message' => $e->getMessage()]);
    }
}
