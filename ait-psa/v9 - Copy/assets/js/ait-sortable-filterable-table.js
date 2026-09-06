const AIT_DATA_TABLE_SELECTOR = '.v11-scanner-table-region table, .ait-fund-report-table';

class AitTableValueParser {
  constructor(locale = undefined) {
    this.collator = new Intl.Collator(locale, {
      numeric: true,
      sensitivity: 'base',
      usage: 'sort',
    });
  }

  normalize(value) {
    return String(value ?? '').replace(/\u00a0/g, ' ').replace(/\s+/g, ' ').trim();
  }

  valueFromCell(cell) {
    if (!cell) return '';
    return cell.dataset.aitSortValue ?? cell.dataset.sortValue ?? cell.textContent ?? '';
  }

  filterValueFromCell(cell) {
    if (!cell) return '';
    return cell.dataset.aitFilterValue ?? cell.dataset.filterValue ?? cell.textContent ?? '';
  }

  parse(value) {
    const text = this.normalize(value);
    const lowered = text.toLocaleLowerCase();

    if (!text || /^(?:—|-|n\/?a|null|undefined|not available)$/i.test(text)) {
      return { kind: 'empty', value: null, text };
    }

    const dateValue = this.parseDate(text);
    if (dateValue !== null) return { kind: 'date', value: dateValue, text };

    const numericValue = this.parseNumber(text);
    if (numericValue !== null) return { kind: 'number', value: numericValue, text };

    return { kind: 'text', value: lowered, text };
  }

  parseDate(value) {
    const looksLikeDate = /^(?:\d{4}[-/]\d{1,2}[-/]\d{1,2}|\d{1,2}[-/]\d{1,2}[-/]\d{2,4}|[A-Za-z]{3,9}\s+\d{1,2},?\s+\d{4})/.test(value);
    if (!looksLikeDate) return null;

    const timestamp = Date.parse(value);
    return Number.isNaN(timestamp) ? null : timestamp;
  }

  parseNumber(value) {
    const normalized = value
      .replace(/\u2212/g, '-')
      .replace(/^\s*[৳$€£]\s*/, '')
      .replace(/,/g, '')
      .trim();
    const parenthetical = normalized.match(/^\(([+-]?(?:\d+(?:\.\d+)?|\.\d+))\)\s*(?:%|x|×)?$/i);
    if (parenthetical) return -Number(parenthetical[1]);

    const match = normalized.match(/^([+-]?(?:\d+(?:\.\d+)?|\.\d+))(.*)$/);
    if (!match) return null;

    const remainder = match[2].trim();
    const numericSuffix = !remainder || /^(?:%|x|×|৳|tk\.?|bdt|times)?(?:\s|$|[•(/])/i.test(remainder);
    if (!numericSuffix) return null;

    const number = Number(match[1]);
    return Number.isFinite(number) ? number : null;
  }

  compare(leftValue, rightValue, direction = 'asc') {
    const left = this.parse(leftValue);
    const right = this.parse(rightValue);

    if (left.kind === 'empty' || right.kind === 'empty') {
      if (left.kind === right.kind) return 0;
      return left.kind === 'empty' ? 1 : -1;
    }

    let result = 0;
    if (left.kind === right.kind && (left.kind === 'number' || left.kind === 'date')) {
      result = left.value - right.value;
    } else {
      result = this.collator.compare(left.text, right.text);
    }

    if (result === 0) return 0;
    return direction === 'desc' ? -result : result;
  }

  matches(value, expression) {
    const filter = this.normalize(expression);
    if (!filter) return true;

    return filter
      .split('|')
      .map((part) => part.trim())
      .filter(Boolean)
      .some((part) => this.matchesSingle(value, part));
  }

  matchesSingle(value, expression) {
    const source = this.normalize(value);
    const range = expression.match(/^(.+?)\s*\.\.\s*(.+)$/);

    if (range) {
      const current = this.parse(source);
      const minimum = this.parse(range[1]);
      const maximum = this.parse(range[2]);
      const comparable = current.kind !== 'empty'
        && current.kind === minimum.kind
        && current.kind === maximum.kind
        && (current.kind === 'number' || current.kind === 'date');
      return comparable && current.value >= minimum.value && current.value <= maximum.value;
    }

    const operator = expression.match(/^(<=|>=|!=|=|<|>)\s*(.+)$/);
    if (operator) return this.matchesOperator(source, operator[1], operator[2]);

    if (expression.startsWith('!')) {
      const excluded = this.normalize(expression.slice(1)).toLocaleLowerCase();
      return excluded ? !source.toLocaleLowerCase().includes(excluded) : true;
    }

    return source.toLocaleLowerCase().includes(expression.toLocaleLowerCase());
  }

  matchesOperator(source, operator, expectedValue) {
    const current = this.parse(source);
    const expected = this.parse(expectedValue);
    let comparison = 0;

    if (current.kind === expected.kind && (current.kind === 'number' || current.kind === 'date')) {
      comparison = current.value - expected.value;
    } else {
      comparison = this.collator.compare(current.text, expected.text);
    }

    switch (operator) {
      case '>': return comparison > 0;
      case '>=': return comparison >= 0;
      case '<': return comparison < 0;
      case '<=': return comparison <= 0;
      case '!=': return comparison !== 0;
      case '=': return comparison === 0;
      default: return true;
    }
  }
}

class AitSortableFilterableTable {
  constructor(table, options = {}) {
    this.table = table;
    this.options = {
      filterPlaceholder: 'Filter…',
      ...options,
    };
    this.parser = new AitTableValueParser(options.locale);
    this.sortCriteria = [];
    this.filterInputs = [];
    this.originalOrder = new WeakMap();
    this.originalOrderCounter = 0;
    this.applyScheduled = false;
    this.initialized = false;
  }

