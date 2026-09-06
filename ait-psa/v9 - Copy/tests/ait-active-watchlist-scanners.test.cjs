const assert = require("node:assert/strict");
const fs = require("node:fs");
const path = require("node:path");
const vm = require("node:vm");

const root = path.resolve(__dirname, "..");
const { AITScannerUniverse } = require(path.join(root, "assets/js/ait-scanner-universe.js"));
const source = fs.readFileSync(path.join(root, "index.php"), "utf8");

let checks = 0;
const check = (condition, message) => {
  assert.ok(condition, message);
  checks += 1;
};

const context = {
  state: {
    activeId: "active-list",
    motherCodes: ["MOTHER", "gp"],
    watchLists: [
      { id: "other-list", name: "Other", codes: ["SQURPHARMA", "EXTRA"] },
      { id: "active-list", name: "Selected", codes: [" bracbank ", "GP", "gp", ""] }
    ],
    history: {
      BRACBANK: [{ date: "2026-01-01", close: 10 }],
      GP: [{ date: "2026-01-01", close: 20 }],
      SQURPHARMA: [{ date: "2026-01-01", close: 30 }],
      HISTORYONLY: [{ date: "2026-01-01", close: 40 }]
    }
  }
};

assert.deepEqual(
  AITScannerUniverse.activeCodes(context),
  ["BRACBANK", "GP"],
  "activeCodes must normalize and deduplicate only the selected watch list"
);
checks += 1;

assert.deepEqual(
  Object.keys(AITScannerUniverse.activeHistory(context)),
  ["BRACBANK", "GP"],
  "activeHistory must exclude history belonging to other lists"
);
checks += 1;

assert.deepEqual(
  AITScannerUniverse.allCodes(context),
  ["BRACBANK", "EXTRA", "GP", "HISTORYONLY", "MOTHER", "SQURPHARMA"],
  "allCodes must remain available to non-scanner tools"
);
checks += 1;

check(
  AITScannerUniverse.signature(context) === "active-list|BRACBANK|GP",
  "the scanner signature must include the active-list identity and codes"
);

const otherContext = {
  ...context,
  state: { ...context.state, activeId: "other-list" }
};
assert.deepEqual(
  AITScannerUniverse.activeCodes(otherContext),
  ["SQURPHARMA", "EXTRA"],
  "changing activeId must change the scanner universe"
);
checks += 1;
check(
  AITScannerUniverse.signature(otherContext) !== AITScannerUniverse.signature(context),
  "changing the active watch list must invalidate scanner caches"
);

const emptyContext = {
  state: {
    activeId: "empty",
    motherCodes: ["MOTHER"],
    watchLists: [{ id: "empty", codes: [] }],
    history: { HISTORYONLY: [{ date: "2026-01-01", close: 1 }] }
  }
};
assert.deepEqual(
  AITScannerUniverse.activeCodes(emptyContext),
  [],
  "an empty active list must produce an empty scanner universe without history fallback"
);
checks += 1;

check(
  source.includes('<script defer src="assets/js/ait-scanner-universe.js"></script>'),
  "the scanner-universe resolver must load before DOMContentLoaded calculations"
);
check(source.includes("const data=scannerCodes()\n   .map(indicatorData)"), "Technical Scanner must use scannerCodes");
check(source.includes("const data=scannerCodes().map(comparisonData)"), "Relative Strength Scanner must use scannerCodes");
check(source.includes("const data=scannerCodes().map(vpaData)"), "Smart Money Scanner must use scannerCodes");
check(source.includes("rankPotentialData(scannerCodes().map"), "AIT Elite Scanner must use scannerCodes");
check(source.includes("return scannerCodes().map(code=>{"), "AIT Composite Scanner must use scannerCodes");
check(source.includes("codes:scannerCodes"), "the shared scanner bridge must expose active-list codes");
check(source.includes("scannerHistorySignature"), "scanner caches must use an active-history signature");
check(source.includes('"ait:active-watchlist-changed"'), "active-list mutations must publish a cache invalidation event");
check(!source.includes("const codes=()=>Object.keys(history()).map(String).filter(Boolean)"), "Regime calculations must not enumerate the full history store");
check(source.includes("const codes=()=>bridge()?.scannerCodes?.()"), "Regime breadth must use active-list scanner codes");
check(source.includes("scannerCodes().flatMap(code=>Array.isArray(h[code])"), "historical date calendars must be built from active-list history");
check(source.includes("scannerCodes().forEach(code=>{"), "performance market-series caches must contain active-list codes only");

const section = (id, nextId) => {
  const start = source.indexOf(`id="${id}"`);
  const end = nextId ? source.indexOf(`id="${nextId}"`, start + 1) : source.indexOf("</section>", start) + 10;
  assert.ok(start >= 0 && end > start, `Unable to locate ${id}`);
  return source.slice(start, end);
};

const workspace = section("aitPsaWorkspaceModal", "aitPsaDataCenterLauncherModal");
const watchMenu = section("aitPsaWatchlistMenuModal", "aitPsaWatchlistManagerModal");
const watchManager = section("aitPsaWatchlistManagerModal", "aitPsaSignalPriorityMenuModal");
const tradingMenu = section("aitPsaTradingLauncherModal", "aitPsaPortfolioMenuModal");
const scannerMenu = section("aitPsaScannerMenuModal", "aitPsaTradingModal");

check(workspace.includes('data-ait-psa-open="aitPsaWatchlistMenuModal"'), "Workspace must route Watch List to its parent menu");
check(watchMenu.includes('data-ait-psa-open="aitPsaWatchlistManagerModal"'), "Watch List must expose its manager submenu");
check(watchMenu.includes('data-ait-psa-open="aitPsaScannerMenuModal"'), "Scanner must be a Watch List submenu");
check(watchManager.includes('data-ait-psa-open="aitPsaWatchlistMenuModal"'), "Watch List Manager must return to Watch List");
check(scannerMenu.includes('data-ait-psa-open="aitPsaWatchlistMenuModal"'), "Scanner must return to Watch List");
check(!tradingMenu.includes('data-ait-psa-open="aitPsaScannerMenuModal"'), "Trading must not expose Scanner as a sibling menu");

const inlineScripts = [...source.matchAll(/<script(?![^>]*\bsrc=)[^>]*>([\s\S]*?)<\/script>/gi)];
inlineScripts.forEach((match, index) => {
  new vm.Script(match[1], { filename: `index.php:inline-script-${index + 1}.js` });
});
checks += inlineScripts.length;

process.stdout.write(JSON.stringify({
  status: "passed",
  checks,
  inlineScriptsParsed: inlineScripts.length,
  coverage: [
    "active-list-only symbol resolution",
    "empty-list isolation without history fallback",
    "active-history and cache-signature isolation",
    "Technical, VPA, Relative, Composite, Elite, Historical, Advanced and Regime routing",
    "active-list-only performance calendars and market series",
    "Workspace → Watch List → Scanner menu hierarchy",
    "all inline JavaScript syntax"
  ]
}, null, 2) + "\n");
