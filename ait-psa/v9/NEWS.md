# DSE news

Open **Workspace → Data Center → Download → News** (beside OHLC), or
**Data Center → Report → News**. The Report center also links to News.

- Download all news requests every article DSE currently exposes for each active-list symbol.
  DSE currently clamps the archive start to approximately two years before today.
  The workspace shows the source availability date and retains older locally saved articles.
- Update news checks from each symbol's last downloaded date, inclusively. Symbols without
  downloads receive the full available archive. Failed symbols can be retried; stopping finishes
  the current symbol first. Changing lists during a download does not change its captured scope.
- Data persists in IndexedDB `ait-psa-dse-news-v1`, normalized by symbol. Reports filter by the
  current watch list, search text, symbol, category, subtype and publication dates. Export filtered CSV
  saves the table's filtered rows in their current sort order. The five columns are Date, Trading Code,
  CloseP, News Category - Subcategory, and News; every column uses the scanner table's sorting/filtering component.
  News has its own store;
  existing dashboard JSON backups do not include it.
- Classification uses announcement wording. Financials (Q1/Q2/Q3/Q4), Dividend (Declaration/Disbursement),
  Spot News, Trading (Suspension/Resumption), Credit Rating, General, Price Hike,
  Declaration (Buy/Sell/Transfer), Board Meeting and other disclosures have unique category symbols and colors.
  Subtypes reuse the category symbol with distinct muted colors. Multi-topic
  announcements can carry multiple tags. Original text and a DSE source link remain available.
- Both production chart renderers use the same category and overlay code. This includes
  individual charts, 3M/6M/1Y watch-list galleries, ranked scanner galleries and all multi-chart layouts.
  Markers start at `low * 0.9` and stack for distinct subtypes on the same date. Price bounds include
  the markers. A single close point is plotted per matching publication date. Consecutive news-day
  closes are joined in green (higher), red (lower) or dark gray (equal), across all categories.
  Publication dates without an exact OHLC match remain in the report but are not charted.
  Zero CloseP uses the previous valid trading-day close (including history before the visible range).
  If the low is also zero, the marker uses 90% of that fallback price. Stored OHLC is never overwritten.
  If no previous positive close exists, the news line point is omitted rather than inventing a price.
  Hover markers for titles or click to open that symbol/date in the News workspace.

`dse_news.php` validates symbols/dates, parses the DSE archive's label/value rows, rejects
partial and unexpected responses and caches successful results for six hours. Full and retry
requests refresh that cache. TLS peer and hostname verification stay enabled. The bundled
`storage/dse-news-ca.pem` contains DSE's issuer/root chain validated through Windows trust;
`DSE_CACERT_PATH` overrides it. `tests/inspect-dse-chain.ps1` refreshes that chain using normal
Windows certificate validation if the upstream issuer changes.

Validation:

```text
node tests/ait-news.test.cjs
php tests/dse-news.test.php
php -l dse_news.php
php -l index.php
```

`tests/news-chart-preview.php` visually exercises both real chart renderers with synthetic prices
and green/red/equal segments. `tests/news-workspace-preview.php` runs the actual app with a GP
test watch list and separate dashboard, OHLC and news storage, for download/filter/reload checks.
The existing active-list, download-cache, report-menu and sortable-table tests also pass.