  init() {
    if (this.initialized || this.table.dataset.aitDataTableReady === '1') return this;

    this.thead = this.table.tHead;
    this.tbody = this.table.tBodies[0];
    this.headerRow = this.thead?.rows[0] ?? null;
    if (!this.thead || !this.tbody || !this.headerRow || !this.headerRow.cells.length) return this;

    this.headers = Array.from(this.headerRow.cells);
    this.labels = this.headers.map((header, index) => this.readHeaderLabel(header, index));
    this.table.dataset.aitDataTableReady = '1';
    this.table.classList.add('ait-data-table--enhanced');

    this.buildSortableHeaders();
    this.buildFilterRow();
    this.buildToolbar();
    this.bindExternalSearch();
    this.captureOriginalOrder();
    this.observeRows();
    this.observeHeaderSize();
    this.updateState();
    this.apply();
    this.initialized = true;

    return this;
  }

  readHeaderLabel(header, index) {
    return String(header.dataset.aitColumnLabel || header.textContent || `Column ${index + 1}`)
      .replace(/\s+/g, ' ')
      .trim();
  }

  buildSortableHeaders() {
    this.headers.forEach((header, columnIndex) => {
      const alignment = window.getComputedStyle(header).textAlign;
      if (alignment === 'left' || alignment === 'start') header.classList.add('ait-data-table-header--left');
      if (alignment === 'center') header.classList.add('ait-data-table-header--center');

      header.scope = 'col';
      header.dataset.aitColumnIndex = String(columnIndex);
      header.textContent = '';

      const button = document.createElement('button');
      button.type = 'button';
      button.className = 'ait-data-table-sort-button';
      button.dataset.aitColumnIndex = String(columnIndex);

      const label = document.createElement('span');
      label.className = 'ait-data-table-sort-button__label';
      label.textContent = this.labels[columnIndex];

      const state = document.createElement('span');
      state.className = 'ait-data-table-sort-button__state';
      state.setAttribute('aria-hidden', 'true');

      const direction = document.createElement('span');
      direction.className = 'ait-data-table-sort-button__direction';
      direction.textContent = '↕';

      const priority = document.createElement('span');
      priority.className = 'ait-data-table-sort-button__priority';
      priority.hidden = true;

      state.append(direction, priority);
      button.append(label, state);
      button.addEventListener('click', () => this.toggleSort(columnIndex));
      header.append(button);
    });
  }

