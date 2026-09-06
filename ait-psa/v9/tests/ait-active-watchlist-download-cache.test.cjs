const assert = require("node:assert/strict");
const fs = require("node:fs");
const path = require("node:path");

const root = path.resolve(__dirname, "..");
const source = fs.readFileSync(path.join(root, "index.php"), "utf8");
const archiveSource = fs.readFileSync(path.join(root, "dse_archive.php"), "utf8");
const { AITWatchListDownloadCache } = require(path.join(root, "assets/js/ait-watchlist-download-cache.js"));

let checks = 0;
const check = (condition, message) => {
  assert.ok(condition, message);
  checks += 1;
};

const alpha = { id: "alpha", name: "Alpha List", codes: [" aaa ", "BBB", "AAA"] };
const beta = { id: "beta", name: "Beta List", codes: ["CCC"] };
const state = { watchLists: [alpha, beta], activeId: "alpha" };
const cache = new AITWatchListDownloadCache(state);

cache.touch(alpha, "2026-09-06T01:00:00.000Z");
cache.recordOhlc(alpha, {
  start: "2026-06-01",
  end: "2026-09-05",
  mode: "initial-3m",
  records: 4,
  requestedCodes: alpha.codes,
  matchedCodes: ["AAA", "BBB"]
});
cache.recordFundamentals(alpha, "dse", {
  requestedCodes: alpha.codes,
  matchedCodes: ["AAA"],
  missingCodes: ["BBB"],
  saved: 1,
  failed: 1
});

const history = {
  AAA: [
    { date: "2026-09-01", close: 10 },
    { date: "2026-09-05", close: 12 }
  ],
  BBB: [
    { date: "2026-09-02", close: 20 },
    { date: "2026-09-03", close: 21 }
  ],
  CCC: [{ date: "2026-09-04", close: 30 }],
  OUTSIDE: [{ date: "2026-09-05", close: 99 }]
};
const fundamentals = {
  AAA: { category: "A", eps: 2.5 },
  BBB: { peRatio: 8.5 },
  CCC: { businessSegment: "Bank" },
  OUTSIDE: { category: "A", eps: 9 }
};

const alphaSummary = cache.summary(alpha, history, fundamentals);
check(alphaSummary.codeCount === 2, "watch-list codes must be normalized and deduplicated");
check(alphaSummary.ohlc.codeCount === 2, "Alpha must count only its cached OHLC symbols");
check(alphaSummary.ohlc.recordCount === 4, "Alpha must count only its cached OHLC rows");
check(alphaSummary.ohlc.commonLatestDate === "2026-09-03", "Incremental sync must use the oldest latest date across active codes");
check(alphaSummary.ohlc.complete === true, "Alpha OHLC coverage must be complete");
check(alphaSummary.fundamentals.dseCount === 1, "DSE fundamental coverage must be source-aware");
check(alphaSummary.fundamentals.amarstockCount === 2, "AmarStock fundamental coverage must be source-aware");
check(alphaSummary.hasCachedData === true, "Alpha must report reusable cached data");

const betaSummary = cache.summary(beta, history, fundamentals);
check(betaSummary.ohlc.recordCount === 1, "switching lists must resolve only the selected list's OHLC rows");
check(betaSummary.fundamentals.codeCount === 1, "switching lists must resolve only the selected list's fundamentals");

const expandedAlpha = { ...alpha, codes: [...alpha.codes, "CCC", "MISSING"] };
const expandedCoverage = cache.ohlcCoverage(expandedAlpha, history);
check(expandedCoverage.complete === false, "a newly added uncached code must invalidate complete coverage");
check(expandedCoverage.commonLatestDate === "", "incremental sync must not skip an uncached active-list code");
assert.deepEqual(expandedCoverage.missingCodes, ["MISSING"]);
checks += 1;

const restoredCache = new AITWatchListDownloadCache(state);
check(restoredCache.manifest(alpha, false)?.ohlc?.lastMode === "initial-3m", "download manifests must survive watch-list switches and reloads");
state.watchLists = [alpha];
restoredCache.reconcile(state.watchLists);
check(!restoredCache.registry().beta, "deleted watch-list manifests must be pruned");

const workspaceStart = source.indexOf('id="aitPsaWorkspaceModal"');
const workspaceEnd = source.indexOf('id="aitPsaDataCenterLauncherModal"', workspaceStart);
const workspace = source.slice(workspaceStart, workspaceEnd);
const firstWorkspaceTarget = workspace.match(/<button[^>]+data-ait-psa-open="([^"]+)"/)?.[1];
check(firstWorkspaceTarget === "aitPsaWatchlistMenuModal", "Watch List must be the first Workspace menu item");
check(source.includes('<script defer src="assets/js/ait-watchlist-download-cache.js"></script>'), "the watch-list cache module must load before application initialization");
check(source.includes('const modalIds=["aitPsaDownloadMenuModal","aitPsaFundamentalsDownloadMenuModal","aitPsaOhlcDownloadMenuModal","aitPsaOhlcForceMenuModal"]'), "every Data Center Download level must display active-list cache context");
check(source.includes('p.set("codes",normalizedCodes.join(","))'), "archive requests must send only active-list codes");
check(source.includes('codes:active.codes.join(",")'), "Instant requests must send only active-list codes");
check(source.includes('true,false,false,false,"range",context'), "custom Range downloads must be active-list scoped");
check(source.includes('version:3,createdAt:'), "terminal backups must include the per-list cache manifest schema");
check(source.includes("commonLatestDate"), "incremental planning must use complete active-list coverage");

check(archiveSource.includes("final class ArchiveScope"), "the PHP endpoint must encapsulate requested-code scope in an OOP class");
check(archiveSource.includes("$responseData = $scope->filter($decoded);"), "cached full-market data must be filtered before the response");
check(archiveSource.includes("'scope' => $scope->isRestricted() ? 'watch-list' : 'all'"), "the endpoint must identify watch-list-scoped responses");
check(archiveSource.includes("writeCsv($responseCsvPath, $responseData);"), "CSV exports must contain only scoped response data");

process.stdout.write(JSON.stringify({
  status: "passed",
  checks,
  coverage: [
    "Watch List first in Workspace",
    "normalized per-watch-list download manifests",
    "cache restoration after list switching",
    "active-list OHLC and fundamentals coverage",
    "complete-code incremental planning",
    "active-list archive, Instant, Range and CSV requests",
    "server-side OOP response filtering"
  ]
}, null, 2) + "\n");
