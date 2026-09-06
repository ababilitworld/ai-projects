const assert = require("node:assert/strict");
const fs = require("node:fs");
const path = require("node:path");

const root = path.resolve(__dirname, "..");
const source = fs.readFileSync(path.join(root, "index.php"), "utf8");

let checks = 0;
const check = (condition, message) => {
  assert.ok(condition, message);
  checks += 1;
};

const section = (id, nextId) => {
  const start = source.indexOf(`id="${id}"`);
  const end = source.indexOf(`id="${nextId}"`, start + 1);
  assert.ok(start >= 0 && end > start, `Unable to locate ${id}`);
  return source.slice(start, end);
};

const dataReportMenu = section("aitPsaDataReportMenuModal", "aitPsaDataReportDownloadedModal");
const tradingMenu = section("aitPsaTradingLauncherModal", "aitPsaPortfolioMenuModal");

check(
  dataReportMenu.includes('data-ait-psa-open="aitPsaDataReportDownloadedModal"'),
  "Data Center Report must retain the Downloaded submenu"
);
check(
  dataReportMenu.includes('data-ait-psa-open="aitPsaDataReportChartsModal"'),
  "Data Center Report must retain the saved-chart galleries"
);

for (const tab of ["charts", "reports", "explorer"]) {
  check(
    dataReportMenu.includes(`data-ait-trading-tab="${tab}" data-ait-trading-group="data-report"`),
    `${tab} must be routed through Data Center Report`
  );
}

check(
  tradingMenu.includes('data-ait-psa-open="aitPsaPortfolioMenuModal"'),
  "Trading must retain Portfolio"
);
check(
  !tradingMenu.includes("aitPsaReportMenuModal"),
  "Trading must not expose its former Report category"
);
check(
  !source.includes('id="aitPsaReportMenuModal"'),
  "the obsolete Trading Report modal must be removed"
);
check(
  source.includes("'data-report': 'aitPsaDataReportMenuModal'"),
  "moved tools must return to the Data Center Report modal"
);
check(
  source.includes("'data-report': 'Data Center Report'"),
  "moved tools must display the Data Center Report navigation label"
);
check(
  source.includes("if (back) back.textContent = `← ${groupLabel}`"),
  "the Trading workspace Back control must use the mapped group label"
);

process.stdout.write(JSON.stringify({
  status: "passed",
  checks,
  coverage: [
    "Workspace → Data Center → Report hierarchy",
    "Charts, Report and Explorer relocation",
    "Trading Report duplicate removal",
    "Data Center Report Back navigation"
  ]
}, null, 2) + "\n");
