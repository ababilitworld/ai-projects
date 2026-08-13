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


V10.5 professional dashboard
----------------------------
Built on the working v10 package and preserves:
- DSE PHP archive downloader and parser
- Local OHLC history
- Permanent watch lists
- Chart gallery
- Nine themes
- Mobile drawer and bottom navigation
- Collapsible workspace sections
- Backup and restore

New in v10.5:
- Professional dashboard hero and terminal-health summary
- Live metrics for watch lists, active codes, stored records and covered symbols
- Download queue connected to the existing download-status events
- Persistent recent-activity timeline
- Persistent notification center with unread badges
- Right-side notification/workspace drawer
- Command palette with search and keyboard navigation
- Workspace switcher for Trading, Download, Charts and Overview
- In-app toast notifications
- Additional keyboard shortcuts:
  Ctrl/Cmd + K = command palette
  Ctrl/Cmd + B = notification center
  Ctrl/Cmd + D = download 3-month data
  Ctrl/Cmd + G = chart gallery
  Esc = close active overlay
- Mobile-first dashboard layouts from one column to three columns


V11 trading terminal
--------------------
Preserves all working v10.5 capabilities and adds:

- Multi-chart workspace with 1, 2 and 4 chart layouts
- Local candlestick rendering from stored OHLC history
- SMA 20 and SMA 50 overlays
- Technical scanner with SMA, RSI, momentum and mechanical signals
- Stock comparison for 20-day return, volatility, relative volume and momentum
- Local portfolio workspace with quantity, buy price, current value and unrealized P/L
- VPA-style heuristic workspace using spread, relative volume, trend and effort/result
- Watch-list explorer with symbol search and direct chart opening
- Report center for watch-list, technical, comparison and portfolio reports
- Downloadable text reports
- New terminal tab navigation and mobile-first layouts
- Ctrl/Cmd + Shift + T opens the trading terminal

Important:
The technical and VPA outputs are transparent mechanical calculations from locally
stored OHLCV data. They are not guaranteed predictions or investment advice.


V11.1 chart-viewer fix
----------------------
- View Charts now opens in a fixed top-layer modal above the watch-list and every dashboard section.
- Added a clear red Close button.
- Clicking the dimmed backdrop closes the chart viewer.
- Escape closes the viewer.
- Full-screen toggle is included.
- Press F while the viewer is open to toggle full screen.
- The page cannot scroll behind the chart viewer.
- Existing chart modal content is moved temporarily into the top-layer viewer and restored on close.
- Double-clicking a watch-list item opens View Charts.
- Pressing Enter on a focused watch-list item opens View Charts.
- Watch-list items receive keyboard focus where possible.
- The active watch-list name and security count are displayed in the modal header.


V11.2 workspace architecture
----------------------------
This release removes the chart-over-dashboard behavior.

When View Charts is opened:
- The entire dashboard is hidden.
- The watch-list section is hidden.
- Toolbars, cards and dashboard panels are hidden.
- A dedicated full-window Chart Workspace becomes the only visible interface.
- Existing chart content is moved into the Chart Workspace.
- A Back to Dashboard button restores the normal application.
- Escape returns to the dashboard.
- F toggles full screen.
- Refresh forces chart resizing and re-detection.
- Double-click or Enter on a watch-list item opens its charts.
- The active watch-list name and code count remain visible in the chart toolbar.

This is a true workspace switch, not a z-index/modal patch.


V11.3 Watch Lists / 3M chart layering fix
-----------------------------------------
- Forces the Watch Lists / Manage stock groups panel into a low stacking layer.
- Forces the 3M Charts modal and all chart modals above every dashboard panel.
- Keeps the chart backdrop above Watch Lists.
- Temporarily hides Watch Lists while a chart modal is visibly open.
- Automatically restores Watch Lists immediately after the modal closes.
- Supports common chart modal IDs/classes and dynamically created modal content.
- Preserves the dedicated v11.2 Chart Workspace.


V11.4 premium Watch Lists tooltip
---------------------------------
- Adds an animated information button beside the Watch Lists heading.
- Opens a glassmorphism help card on hover, focus or click.
- Includes strategy-group guidance, chart shortcuts and best practices.
- Includes pin/unpin and close controls.
- Includes a Don't show automatically again preference saved in localStorage.
- Automatically opens once for first-time users.
- Press F1 to reopen the help card.
- Press Escape to close it.
- Fully responsive on desktop and mobile.
- Rebinds itself if the Watch Lists section is dynamically re-rendered.


