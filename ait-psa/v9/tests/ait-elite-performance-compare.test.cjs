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

test('Performance Monitor has one comparison entry and every click recalculates all horizons', async () => {
  const dates = Array.from({length: 35}, (_, i) => new Date(Date.UTC(2026, 0, i + 1)).toISOString().slice(0, 10));
  const calls = [];
  const menu = {children: ['old-elite', 'old-regime'], replaceChildren(...children) { this.children = children; }};
  let completed;
  const window = {
    AITScannerDataBridge: {
      scannerCodes: () => ['A'],
      appState: () => ({history: {A: dates.map((date, i) => ({date, close: 100 + i}))}}),
      scannerHistorySignature: () => 'same-history', scannerUniverseSignature: () => 'A'
    },
    AitEliteSignalPriority: {calculate: days => {
      calls.push(days);
      return {rows: [{code: 'A', finalSignal: 'Buy', eliteScore: 80}]};
    }},
    AITEliteRegime: {adjust: () => ({regimeScore: 80}), decide: () => ({action: 'CONFIRMATION'})},
    AITEliteBusy: {execute: (_, task) => (completed = task())}
  };
  const elements = {
    aitPsaSignalPriorityPerformanceModal: {querySelector: () => menu},
    aitPsaTerminalModalShell: {insertAdjacentHTML: () => {}}
  };
  const document = {
    readyState: 'complete', getElementById: id => elements[id] || null,
    createElement: () => ({dataset: {}, listeners: {}, addEventListener(event, handler) { this.listeners[event] = handler; }})
  };
  const storage = new Map();
  const localStorage = {
    getItem: key => storage.get(key) ?? null,
    setItem: (key, value) => storage.set(key, value),
    removeItem: key => storage.delete(key)
  };
  const source = fs.readFileSync(path.join(__dirname, '../assets/js/ait-elite-performance-compare.js'), 'utf8');
  vm.runInNewContext(source, {window, document, localStorage, setTimeout: callback => callback(), console});
  assert.equal(menu.children.length, 1);
  const button = menu.children[0];
  assert.equal(button.dataset.aitPsaOpen, 'aitEliteCompareModal');
  for (let click = 1; click <= 2; click++) {
    button.listeners.click();
    const result = await completed;
    await Promise.resolve();
    assert.equal(calls.length, click * 24, 'opening again must replay even when history has not changed');
    assert.deepEqual([...new Set(calls)].sort((a, b) => a - b), [2, 3, 6, 9]);
    assert.equal(Object.keys(result.rows).length, 8);
    assert.ok(Object.values(result.rows).every(row => row.n === 6));
  }
});
