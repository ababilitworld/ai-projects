const test = require('node:test');
const assert = require('node:assert/strict');
const fs = require('node:fs');
const path = require('node:path');
const vm = require('node:vm');

const source = fs.readFileSync(path.join(__dirname, '../index.php'), 'utf8');
const inlineScript = id => source.split(`<script id="${id}">`)[1].split('</script>')[0];

function scanner(closes = [100, 102], volumes = [100000, 200000]) {
  const history = {A: closes.map((close, index) => ({
    date: `2026-01-${String(index + 1).padStart(2, '0')}`,
    close, high: close + 1, low: close - 1, volume: volumes[index] ?? 100000
  }))};
  const seen = [];
  const window = {AITScannerDataBridge: {
    scannerCodes: () => ['A'], appState: () => ({history}),
    rowsFor: code => history[code].filter(row => !window.__AIT_HISTORICAL_CUTOFF_DATE__ || row.date <= window.__AIT_HISTORICAL_CUTOFF_DATE__),
    scannerHistorySignature: () => JSON.stringify(history),
    priorityDataset: () => {
      seen.push(window.__AIT_HISTORICAL_CUTOFF_DATE__);
      return [{code: 'A', primaryScore: 80, indicatorScore: 80, vpaScore: 80, signal: 'Strong Buy'}];
    }
  }};
  const context = vm.createContext({window, document: {getElementById: () => null}, localStorage: {getItem: () => null}});
  vm.runInContext(inlineScript('ait-advanced-priority-script'), context);
  vm.runInContext(inlineScript('ait-elite-priority-script'), context);
  return {window, history, seen};
}

test('2D requires two trading dates and evaluates actual price/volume confirmation', () => {
  const insufficient = scanner([100]);
  assert.equal(insufficient.window.AitEliteSignalPriority.calculate(2).rows.length, 0);
  const {window, seen} = scanner();
  const advanced = window.AitAdvancedSignalPriority.calculate(2);
  assert.equal(advanced.required, 2);
  assert.deepEqual(seen, ['2026-01-01', '2026-01-02']);
  assert.ok(advanced.rows[0].confirmationScore > 80);
  const falling = scanner([102, 100], [200000, 100000]);
  assert.ok(falling.window.AitAdvancedSignalPriority.calculate(2).rows[0].confirmationScore < 50);
  const elite = window.AitEliteSignalPriority.calculate(2);
  assert.equal(elite.rows.length, 1);
  assert.ok(Number.isFinite(elite.rows[0].eliteScore));
  assert.equal(elite.rows[0].modelState, 'Unverified');
  assert.notEqual(elite.rows[0].tradeAction, 'Buy Now');
  assert.equal(window.AitEliteSignalPriority.calculate(3).rows.length, 0);
  assert.equal(window.AitEliteSignalPriority.calculate().rows.length, 0);
});

test('2D historical replay respects its cutoff and excludes future evidence', () => {
  const {window, history, seen} = scanner([100, 102, 1000]);
  window.__AIT_HISTORICAL_CUTOFF_DATE__ = '2026-01-02';
  const first = window.AitEliteSignalPriority.calculate(2).rows[0];
  assert.equal(window.__AIT_HISTORICAL_CUTOFF_DATE__, '2026-01-02');
  assert.ok(seen.every(date => date <= '2026-01-02'));
  history.A[2].close = 1;
  window.AitAdvancedSignalPriority.clearCache();
  window.AitEliteSignalPriority.clearCache();
  const second = window.AitEliteSignalPriority.calculate(2).rows[0];
  assert.equal(first.eliteScore, second.eliteScore);
  assert.equal(first.confirmationScore, second.confirmationScore);
});

test('adding 2D leaves existing horizon confirmation formulas unchanged', () => {
  for (const days of [3, 6, 9]) {
    const {window} = scanner(Array.from({length: days}, (_, i) => 100 + i), Array(days).fill(100000));
    const row = window.AitAdvancedSignalPriority.calculate(days).rows[0];
    const expected = 74 + 300 / (100 + days - 2);
    assert.ok(Math.abs(row.confirmationScore - expected) < 1e-9);
  }
});

test('2D Elite and Regime chart routes keep the matching scores, actions and signal ranks', () => {
  const window = {};
  for (const days of [2, 3, 6]) {
    const row = {code: `TEST${days}`, ltp: 100, eliteScore: 70 + days, regimeScore: 80 + days,
      finalSignal: 'Buy', tradeAction: 'Buy on Confirmation', decision: {action: 'CONFIRMATION'}};
    window[`AitElite${days}d`] = {calculate: () => ({rows: [row]})};
    window[`AitEliteRegime${days}d`] = {calculate: () => [row]};
  }
  const chartCode = source.slice(source.indexOf(' function rankedChartData(mode){'), source.indexOf(' function openRankedCharts('));
  const context = vm.createContext({window});
  vm.runInContext(chartCode, context);
  for (const days of [2, 3, 6]) {
    for (const regime of [false, true]) {
      const row = context.rankedChartData(`elite-${regime ? 'regime' : 'priority'}-${days}d`)[0];
      assert.equal(row.code, `TEST${days}`);
      assert.equal(row.score, (regime ? 80 : 70) + days);
      assert.equal(row.scoreLabel, `${days}D ${regime ? 'Regime' : 'Elite'} Score`);
      assert.equal(row.signalRank, 1);
      assert.equal(row.action, regime ? 'CONFIRMATION' : 'Buy on Confirmation');
    }
  }
});
