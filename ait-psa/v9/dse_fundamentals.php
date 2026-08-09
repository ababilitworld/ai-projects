<?php
declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store, no-cache, must-revalidate');

final class DseFundamentalProvider
{
    private const DSE_URLS = [
        'https://www.dsebd.org/displayCompany.php?name=',
        'https://www.dse.com.bd/displayCompany.php?name=',
    ];

    /** @var list<string> */
    private const ALLOWED_HOSTS = [
        'www.dsebd.org', 'dsebd.org', 'www.dse.com.bd', 'dse.com.bd',
    ];

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
                $html = $this->downloadCompanyPage($code);
                $record = $this->parse($code, $html);
                if (!$this->hasUsefulData($record)) {
                    throw new RuntimeException('DSE returned no supported fundamental fields.');
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
            'source' => 'DSE company profile',
        ];
    }

    private function normalizeCode(mixed $value): string
    {
        $code = strtoupper(trim((string) $value));
        return preg_match('/^[A-Z0-9().-]{1,30}$/', $code) === 1 ? $code : '';
    }

    private function downloadCompanyPage(string $code): string
    {
        $messages = [];
        foreach (self::DSE_URLS as $baseUrl) {
            $url = $baseUrl . rawurlencode($code);
            try {
                $html = $this->request($url);
                if (stripos($html, $code) !== false || stripos($html, 'Company Name') !== false) {
                    return $html;
                }
                $messages[] = parse_url($url, PHP_URL_HOST) . ': unexpected company response';
            } catch (Throwable $exception) {
                $messages[] = parse_url($url, PHP_URL_HOST) . ': ' . $exception->getMessage();
            }
        }
        throw new RuntimeException(implode(' | ', $messages) ?: 'DSE company page could not be downloaded.');
    }

    private function request(string $url): string
    {
        if (!$this->isAllowedUrl($url)) {
            throw new RuntimeException('Source host is not allowed.');
        }
        if (!function_exists('curl_init')) {
            return $this->requestWithStreams($url);
        }

        try {
            return $this->requestWithCurl($url, true);
        } catch (RuntimeException $exception) {
            if (!$this->isCertificateError($exception->getMessage())) {
                throw $exception;
            }
            return $this->requestWithCurl($url, false);
        }
    }

    private function requestWithCurl(string $url, bool $verifyTls): string
    {
        $handle = curl_init($url);
        if ($handle === false) {
            throw new RuntimeException('Unable to initialize cURL.');
        }
        $options = [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_MAXREDIRS => 5,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_ENCODING => '',
            CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 Chrome/124 Safari/537.36',
            CURLOPT_HTTPHEADER => [
                'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                'Accept-Language: en-US,en;q=0.9',
                'Cache-Control: no-cache',
            ],
            CURLOPT_SSL_VERIFYPEER => $verifyTls,
            CURLOPT_SSL_VERIFYHOST => $verifyTls ? 2 : 0,
        ];
        if ($verifyTls && ($caBundle = $this->findCaBundle()) !== null) {
            $options[CURLOPT_CAINFO] = $caBundle;
        }
        curl_setopt_array($handle, $options);
        $body = curl_exec($handle);
        $status = (int) curl_getinfo($handle, CURLINFO_RESPONSE_CODE);
        $error = curl_error($handle);
        $errorNumber = curl_errno($handle);
        curl_close($handle);

        if (!is_string($body) || trim($body) === '') {
            throw new RuntimeException($error !== '' ? $error : 'Empty response.', $errorNumber);
        }
        if ($status >= 400) {
            throw new RuntimeException('HTTP ' . $status);
        }
        return $body;
    }

    private function requestWithStreams(string $url): string
    {
        foreach ([true, false] as $verifyTls) {
            $ssl = [
                'verify_peer' => $verifyTls,
                'verify_peer_name' => $verifyTls,
                'allow_self_signed' => !$verifyTls,
            ];
            if ($verifyTls && ($caBundle = $this->findCaBundle()) !== null) {
                $ssl['cafile'] = $caBundle;
            }
            $context = stream_context_create([
                'http' => [
                    'method' => 'GET',
                    'timeout' => 30,
                    'follow_location' => 1,
                    'max_redirects' => 5,
                    'ignore_errors' => true,
                    'header' => implode("\r\n", [
                        'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 Chrome/124 Safari/537.36',
                        'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                        'Accept-Language: en-US,en;q=0.9',
                    ]),
                ],
                'ssl' => $ssl,
            ]);
            $body = @file_get_contents($url, false, $context);
            if (is_string($body) && trim($body) !== '') {
                return $body;
            }
        }
        throw new RuntimeException('DSE request returned no content.');
    }

    private function isAllowedUrl(string $url): bool
    {
        return in_array(strtolower((string) parse_url($url, PHP_URL_HOST)), self::ALLOWED_HOSTS, true);
    }

    private function isCertificateError(string $message): bool
    {
        $message = strtolower($message);
        return str_contains($message, 'ssl certificate problem')
            || str_contains($message, 'unable to get local issuer certificate')
            || str_contains($message, 'certificate verify failed')
            || str_contains($message, 'self-signed certificate');
    }

    private function findCaBundle(): ?string
    {
        foreach ([(string) ini_get('curl.cainfo'), (string) ini_get('openssl.cafile'), __DIR__ . '/cacert.pem',
            '/etc/ssl/certs/ca-certificates.crt', '/etc/pki/tls/certs/ca-bundle.crt', '/etc/ssl/ca-bundle.pem'] as $candidate) {
            $candidate = trim($candidate);
            if ($candidate !== '' && is_file($candidate) && is_readable($candidate)) {
                return $candidate;
            }
        }
        return null;
    }

    /** @return array<string,mixed> */
    private function parse(string $code, string $html): array
    {
        if (!class_exists(DOMDocument::class) || !class_exists(DOMXPath::class)) {
            throw new RuntimeException('PHP DOM extension is required for DSE fundamentals parsing.');
        }

        $document = new DOMDocument();
        $previous = libxml_use_internal_errors(true);
        $loaded = $document->loadHTML('<?xml encoding="utf-8" ?>' . $html, LIBXML_NOWARNING | LIBXML_NOERROR);
        libxml_clear_errors();
        libxml_use_internal_errors($previous);
        if (!$loaded) {
            throw new RuntimeException('DSE company page HTML could not be parsed.');
        }

        $xpath = new DOMXPath($document);
        $fields = $this->extractLabelValueFields($xpath);

        $companyName = $this->findText($fields, ['Company Name']);
        $category = $this->findCategory($fields);
        $business = $this->findBusinessSegment($fields);
        $yearEnd = $this->findText($fields, ['Year End', 'Financial Year End', 'Financial Year Ended', 'Accounting Year End']);
        $lastAgm = $this->findDate($fields, ['Last AGM Held on', 'Last AGM Held On', 'Last AGM Date', 'Last AGM']);

        return [
            'code' => $code,
            'companyName' => $companyName,
            'category' => $category,
            'businessSegment' => $business,
            'yearEnd' => $yearEnd,
            'lastAgmDate' => $lastAgm,
            'allFundamentals' => [
                'Company Name' => $companyName,
                'Category' => $category,
                'Business Segment' => $business,
                'Year End' => $yearEnd,
                'Last AGM' => $lastAgm,
            ],
            'source' => 'DSE company profile',
            'sourcePolicy' => 'DSE-only: Category, Business Segment, Year End, Last AGM',
            'downloadedAt' => gmdate(DATE_ATOM),
        ];
    }

    /** @return array<string,string> */
    private function extractLabelValueFields(DOMXPath $xpath): array
    {
        $fields = [];
        $rows = $xpath->query('//tr');
        if ($rows === false) {
            return $fields;
        }

        foreach ($rows as $row) {
            $cells = $xpath->query('./th|./td', $row);
            if ($cells === false || $cells->length < 2) {
                continue;
            }
            $values = [];
            foreach ($cells as $cell) {
                $values[] = $this->cleanText($cell->textContent);
            }
            $count = count($values);
            for ($index = 0; $index < $count - 1; $index++) {
                $label = $this->normalizeLabel($values[$index]);
                if ($label === '') {
                    continue;
                }
                for ($next = $index + 1; $next < $count; $next++) {
                    $value = $values[$next];
                    if ($value === '') {
                        continue;
                    }
                    if ($this->looksLikeLabel($value) && $next > $index + 1) {
                        break;
                    }
                    if (!isset($fields[$label])) {
                        $fields[$label] = $value;
                    }
                    break;
                }
            }
        }
        return $fields;
    }

    private function normalizeLabel(string $value): string
    {
        return strtolower(trim(preg_replace('/\s+/', ' ', rtrim($value, " :\t\n\r\0\x0B")) ?? ''));
    }

    private function cleanText(string $value): string
    {
        return trim(preg_replace('/\s+/', ' ', html_entity_decode($value, ENT_QUOTES | ENT_HTML5, 'UTF-8')) ?? '');
    }

    private function looksLikeLabel(string $value): bool
    {
        $normalized = $this->normalizeLabel($value);
        return in_array($normalized, [
            'company name', 'market category', 'category', 'sector', 'industry',
            'nature of business', 'business segment', 'year end', 'financial year end', 'financial year ended', 'accounting year end', 'last agm held on',
            'last agm date', 'last agm',
        ], true);
    }

    /** @param array<string,string> $fields */
    private function findText(array $fields, array $labels): ?string
    {
        foreach ($labels as $label) {
            $key = $this->normalizeLabel((string) $label);
            $value = $fields[$key] ?? null;
            if ($value !== null && $value !== '' && mb_strlen($value) <= 240) {
                return $value;
            }
        }
        return null;
    }

    /** @param array<string,string> $fields */
    private function findCategory(array $fields): ?string
    {
        $value = $this->findText($fields, ['Market Category', 'Category']);
        if ($value === null) {
            return null;
        }
        if (preg_match('/\b([A-Z])\b/i', $value, $matches) === 1) {
            return strtoupper($matches[1]);
        }
        return null;
    }

    /** @param array<string,string> $fields */
    private function findBusinessSegment(array $fields): ?string
    {
        foreach (['Sector', 'Industry', 'Business Segment', 'Nature of Business'] as $label) {
            $value = $this->findText($fields, [$label]);
            if ($value === null) {
                continue;
            }
            $lower = strtolower($value);
            if (str_contains($lower, 'present loan status') || str_contains($lower, 'credit rating')) {
                continue;
            }
            return $value;
        }
        return null;
    }

    /** @param array<string,string> $fields */
    private function findDate(array $fields, array $labels): ?string
    {
        $value = $this->findText($fields, $labels);
        if ($value === null) {
            return null;
        }
        if (preg_match('/\b(?:\d{1,2}[-\/.]\d{1,2}[-\/.]\d{2,4}|\d{4}-\d{2}-\d{2})\b/', $value, $matches) === 1) {
            return $matches[0];
        }
        return null;
    }

    /** @param array<string,mixed> $record */
    private function hasUsefulData(array $record): bool
    {
        return ($record['category'] ?? null) !== null
            || ($record['businessSegment'] ?? null) !== null
            || ($record['yearEnd'] ?? null) !== null
            || ($record['lastAgmDate'] ?? null) !== null;
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
    $result = (new DseFundamentalProvider())->fetch($codes);
    echo json_encode(['ok' => true] + $result, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
} catch (Throwable $exception) {
    http_response_code(400);
    echo json_encode(['ok' => false, 'message' => $exception->getMessage()], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
}
