const test = require('node:test');
const assert = require('node:assert/strict');
const fs = require('node:fs');
const path = require('node:path');
const vm = require('node:vm');

function monitor() {
  const nodes = Object.fromEntries(['aitEliteCompareRows', 'aitEliteCompareDetailRows',
    'aitEliteCompareDetailTitle', 'aitEliteCompareWinner', 'aitEliteCompareStatus'].map(id =>
    [id, {innerHTML: '', textContent: '', querySelectorAll: () => []}]));
  const window = {};
  const document = {readyState: 'loading', addEventListener: () => {}, getElementById: id => nodes[id]};
  const source = fs.readFileSync(path.join(__dirname, '../assets/js/ait-elite-performance-compare.js'), 'utf8');
  vm.runInNewContext(source, {window, document, setTimeout, console});
  return {...window.AitEliteHorizonPerformance, nodes};
}
const stats = (excess, extra = {}) => ({excess, raw: excess + 1, benchmark: 1,
  dates: 20, n: 30, excessWin: 60, rawWin: 65, ...extra});

test('ranking adjusts for horizon and lists insufficient evidence after eligible scanners', () => {
  const {rank} = monitor();
  const result = rank({rows: {
    'elite-2': stats(2), 'elite-9': stats(4.5),
    'regime-3': stats(30, {dates: 19}), 'regime-6': stats(60, {n: 29})
  }});
  assert.equal(result.rows[0].id, 'elite-2');
  assert.equal(result.rows[0].rank, 1);
  assert.equal(result.rows[1].id, 'elite-9');
  assert.equal(result.rows[1].rank, 2);
  assert.ok(result.rows.slice(2).every(row => row.rank === null));
  assert.match(result.summary, /Best observed historical performer: AIT Elite 2D/);
});

test('equal metrics share competition ranks; win rate and raw return break ties', () => {
  const {rank} = monitor();
  const result = rank({rows: {
    'elite-2': stats(2, {raw: 4}), 'regime-2': stats(2, {raw: 4}),
    'elite-3': stats(3, {raw: 6, excessWin: 59}),
    'elite-6': stats(6, {raw: 6})
  }});
  assert.deepEqual(Array.from(result.rows.slice(0, 4), row => row.rank), [1, 1, 3, 4]);
  assert.equal(result.rows[2].id, 'elite-6');
  assert.equal(result.rows[3].id, 'elite-3');
  assert.match(result.summary, /Joint historical leaders/);
});

test('no data, limited samples, and a single eligible scanner cannot declare a winner', () => {
  const {rank} = monitor();
  assert.match(rank({rows: {}}).summary, /No winner yet/);
  assert.match(rank({rows: {'elite-2': stats(9, {dates: 1})}}).summary, /No winner yet/);
  assert.match(rank({rows: {'elite-2': stats(9)}}).summary, /at least two eligible scanners/);
  assert.equal(rank({rows: {'elite-2': stats(NaN)}}).rows.find(row => row.id === 'elite-2').rank, null);
});

test('negative leaders are explicitly identified as failing to beat the benchmark or losing value', () => {
  const {rank} = monitor();
  assert.match(rank({rows: {'elite-2': stats(-1), 'elite-3': stats(-3)}}).summary, /did not beat the benchmark/);
  assert.match(rank({rows: {'elite-2': stats(1, {raw: -1}), 'elite-3': stats(1)}}).summary, /still lost value/);
});

test('render shows ranked rows, evidence labels and the leading result', () => {
  const {render, nodes} = monitor();
  render({rows: {'elite-2': stats(2), 'elite-9': stats(4.5), 'regime-3': stats(10, {dates: 2})},
    details: {}, period: {dates: 25, from: '2026-01-01', to: '2026-02-04'}});
  const html = nodes.aitEliteCompareRows.innerHTML;
  assert.ok(html.indexOf('data-monitor="elite-2"') < html.indexOf('data-monitor="elite-9"'));
  assert.match(html, /#1/);
  assert.match(html, /Limited evidence/);
  assert.match(html, /No data/);
  assert.match(html, /\+1\.0000%/);
  assert.match(nodes.aitEliteCompareWinner.textContent, /AIT Elite 2D/);
  assert.equal((html.match(/data-monitor=/g) || []).length, 8);
});