V11.5 per-watch-list tooltip
----------------------------
- Removed the general Watch Lists help tooltip.
- Added an individual premium tooltip to each watch-list item.
- Each tooltip shows the watch-list name.
- Each tooltip shows the number of trading codes.
- Shows up to 10 trading-code previews when available.
- Adds View Charts and Select List actions.
- Supports hover and keyboard focus on desktop.
- Supports tap interaction on mobile.
- Right-click pins the tooltip for interactive use.
- Smart positioning prevents viewport overflow.
- Automatically rebinds when watch lists are dynamically rendered.


V11.6 light-gray chart theme
----------------------------
- Changed chart backgrounds to light gray.
- Changed plot areas to a softer near-white gray.
- Replaced dark grid lines with subtle matching gray lines.
- Improved axis and label contrast.
- Added higher-contrast green bullish candles.
- Added higher-contrast red bearish candles.
- Strengthened candle borders and wicks for better visibility.
- Added support for Chart.js, Plotly, Highcharts, Lightweight Charts and ECharts where detected.
- Applies automatically to dynamically created charts and chart modals.


V11.7 Portfolio mother-code fix
-------------------------------
- Fixed the Portfolio Workspace Code field not showing mother trading codes.
- The selector now combines mother codes, all watch-list codes, active-list codes, and downloaded-history codes.
- Trading codes are normalized, deduplicated, and sorted.
- The selected portfolio code is preserved during background refreshes.
- The Code field shows a clear import prompt when no mother codes exist.
- The selector refreshes more quickly after mother-code imports and synchronization.
- Added window.AbabilPortfolioCodes.refresh() as a public refresh hook.


V11.8 Portfolio mother-code connection fix
------------------------------------------
- Exposes the main App instance as window.app and window.dashboard.
- Portfolio Workspace can now read the actual imported motherCodes collection.
- Adds a localStorage fallback during initialization.
- Resolves the active watch list from activeId when needed.
- Supports motherCodes stored as an array or object.
- Keeps active-list, all-watch-list and downloaded-history codes as fallbacks.
- Replaces the misleading 'Import mother trading codes first' message.


V11.9: Responsive upper-right Terminal Menu added; button groups consolidated while preserving original actions and styling.


V11.10 full-width Terminal Menu fix
-----------------------------------
- Terminal Menu now opens as a full-screen, full-width panel.
- Submenus render in responsive multi-column cards.
- All submenu groups are expanded by default.
- Added a prominent always-visible Close button.
- Improved mobile layout with one-column submenu items.
- Fixed submenu ordering and viewport overflow.
- Header remains visible while scrolling menu content.


V11.11 stable Terminal Menu and workspace-click fix
---------------------------------------------------
- Replaced transparent menu background with an opaque high-contrast surface.
- Menu launcher remains fixed at the upper-right corner while open or closed.
- Added a permanently visible close control while the menu is open.
- Corrected submenu collapse using both the hidden attribute and collapsed class.
- Removed the recursive body-wide MutationObserver.
- Restricted menu collection to the main control deck and original top toolbar.
- Trading Workspace tabs, chart controls, report controls and portfolio controls
  are no longer captured, hidden or rebuilt by the menu.
- Original command listeners and proxy behavior are preserved.


V11.12 DSE Trading Code terminology and shared search
-----------------------------------------------------
- Replaced user-facing Mother Trading Code List wording with DSE Trading Code List.
- Added Search Trading Code inside the Watch List Workspace.
- Search filters both the complete DSE Trading Code List and active watch list.
- Added live match counts and a Clear button.
- Existing top search and Watch List search remain synchronized.
- Responsive desktop and mobile search layout.


V11.13 shared search and menu cleanup
-------------------------------------
- Moved Search Trading Code above both DSE Trading Code List and Active Watch List.
- Search still filters both lists simultaneously.
- Removed duplicate Terminal Menu items using normalized visible labels.
- Excluded redundant mobile command copies from the generated menu.
- Replaced remaining user-facing Mother terminology with DSE terminology.


V11.14 premium theme-aware Trading Code search
-----------------------------------------------
- Search is placed directly under the Trading Code Workspace heading.
- Search appearance inherits the currently selected terminal theme.
- Added themed gradients, borders, glow, focus state and matching-row highlights.
- Added responsive desktop, tablet and mobile layouts.
- Added '/' keyboard shortcut to focus Search Trading Code.


V11.16 corrected workspace placement and Download Center
---------------------------------------------------------
- Rebuilt from v11.14 to preserve the prior working functionality.
- Search is now the first real row inside #marketWorkspace, so it belongs to
  the Trading-code Workspace collapsible body and collapses with it.
