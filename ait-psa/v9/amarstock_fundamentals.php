<?php

declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store, no-cache, must-revalidate');

final class AmarStockFundamentalProvider
{
    private const DATA_BASE_URL = 'https://www.amarstock.com/data/11bfa580-3cc4a8b9e57d/';
    private const STOCK_BASE_URL = 'https://www.amarstock.com/stock/';
    private const ALLOWED_HOSTS = ['www.amarstock.com', 'amarstock.com'];

    /** @param list<mixed> $codes */
    public function fetch(array $codes): array
    {
        $normalized = [];
        foreach ($codes as $value) {
            $code = $this->normalizeCode($value);
            if ($code !== '') {
                $normalized[$code] = true;
            }
        }

        $data = [];
        $failed = [];
        $errors = [];

        foreach (array_keys($normalized) as $code) {
            try {
                $payload = $this->requestJson($code);
                $record = $this->parseRecord($code, $payload);
                if (!$this->hasUsefulData($record)) {
                    throw new RuntimeException('AmarStock JSON returned no supported fundamental values.');
                }
                $data[$code] = $record;
            } catch (Throwable $exception) {
                $failed[] = $code;
                $errors[$code] = $exception->getMessage();
            }
        }

        return [
            'data' => $data,
            'failed' => $failed,
            'errors' => $errors,
            'source' => 'AmarStock JSON fundamentals API',
        ];
    }

    private function normalizeCode(mixed $value): string
    {
        $code = strtoupper(trim((string) $value));
        return preg_match('/^[A-Z0-9().-]{1,30}$/', $code) === 1 ? $code : '';
    }

    /** @return array<mixed> */
    private function requestJson(string $code): array
    {
        if (!function_exists('curl_init')) {
            throw new RuntimeException('PHP cURL is required for AmarStock fundamentals.');
        }

        $url = self::DATA_BASE_URL . rawurlencode($code);
        $host = strtolower((string) parse_url($url, PHP_URL_HOST));
        if (!in_array($host, self::ALLOWED_HOSTS, true)) {
            throw new RuntimeException('Source host is not allowed.');
        }

        $handle = curl_init($url);
        if ($handle === false) {
            throw new RuntimeException('Unable to initialize cURL.');
        }

        curl_setopt_array($handle, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_MAXREDIRS => 5,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_TIMEOUT => 25,
            CURLOPT_ENCODING => '',
            CURLOPT_USERAGENT => 'Mozilla/5.0',
            CURLOPT_REFERER => self::STOCK_BASE_URL . rawurlencode($code),
            CURLOPT_HTTPHEADER => [
                'Accept: application/json, text/plain, */*',
                'Accept-Language: en-US,en;q=0.9',
                'Cache-Control: no-cache',
                'Pragma: no-cache',
            ],
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_SSL_VERIFYHOST => 2,
            CURLOPT_HTTP_VERSION => defined('CURL_HTTP_VERSION_2TLS')
                ? CURL_HTTP_VERSION_2TLS
                : CURL_HTTP_VERSION_1_1,
        ]);

        $body = curl_exec($handle);
        $status = (int) curl_getinfo($handle, CURLINFO_RESPONSE_CODE);
        $error = curl_error($handle);
        curl_close($handle);

        if (!is_string($body) || trim($body) === '') {
            throw new RuntimeException($error !== '' ? $error : 'Empty AmarStock JSON response.');
        }
        if ($status >= 400) {
            throw new RuntimeException('AmarStock JSON HTTP ' . $status);
        }

        try {
            $decoded = json_decode($body, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $exception) {
            throw new RuntimeException('Invalid AmarStock JSON: ' . $exception->getMessage());
        }

        if (!is_array($decoded)) {
            throw new RuntimeException('Unexpected AmarStock JSON payload.');
        }

        return $decoded;
    }

    /** @param array<mixed> $payload @return array<string,mixed> */
    private function parseRecord(string $code, array $payload): array
    {
        return [
            'code' => $code,
            'peRatio' => $this->numberByKey($payload, 'cc', -1000, 100000),
            'eps' => $this->numberByKey($payload, 'cb', -100000, 100000),
            'priceNav' => $this->numberByKey($payload, 'cj', -1000, 100000),
            'freeFloat' => $this->numberByKey($payload, 'ck', 0, 100),
            'beta' => $this->numberByKey($payload, 'do', -100, 100),
            'dividendYield' => $this->numberByKey($payload, 'cm', 0, 10000),
            'amarstockDownloadedAt' => gmdate(DATE_ATOM),
            'amarstockSource' => self::DATA_BASE_URL . $code,
        ];
    }

    /** @param array<mixed> $payload */
    private function numberByKey(array $payload, string $wantedKey, float $min, float $max): ?float
    {
        $value = $this->findKeyRecursive($payload, $wantedKey);
        if ($value === null) {
            return null;
        }

        if (is_int($value) || is_float($value)) {
            $number = (float) $value;
        } elseif (is_string($value)) {
            $clean = str_replace([',', '%', 'Tk.', 'Tk', 'x'], '', trim($value));
            if (preg_match('/-?\d+(?:\.\d+)?/', $clean, $match) !== 1) {
                return null;
            }
            $number = (float) $match[0];
        } else {
            return null;
        }

        return is_finite($number) && $number >= $min && $number <= $max ? $number : null;
    }

    /** @param array<mixed> $payload */
    private function findKeyRecursive(array $payload, string $wantedKey): mixed
    {
        if (array_key_exists($wantedKey, $payload)) {
            return $payload[$wantedKey];
        }

        foreach ($payload as $value) {
            if (is_array($value)) {
                $found = $this->findKeyRecursive($value, $wantedKey);
                if ($found !== null) {
                    return $found;
                }
            }
        }

        return null;
    }

    /** @param array<string,mixed> $record */
    private function hasUsefulData(array $record): bool
    {
        foreach (['peRatio', 'eps', 'priceNav', 'freeFloat', 'beta', 'dividendYield'] as $key) {
            if (($record[$key] ?? null) !== null) {
                return true;
            }
        }
        return false;
    }
}

try {
    if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
        throw new RuntimeException('POST request required.');
    }

    $payload = json_decode((string) file_get_contents('php://input'), true, 512, JSON_THROW_ON_ERROR);
    $codes = is_array($payload['codes'] ?? null) ? $payload['codes'] : [];
    if ($codes === []) {
        throw new RuntimeException('No trading codes were supplied.');
    }

    $result = (new AmarStockFundamentalProvider())->fetch($codes);
    echo json_encode(
        ['ok' => true] + $result,
        JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR
    );
} catch (Throwable $exception) {
    http_response_code(400);
    echo json_encode(
        ['ok' => false, 'message' => $exception->getMessage()],
        JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
    );
}