  buildFilterRow() {
    this.filterRow = document.createElement('tr');
    this.filterRow.className = 'ait-data-table-filter-row';

    this.headers.forEach((_header, columnIndex) => {
      const filterHeader = document.createElement('th');
      filterHeader.scope = 'col';

      const input = document.createElement('input');
      input.type = 'search';
      input.className = 'ait-data-table-filter';
      input.dataset.aitColumnIndex = String(columnIndex);
      input.placeholder = this.options.filterPlaceholder;
      input.autocomplete = 'off';
      input.spellcheck = false;
      input.setAttribute('aria-label', `Filter ${this.labels[columnIndex]}`);
      input.title = 'Text contains; use >, >=, <, <=, =, != or 10..20 for numeric/date filters; use | for alternatives.';
      input.addEventListener('input', () => {
        input.classList.toggle('ait-data-table-filter--active', Boolean(input.value.trim()));
        this.scheduleApply();
      });
      input.addEventListener('keydown', (event) => {
        if (event.key !== 'Escape' || !input.value) return;
        event.stopPropagation();
        input.value = '';
        input.classList.remove('ait-data-table-filter--active');
        this.scheduleApply();
      });

      filterHeader.append(input);
      this.filterRow.append(filterHeader);
      this.filterInputs.push(input);
    });

    this.headerRow.insertAdjacentElement('afterend', this.filterRow);
  }

  buildToolbar() {
    this.toolbar = document.createElement('div');
    this.toolbar.className = 'ait-data-table-toolbar';
    this.toolbar.innerHTML = `
      <div class="ait-data-table-toolbar__guide">
        <strong>Multi-column sort &amp; filter</strong>
        <small>Click headings in priority order; click again to switch ASC/DESC.</small>
      </div>
      <div class="ait-data-table-toolbar__state">
        <span class="ait-data-table-toolbar__summary" aria-live="polite"></span>
        <span class="ait-data-table-toolbar__count" aria-live="polite">0 rows</span>
      </div>
      <div class="ait-data-table-toolbar__actions">
        <button class="ait-data-table-toolbar__button" type="button" data-ait-table-action="clear-sort">Clear sort</button>
        <button class="ait-data-table-toolbar__button" type="button" data-ait-table-action="clear-filters">Clear filters</button>
      </div>`;

    this.summary = this.toolbar.querySelector('.ait-data-table-toolbar__summary');
    this.count = this.toolbar.querySelector('.ait-data-table-toolbar__count');
    this.clearSortButton = this.toolbar.querySelector('[data-ait-table-action="clear-sort"]');
    this.clearFiltersButton = this.toolbar.querySelector('[data-ait-table-action="clear-filters"]');
    this.clearSortButton.addEventListener('click', () => this.clearSort());
    this.clearFiltersButton.addEventListener('click', () => this.clearFilters());

    const scannerRegion = this.table.closest('.v11-scanner-table-region');
    const fundamentalWrap = this.table.closest('.ait-fund-report-table-wrap');
    if (scannerRegion) scannerRegion.prepend(this.toolbar);
    else if (fundamentalWrap) fundamentalWrap.insertAdjacentElement('beforebegin', this.toolbar);
    else this.table.insertAdjacentElement('beforebegin', this.toolbar);
  }

  bindExternalSearch() {
    const scannerCard = this.table.closest('.v11-scanner-card');
    this.externalSearch = scannerCard?.querySelector('.v11-scanner-searchbar input') ?? null;
    if (this.tbody.id === 'aitFundamentalsReportBody') {
      this.externalSearch = document.getElementById('aitFundamentalsReportSearch');
    }
    if (!this.externalSearch) return;

    this.externalSearch.addEventListener('input', () => this.scheduleApply());
    const searchContainer = this.externalSearch.closest('.v11-scanner-searchbar, .ait-fund-report-search');
    searchContainer?.querySelector('button')?.addEventListener('click', () => this.scheduleApply());
  }

  observeRows() {
    this.rowObserver = new MutationObserver(() => this.scheduleApply());
    this.rowObserver.observe(this.tbody, { childList: true });
  }

