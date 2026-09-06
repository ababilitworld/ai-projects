const assert = require('node:assert/strict');
const fs = require('node:fs');
const path = require('node:path');

global.document = {
  readyState: 'complete',
  querySelectorAll: () => [],
  dispatchEvent: () => true,
};
global.window = {};
global.CustomEvent = class CustomEvent {
  constructor(type, init = {}) {
    this.type = type;
    this.detail = init.detail;
  }
};
global.HTMLTableElement = class HTMLTableElement {};

const assetPath = path.resolve(__dirname, '../assets/js/ait-sortable-filterable-table.js');
const assetSource = fs.readFileSync(assetPath, 'utf8');
const assetUrl = `data:text/javascript;base64,${Buffer.from(assetSource).toString('base64')}`;
const indexSource = fs.readFileSync(path.resolve(__dirname, '../index.php'), 'utf8');
const cssSource = fs.readFileSync(path.resolve(__dirname, '../assets/css/ait-sortable-filterable-table.css'), 'utf8');

const cell = (value) => ({ dataset: {}, textContent: String(value) });
const row = (...values) => ({
  cells: values.map(cell),
  textContent: values.join(' '),
});

(async () => {
  const {
    AitSortableFilterableTable,
    AitTableValueParser,
  } = await import(assetUrl);

  const parser = new AitTableValueParser('en');

  assert.match(indexSource, /assets\/css\/ait-sortable-filterable-table\.css/);
  assert.match(indexSource, /<script type="module" src="assets\/js\/ait-sortable-filterable-table\.js"><\/script>/);
  assert.equal((indexSource.match(/class="v11-scanner-table-region/g) || []).length >= 1, true);
  assert.match(indexSource, /class="ait-fund-report-table"/);
  assert.match(cssSource, /\.ait-data-table-toolbar/);
  assert.match(cssSource, /\.ait-data-table-filter-row/);

  assert.equal(parser.compare('ALPHA', 'BETA', 'asc') < 0, true);
  assert.equal(parser.compare('ALPHA', 'BETA', 'desc') > 0, true);
  assert.equal(parser.compare('5.5%', '10%', 'asc') < 0, true);
  assert.equal(parser.compare('-1.2%', '0%', 'asc') < 0, true);
  assert.equal(parser.compare('—', '10', 'desc') > 0, true, 'Empty values remain last');
  assert.equal(parser.compare('2026-01-01', '2026-02-01', 'asc') < 0, true);

  assert.equal(parser.matches('Strong Buy', 'strong'), true);
  assert.equal(parser.matches('Strong Buy', '!avoid'), true);
  assert.equal(parser.matches('Strong Buy', 'Buy|Watch'), true);
  assert.equal(parser.matches('18.5%', '>=18'), true);
  assert.equal(parser.matches('18.5%', '<18'), false);
  assert.equal(parser.matches('18.5%', '10..20'), true);
  assert.equal(parser.matches('2026-02-15', '2026-01-01..2026-03-01'), true);
  assert.equal(parser.matches('Buy', '=buy'), true);
  assert.equal(parser.matches('Buy', '!=watch'), true);

  const component = new AitSortableFilterableTable({});
  component.updateState = () => {};
  component.apply = () => {};

  component.toggleSort(1);
  component.toggleSort(0);
  component.toggleSort(0);
  assert.deepEqual(component.sortCriteria, [
    { columnIndex: 1, direction: 'asc' },
    { columnIndex: 0, direction: 'desc' },
  ], 'Repeated header click toggles direction without changing priority');

  const rows = [
    row('BETA', 10),
    row('ALPHA', 10),
    row('GAMMA', 5),
    row('DELTA', '—'),
  ];
  component.captureOriginalOrder(rows);
  assert.deepEqual(
    component.sortedRows(rows).map((item) => item.cells[0].textContent),
    ['GAMMA', 'BETA', 'ALPHA', 'DELTA'],
    'First selected column is primary and second selected column breaks ties',
  );

  const filters = [
    { columnIndex: 0, expression: 'AL|GA' },
    { columnIndex: 1, expression: '>=6' },
  ];
  assert.equal(component.rowMatches(rows[0], filters, ''), false);
  assert.equal(component.rowMatches(rows[1], filters, ''), true);
  assert.equal(component.rowMatches(rows[2], filters, ''), false);
  assert.equal(component.rowMatches(rows[1], filters, 'alpha'), true);
  assert.equal(component.rowMatches(rows[1], filters, 'gamma'), false);

  component.sortCriteria = [];
  assert.deepEqual(
    component.sortedRows([...rows].reverse()).map((item) => item.cells[0].textContent),
    ['BETA', 'ALPHA', 'GAMMA', 'DELTA'],
    'Clear-sort behavior restores the original calculated scanner order',
  );

  console.log(JSON.stringify({
    status: 'passed',
    checks: 28,
    coverage: [
      'text, numeric, percentage and date comparisons',
      'ASC/DESC direction',
      'empty values last',
      'contains, exclusion, alternatives, operators and ranges',
      'selection-ordered multi-column sorting',
      'sort-direction toggle with stable priority',
      'combined global and per-column filtering',
      'original-order restoration',
    ],
  }, null, 2));
})().catch((error) => {
  console.error(error);
  process.exitCode = 1;
});