- Empty search explicitly displays all DSE and active-watch-list codes.
- Search input is reset safely on application initialization.
- Added null/array safeguards to DSE and active-list rendering.
- Consolidated import, sync, archive, 3M download, chart viewing, data preview,
  backup, and restore actions into one responsive Download Center.
- Original application buttons and event handlers remain the source of truth.


V11.17 Terminal Menu theme selection
------------------------------------
- Restored Theme Selection in the Terminal Menu.
- Theme Selection opens the existing #v10ThemeQuick control.
- Existing workspace search, code filtering, Download Center, charts, and
  terminal functionality remain unchanged.
- Theme option is grouped under Appearance where supported.


V11.18 reliable Theme Selection
-------------------------------
- Added Theme Selection to the actual original toolbar scanned by Terminal Menu.
- Terminal Menu now classifies it under Appearance.
- Generated Theme Selection opens the existing theme picker directly.
- Preserved the working search, code visibility, Download Center and all prior functionality.


V11.20 Terminal Menu restoration
--------------------------------
- Restored the intact grouped Terminal Menu implementation from v11.18.
- Preserved all original menu groups and their actions.
- Added a dedicated Appearance group.
- Theme Selection is explicitly assigned to Appearance, not Trading Workspace.
- Every Terminal Menu group starts collapsed by default.
- Removed the old visible header button-group/control-deck interface.
- Preserved the working Trading-code Workspace search, default code display,
  Download Center, charts, watch lists, and other v11.18 functionality.


V11.21 Theme Selection opening fix
----------------------------------
- Theme Selection now opens from the Appearance menu group.
- Uses native select.showPicker() where supported.
- Added a responsive custom theme-selection dialog as a reliable fallback.
- Theme choices are read directly from #v10ThemeQuick, so existing theme options
  and the original theme change handler remain the source of truth.
- Preserved restored Terminal Menu groups, collapsed defaults, hidden header
  button groups, workspace search, Download Center and other functionality.


V11.22 definitive Theme Selection fix
-------------------------------------
- Theme Selection now directly opens the custom theme dialog.
- Removed dependence on the hidden native theme selector UI.
- Removed the propagation-dependent fallback path.
- Existing theme options and original change handler remain in use.


V11.24 Terminal Menu close and Theme modal accessibility
--------------------------------------------------------
- Uses only the Terminal Menu's native closeMenu() routine.
- Does not hide or remove the Terminal Menu container or launcher.
- Waits for the menu close transition before opening Theme Selection.
- Closed menu panel/backdrop release pointer events.
- Theme dialog is mounted at the highest layer and remains fully clickable.
- Added keyboard focus, Escape-to-close, and focus return to Terminal Menu.


V11.25 complete theme surfaces and watch-list tooltips
------------------------------------------------------
- Extended active theme variables across legacy cards, panels, workspaces,
  forms, tables, lists, tabs, chips, drawers, dialogs, charts and menus.
- Removed remaining visually inconsistent fixed surfaces through a shared
  theme bridge.
- Every detected watch-list item now receives a hover/focus tooltip.
- Tooltip displays watch-list name and current number of trading codes.
- Dynamic watch-list updates are detected through MutationObserver.
- Tooltip remains keyboard accessible through focus.


V11.26 Watch Lists card tooltip correction
------------------------------------------
- Tooltips now target only the Watch Lists card whose subtitle is
  "Manage stock groups".
- Each available watch-list entry shows its watch-list name and current
  number of trading codes.
- Removed broad tooltip detection from individual trading-code rows/items.
- Tooltip supports mouse hover, native title fallback, and keyboard focus.
- Dynamically created/updated watch lists are refreshed automatically.


V11.27 AIT Elite v4.4 reliability validation
---------------------------------------------
- Added walk-forward-validated Advanced Rank ordering and frozen percentile
  signals: Strong Buy top 8%, Buy 8-20%, Watch 20-80%, Avoid bottom 20%.
- Added chronological development, validation and final-holdout monitoring.
- Corrected forward returns to exact common market dates and rejected missing
  or zero entry/target prices instead of carrying prices across dates.
- Added complete-history fingerprinting and safe incremental cache reuse.
- Added date-clustered Strong Buy uncertainty, explicit evaluable samples,
  automatic reliability classification and stricter new-entry gating.
- Reduced replay time with snapshot, history and market-series caching.
- See AIT_ELITE_V4_4_RELIABILITY.md in the package root for the verified result.