  observeHeaderSize() {
    const update = () => this.updateStickyOffset();
    if ('ResizeObserver' in window) {
      this.headerResizeObserver = new ResizeObserver(update);
      this.headerResizeObserver.observe(this.headerRow);
    } else {
      window.addEventListener('resize', update, { passive: true });
      this.windowResizeHandler = update;
    }
    requestAnimationFrame(update);
  }

  updateStickyOffset() {
    const height = Math.ceil(this.headerRow.getBoundingClientRect().height);
    if (height > 0) this.table.style.setProperty('--ait-data-table-heading-height', `${height}px`);
  }

  toggleSort(columnIndex) {
    const existing = this.sortCriteria.find((criterion) => criterion.columnIndex === columnIndex);
    if (existing) existing.direction = existing.direction === 'asc' ? 'desc' : 'asc';
    else this.sortCriteria.push({ columnIndex, direction: 'asc' });

    this.updateState();
    this.apply();
  }

  clearSort() {
    if (!this.sortCriteria.length) return;
    this.sortCriteria = [];
    this.updateState();
    this.apply();
  }

  clearFilters() {
    let changed = false;
    this.filterInputs.forEach((input) => {
      if (input.value) changed = true;
      input.value = '';
      input.classList.remove('ait-data-table-filter--active');
    });
    if (!changed) return;
    this.updateState();
    this.apply();
  }

  captureOriginalOrder(rows = this.dataRows()) {
    rows.forEach((row) => {
      if (this.originalOrder.has(row)) return;
      this.originalOrder.set(row, this.originalOrderCounter);
      this.originalOrderCounter += 1;
    });
  }

  dataRows() {
    return Array.from(this.tbody.rows).filter((row) => !this.isMessageRow(row));
  }

  isMessageRow(row) {
    if (row.classList.contains('v11-scanner-search-empty') || row.classList.contains('ait-fund-report-empty')) return true;
    return row.cells.length === 1 && row.cells[0].colSpan > 1;
  }

  activeFilters() {
    return this.filterInputs
      .map((input, columnIndex) => ({ columnIndex, expression: input.value.trim() }))
      .filter((filter) => filter.expression);
  }

  externalSearchTerm() {
    return this.parser.normalize(this.externalSearch?.value).toLocaleLowerCase();
  }

  rowMatches(row, filters, externalSearchTerm) {
    if (externalSearchTerm) {
      const rowText = this.parser.normalize(row.textContent).toLocaleLowerCase();
      if (!rowText.includes(externalSearchTerm)) return false;
    }

    return filters.every(({ columnIndex, expression }) => {
      const value = this.parser.filterValueFromCell(row.cells[columnIndex]);
      return this.parser.matches(value, expression);
    });
  }

  sortedRows(rows) {
    return [...rows].sort((leftRow, rightRow) => {
      for (const criterion of this.sortCriteria) {
        const left = this.parser.valueFromCell(leftRow.cells[criterion.columnIndex]);
        const right = this.parser.valueFromCell(rightRow.cells[criterion.columnIndex]);
        const comparison = this.parser.compare(left, right, criterion.direction);
        if (comparison !== 0) return comparison;
      }

      return (this.originalOrder.get(leftRow) ?? 0) - (this.originalOrder.get(rightRow) ?? 0);
    });
  }

  reorderRows(rows) {
    const currentRows = this.dataRows();
    const orderChanged = rows.some((row, index) => currentRows[index] !== row);
    if (!orderChanged) return;

    const fragment = document.createDocumentFragment();
    rows.forEach((row) => fragment.append(row));
    this.tbody.append(fragment);
  }

  apply() {
    const rows = this.dataRows();
    this.captureOriginalOrder(rows);
    this.reorderRows(this.sortedRows(rows));

    const filters = this.activeFilters();
    const externalSearchTerm = this.externalSearchTerm();
    let visible = 0;

    rows.forEach((row) => {
      const matches = this.rowMatches(row, filters, externalSearchTerm);
      row.hidden = !matches;
      if (matches) visible += 1;
    });

    this.updateState(visible, rows.length);
  }

