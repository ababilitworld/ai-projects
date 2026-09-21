const test = require('node:test');
const assert = require('node:assert/strict');
const fs = require('node:fs');
const path = require('node:path');
const vm = require('node:vm');

test('2D, 3D, 6D and 9D monitors replay dated signals and measure matching forward sessions', async () => {
  const dates = Array.from({length: 35}, (_, index) => new Date(Date.UTC(2026, 0, index + 1)).toISOString().slice(0, 10));
  const history = {
    A: dates.map((date, index) => ({date, close: 100 * 1.01 ** index})),
    B: dates.map(date => ({date, close: 100}))
  };
  const seen = [];
  const storage = new Map();
  const localStorage = {
    getItem: key => storage.get(key) ?? null,
    setItem: (key, value) => storage.set(key, value),
    removeItem: key => storage.delete(key)
  };
  const window = {
    AITScannerDataBridge: {
      scannerCodes: () => ['A', 'B'],
      appState: () => ({history}),
      scannerHistorySignature: () => 'synthetic-history',
      scannerUniverseSignature: () => 'A|B',
      clearPrioritySnapshotCache: () => {}
    },
    AitEliteSignalPriority: {
      calculate: days => {
        const date = window.__AIT_HISTORICAL_CUTOFF_DATE__;
        seen.push({days, date});
        assert.ok(date && date <= dates[25], 'signal calculation must have a historical cutoff');
        return {rows: [
          {code: 'A', finalSignal: 'Strong Buy', eliteScore: 80},
          {code: 'B', finalSignal: 'Avoid', eliteScore: 20}
        ]};
      },
      clearCache: () => {}
    },
    AITEliteRegime: {
      adjust: () => ({regimeScore: 80, fit: 'Selective'}),
      decide: ({signal}) => ({action: signal === 'Avoid' ? 'AVOID' : 'CONFIRMATION'})
    }
  };
  const document = {readyState: 'loading', addEventListener: () => {}, getElementById: () => null};
  const source = fs.readFileSync(path.join(__dirname, '../assets/js/ait-elite-performance-compare.js'), 'utf8');
  vm.runInNewContext(source, {window, document, localStorage, setTimeout, console});

  const result = await window.AitEliteHorizonPerformance.run();
  assert.equal(result.period.dates, 6);
  assert.equal(seen.length, 24);
  assert.equal(window.__AIT_HISTORICAL_CUTOFF_DATE__, undefined);
  for (const days of [2, 3, 6, 9]) {
    const expected = (1.01 ** days - 1) * 100;
    for (const type of ['elite', 'regime']) {
      const stats = result.rows[`${type}-${days}`];
      assert.equal(stats.n, 6);
      assert.equal(stats.dates, 6);
      assert.ok(Math.abs(stats.raw - expected) < 1e-9);
      assert.ok(Math.abs(stats.benchmark - expected / 2) < 1e-9);
      assert.ok(Math.abs(stats.excess - expected / 2) < 1e-9);
    }
  }
});
