<?php
declare(strict_types=1);

/** Company news from the new DSE archive API. */
final class DseNewNews
{
    public static function url(string $code, string $start, string $end): string
    {
        return 'https://www.dse.com.bd/api/live/news?' . http_build_query(
            ['from' => $start, 'to' => $end, 'code' => $code], '', '&', PHP_QUERY_RFC3986
        );
    }

    /** @return array{rows:list<array<string,string>>,truncated:bool} */
    public static function parse(string $body, string $code, string $start, string $end): array
    {
        $payload = json_decode($body, true, 512, JSON_THROW_ON_ERROR);
        if (!is_array($payload) || !isset($payload['rows'], $payload['truncated'])
            || !is_array($payload['rows']) || !is_bool($payload['truncated'])) {
            throw new RuntimeException('Invalid DSE news response.');
        }
        $rows = [];
        foreach ($payload['rows'] as $row) {
            if (!is_array($row) || strtoupper((string) ($row['code'] ?? '')) !== $code) {
                throw new RuntimeException('DSE news response contains another trading code.');
            }
            $date = (string) ($row['filedAt'] ?? '');
            if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date) || $date < $start || $date > $end) {
                throw new RuntimeException('DSE news response contains an out-of-range date.');
            }
            $title = trim((string) ($row['summary'] ?? ''));
            $bodyText = trim((string) ($row['body'] ?? ''));
            if ($title === '' || $bodyText === '') throw new RuntimeException('DSE news response is missing title or body.');
            $id = hash('sha256', implode('|', [$code, $date, $title, $bodyText]));
            $rows[$id] = ['code' => $code, 'date' => $date, 'title' => $title,
                'body' => $bodyText, 'id' => $id, 'sourceUrl' => self::url($code, $date, $date)];
        }
        return ['rows' => array_values($rows), 'truncated' => $payload['truncated']];
    }

    /** @return list<array<string,string>> */
    public static function fetch(string $code, string $start, string $end, callable $request): array
    {
        $parsed = self::parse($request(self::url($code, $start, $end)), $code, $start, $end);
        if (!$parsed['truncated']) return $parsed['rows'];
        if ($start === $end) throw new RuntimeException('DSE news is truncated for a single day.');
        $first = new DateTimeImmutable($start);
        $last = new DateTimeImmutable($end);
        $middle = $first->add(new DateInterval('P' . intdiv((int) $first->diff($last)->format('%a'), 2) . 'D'));
        $mid = $middle->format('Y-m-d');
        $next = $middle->add(new DateInterval('P1D'))->format('Y-m-d');
        $rows = [];
        foreach (array_merge(self::fetch($code, $start, $mid, $request), self::fetch($code, $next, $end, $request)) as $row) {
            $rows[$row['id']] = $row;
        }
        return array_values($rows);
    }
}
