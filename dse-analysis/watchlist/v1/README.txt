DSE PHP cURL Watch List Terminal
=================================

Requirements
------------
- PHP 8.1 or newer
- PHP cURL extension
- PHP DOM extension
- Write permission for storage/dse-cache

Installation
------------
1. Upload the complete dse_php_terminal folder to your PHP hosting.
2. Make storage/dse-cache writable by PHP.
3. Open index.php in your browser.
4. Create/import the mother trading-code list and create watch lists.
5. Click "Download DSE 3M & View Charts".

How it works
------------
- index.php keeps watch lists and chart data in browser localStorage.
- dse_archive.php downloads DSE day-end archive data with server-side cURL.
- The endpoint normalizes the DSE table into:
  TRADING_CODE, DATE, OPEN, HIGH, LOW, CLOSE, VOLUME
- CSV, JSON and raw HTML cache files are stored in storage/dse-cache.
- Only requested watch-list codes are returned when the dashboard requests a 3-month update.

Endpoint examples
-----------------
JSON:
dse_archive.php?startDate=2026-04-01&endDate=2026-07-27&format=json

Watch-list-only JSON:
dse_archive.php?startDate=2026-04-01&endDate=2026-07-27&codes=SUMITPOWER,ROBI&format=json

CSV:
dse_archive.php?startDate=2026-04-01&endDate=2026-07-27&format=csv

Security/operational notes
--------------------------
- Date range is limited to 370 days.
- Trading codes are sanitized.
- Cache expires after 6 hours.
- The endpoint only connects to the fixed DSE archive URL.
- Do not open index.php as file://; serve it through PHP/Apache/Nginx.


SSL fix
-------
The downloader now checks php.ini and common CA bundle paths. On localhost and
.test/.localhost/.local domains only, certificate errors retry without SSL
verification. Use this only for local development.

For a permanent fix, put cacert.pem beside dse_archive.php and set:

curl.cainfo = "C:\path\to\cacert.pem"
openssl.cafile = "C:\path\to\cacert.pem"

Restart Apache/PHP after editing php.ini. Open diagnostics.php to inspect the
active configuration.

V4 chart visibility fixes
-------------------------
- Fixed the search input/search text property collision.
- Forces a fresh v4 DSE cache so older parser output is not reused.
- Recognizes DSE OPENP/HIGHP/LOWP/CLOSEP headers.
- Adds View Downloaded Data for direct verification.
- Opens the chart modal before drawing canvases.
- Normalizes all PHP JSON numbers before saving locally.

Version 5 timeout fix
---------------------
- Removes the browser's 120-second AbortController timeout.
- Splits requested ranges into 14-day DSE downloads.
- Merges successful chunks into one local JSON/CSV result.
- Continues when an individual chunk fails.
- Uses set_time_limit(0) and ignore_user_abort(true) for local/server processing.


V7 important change
-------------------
PHP now parses the full DSE archive without filtering by watch-list codes.
The browser normalizes and matches watch-list codes after receiving the data.
This prevents valid DSE data from becoming an empty result due to code formatting.

Use archive_status.php to inspect generated raw, JSON and CSV cache files.
Hard refresh the dashboard with Ctrl+F5 after replacing the files.


V8 download-status panel
------------------------
After clicking a DSE download button, the dashboard now displays:
- Preparing DSE download
- Downloading DSE archive
- Reading server response
- Matching watch-list codes
- Saving downloaded data
- Download completed

The completed status remains visible and includes elapsed time, saved record count,
matched code count and any missing watch-list codes.


V9 premium interface
--------------------
- Premium dark-glass terminal theme
- Stronger visual hierarchy and spacing
- Responsive command header and live workspace metrics
- Improved buttons, inputs, tables, modals and chart cards
- Animated download-status panel
- Keyboard shortcuts:
  Ctrl/Cmd + D = download 3-month data
  Ctrl/Cmd + G = open saved chart gallery
  Esc = close open dialogs
- Existing v8 download, parsing and chart logic preserved


V10 mobile-first premium workspace
----------------------------------
Preserves the working v9 PHP DSE downloader, parser, local history, watch lists,
charts, backups and import/export behavior.

New interface features:
- Nine persistent selectable themes:
  1. Premium Dark Glass
  2. Classic Light (previous design)
  3. Sapphire
  4. Emerald
  5. Royal Purple
  6. Carbon OLED
  7. Crimson
  8. Coffee
  9. Aurora
- Mobile-first layout with bottom navigation
- Slide-out watch-list drawer on phones and tablets
- Grouped Download, View, Backup and Theme dropdown controls
- Collapsible overview, summary, download center, market workspace,
  mother-directory and active-watch-list sections
- Open/closed states remembered locally
- Selected theme remembered locally
- Existing tested controls remain in the page and grouped actions safely proxy them
- Responsive one-column, two-column and full desktop layouts

After installation, hard refresh using Ctrl + F5.
