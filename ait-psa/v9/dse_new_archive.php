<?php
declare(strict_types=1);

/** Day-end rows published by the new DSE data archive. */
final class DseNewArchive
{
    private const BASE = 'https://www.dse.com.bd/api/live/data-archive/day-end';
    public const LIVE_URL = 'https://www.dse.com.bd/api/live/prices';

    /** @param array<string,true> $codes
     *  @param array<string,float> $amarstockOpens
     *  @return array<string,list<array<string,mixed>>>
     */
    public static function parseInstant(string $body, array $codes, array $amarstockOpens, string $marketDate): array
    {
        $payload = json_decode($body, true, 512, JSON_THROW_ON_ERROR);
        if (!is_array($payload) || !isset($payload['cols'], $payload['rows'])
            || !is_array($payload['cols']) || !is_array($payload['rows'])) {
            throw new RuntimeException('Invalid DSE live-price response.');
        }
        $columns = array_flip($payload['cols']);
        foreach (['code', 'ltp', 'open', 'high', 'low', 'ycp', 'volume'] as $field) {
            if (!isset($columns[$field])) throw new RuntimeException("DSE live prices are missing {$field}.");
        }
        $result = [];
        foreach ($payload['rows'] as $row) {
            if (!is_array($row)) continue;
            $code = strtoupper(trim((string) ($row[$columns['code']] ?? '')));
            if (!preg_match('/^[A-Z0-9().&_\-]{1,30}$/', $code) || ($codes && !isset($codes[$code]))) continue;
            $close = $row[$columns['ltp']] ?? null;
            if (!is_numeric($close) || (float) $close <= 0) continue;
            $close = (float) $close;
            $dseOpen = $row[$columns['open']] ?? null;
            $ycp = $row[$columns['ycp']] ?? null;
            $amarstockOpen = $amarstockOpens[$code] ?? null;
            $open = $amarstockOpen > 0 ? (float) $amarstockOpen
                : (is_numeric($dseOpen) && (float) $dseOpen > 0 ? (float) $dseOpen
                    : (is_numeric($ycp) && (float) $ycp > 0 ? (float) $ycp : $close));
            $high = $row[$columns['high']] ?? null;
            $low = $row[$columns['low']] ?? null;
            $volume = $row[$columns['volume']] ?? null;
            $high = is_numeric($high) && (float) $high > 0 ? max((float) $high, $open, $close) : max($open, $close);
            $low = is_numeric($low) && (float) $low > 0 ? min((float) $low, $open, $close) : min($open, $close);
            $result[$code] = [['date' => $marketDate, 'open' => $open, 'high' => $high, 'low' => $low,
                'close' => $close, 'volume' => is_numeric($volume) ? max(0, (float) $volume) : 0.0,
                'provisional' => true,
                'source' => $amarstockOpen > 0 ? 'Hybrid: AmarStock OpenP + DSE live market' : 'DSE live market',
                'openSource' => $amarstockOpen > 0 ? 'AmarStock' : 'DSE/YCP fallback',
                'marketSource' => 'DSE']];
        }
        if (!$result) throw new RuntimeException('DSE live prices returned no usable rows.');
        ksort($result);
        return $result;
    }

    public static function url(string $from, string $to, ?string $code = null, int $page = 1): string
    {
        $query = ['from' => $from, 'to' => $to];
        if ($code !== null) $query['inst'] = $code;
        $query['page'] = $page;
        return self::BASE . '?' . http_build_query($query, '', '&', PHP_QUERY_RFC3986);
    }

    /** @return array{rows:array<string,list<array<string,float|string>>>,total:int,page:int,pageSize:int} */
    public static function parsePage(string $body, string $from, string $to, ?string $requestedCode): array
    {
        $payload = json_decode($body, true, 512, JSON_THROW_ON_ERROR);
        if (!is_array($payload) || !isset($payload['rows'], $payload['total'], $payload['page'], $payload['pageSize'])
            || !is_array($payload['rows']) || !is_int($payload['total']) || !is_int($payload['page'])
            || !is_int($payload['pageSize']) || $payload['total'] < 0 || $payload['page'] < 1 || $payload['pageSize'] < 1) {
            throw new RuntimeException('Invalid DSE day-end archive response.');
        }
        $result = [];
        foreach ($payload['rows'] as $row) {
            if (!is_array($row)) throw new RuntimeException('Invalid DSE day-end row.');
            $code = strtoupper(trim((string) ($row['tradingCode'] ?? '')));
            $date = (string) ($row['date'] ?? '');
            if (!preg_match('/^[A-Z0-9().&_\-]{1,30}$/', $code) || $date < $from || $date > $to
                || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $date) || ($requestedCode !== null && $code !== $requestedCode)) {
                throw new RuntimeException('DSE day-end row is outside the requested symbol or date range.');
            }
            foreach (['openp', 'high', 'low', 'closep', 'volume'] as $field) {
                if (!isset($row[$field]) || !is_numeric($row[$field])) {
                    throw new RuntimeException("DSE day-end row is missing {$field}.");
                }
            }
            $open = (float) $row['openp']; $high = (float) $row['high'];
            $low = (float) $row['low']; $close = (float) $row['closep'];
            $volume = (float) $row['volume'];
            if ($open <= 0 || $close <= 0 || $low <= 0 || $high < max($open, $close)
                || $low > min($open, $close) || $volume < 0) {
                throw new RuntimeException('DSE day-end row contains inconsistent prices or volume.');
            }
            $result[$code][] = compact('date', 'open', 'high', 'low', 'close', 'volume');
        }
        return ['rows' => $result, 'total' => $payload['total'], 'page' => $payload['page'], 'pageSize' => $payload['pageSize']];
    }

    /** @param array<string,true> $codes
     *  @return array<string,list<array<string,float|string>>>
     */
    public static function fetch(string $from, string $to, array $codes, callable $request): array
    {
        $result = [];
        foreach ($codes ? array_keys($codes) : [null] as $code) {
            $page = 1;
            do {
                if ($page > 1000) throw new RuntimeException('DSE day-end archive exceeded the page limit.');
                $parsed = self::parsePage($request(self::url($from, $to, $code, $page)), $from, $to, $code);
                if ($parsed['page'] !== $page) throw new RuntimeException('DSE day-end page number changed unexpectedly.');
                foreach ($parsed['rows'] as $symbol => $rows) {
                    foreach ($rows as $row) $result[$symbol][$row['date']] = $row;
                }
                $last = (int) ceil($parsed['total'] / $parsed['pageSize']);
                if ($page < $last && $parsed['rows'] === []) throw new RuntimeException('DSE day-end archive ended before its final page.');
                $page++;
            } while ($page <= $last);
        }
        foreach ($result as &$rows) {
            ksort($rows);
            $rows = array_values($rows);
        }
        unset($rows);
        ksort($result);
        return $result;
    }
}