  scheduleApply() {
    if (this.applyScheduled) return;
    this.applyScheduled = true;
    requestAnimationFrame(() => {
      this.applyScheduled = false;
      this.apply();
    });
  }

  updateState(visibleRows = null, totalRows = null) {
    this.headers.forEach((header, columnIndex) => {
      const criterionIndex = this.sortCriteria.findIndex((criterion) => criterion.columnIndex === columnIndex);
      const criterion = criterionIndex >= 0 ? this.sortCriteria[criterionIndex] : null;
      const button = header.querySelector('.ait-data-table-sort-button');
      const direction = header.querySelector('.ait-data-table-sort-button__direction');
      const priority = header.querySelector('.ait-data-table-sort-button__priority');

      header.classList.toggle('ait-data-table-header--active', Boolean(criterion));
      if (!criterion) {
        header.removeAttribute('aria-sort');
        direction.textContent = '↕';
        priority.hidden = true;
        button.setAttribute('aria-label', `Sort by ${this.labels[columnIndex]}; adds the column as the next sort priority.`);
        return;
      }

      const ariaDirection = criterion.direction === 'asc' ? 'ascending' : 'descending';
      header.setAttribute('aria-sort', ariaDirection);
      direction.textContent = criterion.direction === 'asc' ? '↑' : '↓';
      priority.textContent = String(criterionIndex + 1);
      priority.hidden = false;
      button.setAttribute(
        'aria-label',
        `${this.labels[columnIndex]} is sort priority ${criterionIndex + 1}, ${ariaDirection}; click to switch direction.`,
      );
    });

    const summaryText = this.sortCriteria.length
      ? this.sortCriteria
        .map((criterion, index) => `${index + 1} ${this.labels[criterion.columnIndex]} ${criterion.direction === 'asc' ? '↑' : '↓'}`)
        .join('  ›  ')
      : 'Original scanner order';
    if (this.summary) this.summary.textContent = summaryText;

    const filtersActive = this.activeFilters().length > 0;
    if (this.clearSortButton) this.clearSortButton.disabled = this.sortCriteria.length === 0;
    if (this.clearFiltersButton) this.clearFiltersButton.disabled = !filtersActive;

    if (this.count && visibleRows !== null && totalRows !== null) {
      this.count.textContent = filtersActive || this.externalSearchTerm()
        ? `${visibleRows} of ${totalRows} rows`
        : `${totalRows} row${totalRows === 1 ? '' : 's'}`;
    }
  }

  destroy() {
    this.rowObserver?.disconnect();
    this.headerResizeObserver?.disconnect();
    if (this.windowResizeHandler) window.removeEventListener('resize', this.windowResizeHandler);
  }
}

class AitSortableFilterableTableManager {
  constructor(selector = AIT_DATA_TABLE_SELECTOR) {
    this.selector = selector;
    this.instances = new Map();
  }

  init(root = document) {
    root.querySelectorAll(this.selector).forEach((table) => this.enhance(table));
    return this;
  }

  enhance(table) {
    if (!(table instanceof HTMLTableElement)) return null;
    if (this.instances.has(table)) return this.instances.get(table);

    const instance = new AitSortableFilterableTable(table).init();
    if (instance.initialized) this.instances.set(table, instance);
    return instance;
  }

  getByBodyId(bodyId) {
    const table = document.getElementById(bodyId)?.closest('table');
    return table ? this.instances.get(table) ?? null : null;
  }
}

const bootAitSortableFilterableTables = () => {
  const manager = new AitSortableFilterableTableManager().init();
  window.AITSortableFilterableTables = manager;
  document.dispatchEvent(new CustomEvent('ait:sortable-filterable-tables-ready', {
    detail: { count: manager.instances.size },
  }));
};

if (document.readyState !== 'complete') {
  document.addEventListener('DOMContentLoaded', bootAitSortableFilterableTables, { once: true });
} else {
  bootAitSortableFilterableTables();
}

export {
  AitSortableFilterableTable,
  AitSortableFilterableTableManager,
  AitTableValueParser,
};
