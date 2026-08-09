(() => {
  'use strict';

  /**
   * Owns the portable CSV backup format for the rendered eBook.
   * Imported content is persisted locally and restored before the rest of the
   * application captures its page collection, keeping print/export in sync.
   */
  class EbookCsvBackupManager {
    constructor(options = {}) {
      this.book = document.getElementById(options.bookId || 'book');
      this.storageKey = options.storageKey || 'ait-ebook-csv-backup-v1';
      this.previewFlagKey = options.previewFlagKey || 'ait-ebook-import-preview-pending';
      this.format = 'ait-ebook-csv-backup';
      this.version = '1';
      this.columns = [
        'format',
        'version',
        'exported_at',
        'page_number',
        'page_title',
        'page_classes',
        'page_html'
      ];

      if (!this.book) return;

      this.applyStoredBackup();
      this.importInput = this.createImportInput();
      this.previewPanel = this.createPreviewPanel();
      this.scheduleImportedPreview();
    }

    getPages() {
      return Array.from(this.book.children).filter((element) => element.classList.contains('paper-page'));
    }

    createImportInput() {
      let input = document.getElementById('terminalEbookCsvImportFile');
      if (!input) {
        input = document.createElement('input');
        input.id = 'terminalEbookCsvImportFile';
        input.type = 'file';
        input.accept = '.csv,text/csv';
        input.hidden = true;
        document.body.appendChild(input);
      }

      input.addEventListener('change', async (event) => {
        const [file] = event.target.files || [];
        event.target.value = '';
        if (file) await this.importFromFile(file);
      });

      return input;
    }

    createPreviewPanel() {
      let panel = document.getElementById('aitEbookImportPreview');
      if (!panel) {
        panel = document.createElement('section');
        panel.id = 'aitEbookImportPreview';
        panel.className = 'ait-ebook-preview no-print';
        panel.hidden = true;
        panel.setAttribute('role', 'dialog');
        panel.setAttribute('aria-modal', 'true');
        panel.setAttribute('aria-hidden', 'true');
        panel.setAttribute('aria-labelledby', 'aitEbookPreviewTitle');
        panel.innerHTML = `
          <header class="ait-ebook-preview__header">
            <div class="ait-ebook-preview__heading">
              <span class="ait-ebook-preview__eyebrow" data-ait-ebook-preview-eyebrow>CSV IMPORT COMPLETE</span>
              <h2 id="aitEbookPreviewTitle" data-ait-ebook-preview-title>eBook Preview</h2>
              <p data-ait-ebook-preview-summary><span data-ait-ebook-preview-count>0 pages</span> · Review the imported eBook before continuing</p>
              <p data-ait-ebook-workspace-summary hidden>Configure the complete print workflow for this imported eBook</p>
            </div>
            <div class="ait-ebook-preview__actions">
              <button class="ait-ebook-preview__back" data-ait-ebook-preview-back hidden type="button"><span aria-hidden="true">←</span> Back to Preview</button>
              <button class="ait-ebook-preview__print" data-ait-ebook-preview-print type="button"><span aria-hidden="true">🖨</span> Print</button>
              <button class="ait-ebook-preview__close" data-ait-ebook-preview-close type="button" aria-label="Close eBook preview">×</button>
            </div>
          </header>
          <div class="ait-ebook-preview__viewport" data-ait-ebook-preview-viewport>
            <div class="ait-ebook-preview__book" data-ait-ebook-preview-book></div>
          </div>
          <div class="ait-ebook-preview__workspace" data-ait-ebook-print-workspace hidden>
            <iframe class="ait-ebook-preview__workspace-frame" data-ait-ebook-print-frame title="eBook Print Workspace" loading="eager"></iframe>
          </div>`;
        document.body.appendChild(panel);
      }

      this.previewBook = panel.querySelector('[data-ait-ebook-preview-book]');
      this.previewViewport = panel.querySelector('[data-ait-ebook-preview-viewport]');
      this.previewCount = panel.querySelector('[data-ait-ebook-preview-count]');
      this.previewEyebrow = panel.querySelector('[data-ait-ebook-preview-eyebrow]');
      this.previewTitle = panel.querySelector('[data-ait-ebook-preview-title]');
      this.previewSummary = panel.querySelector('[data-ait-ebook-preview-summary]');
      this.workspaceSummary = panel.querySelector('[data-ait-ebook-workspace-summary]');
      this.previewPrintButton = panel.querySelector('[data-ait-ebook-preview-print]');
      this.previewBackButton = panel.querySelector('[data-ait-ebook-preview-back]');
      this.previewPrintWorkspace = panel.querySelector('[data-ait-ebook-print-workspace]');
      this.previewPrintFrame = panel.querySelector('[data-ait-ebook-print-frame]');
      this.bindPreviewEvents(panel);
      return panel;
    }

    bindPreviewEvents(panel) {
      panel.addEventListener('click', (event) => {
        if (event.target.closest('[data-ait-ebook-preview-close]')) {
          this.closePreview();
          return;
        }
        if (event.target.closest('[data-ait-ebook-preview-back]')) {
          this.backToPreview();
          return;
        }
        if (event.target.closest('[data-ait-ebook-preview-print]')) this.openPrintWorkspace();
      });
      this.previewPrintFrame?.addEventListener('load', () => this.syncPrintWorkspaceTheme());
      document.addEventListener('keydown', (event) => {
        if (event.key !== 'Escape' || !this.previewPanel || this.previewPanel.hidden) return;
        if (this.previewPanel.classList.contains('is-print-workspace')) {
          this.backToPreview();
          return;
        }
        this.closePreview();
      });
    }

    scheduleImportedPreview() {
      if (localStorage.getItem(this.previewFlagKey) !== '1') return;
      localStorage.removeItem(this.previewFlagKey);
      window.setTimeout(() => this.openPreview(), 0);
    }

    openPreview() {
      if (!this.previewPanel || !this.previewBook) return;
      const pages = this.getPages();
      if (!pages.length) return;

      const clones = pages.map((page, index) => {
        const clone = page.cloneNode(true);
        clone.removeAttribute('id');
        clone.querySelectorAll('[id]').forEach((element) => element.removeAttribute('id'));
        clone.setAttribute('aria-label', `Page ${index + 1}: ${page.dataset.title || `Page ${index + 1}`}`);
        return clone;
      });
      this.previewBook.replaceChildren(...clones);
      if (this.previewCount) this.previewCount.textContent = `${pages.length} ${pages.length === 1 ? 'page' : 'pages'}`;
      this.previousFocus = document.activeElement;
      this.previewPanel.hidden = false;
      this.previewPanel.setAttribute('aria-hidden', 'false');
      this.previewPanel.classList.add('is-open');
      document.body.classList.add('ait-ebook-preview-open');
      this.backToPreview({ focus: false });
      if (this.previewViewport) this.previewViewport.scrollTop = 0;
      this.previewPrintButton?.focus();
    }

    openPrintWorkspace() {
      if (!this.previewPanel || !this.previewPrintWorkspace || !this.previewPrintFrame) return;
      this.previewPanel.classList.add('is-print-workspace');
      if (this.previewViewport) this.previewViewport.hidden = true;
      this.previewPrintWorkspace.hidden = false;
      if (this.previewEyebrow) this.previewEyebrow.textContent = 'EBOOK / PRINT';
      if (this.previewTitle) this.previewTitle.textContent = 'Print Workspace';
      if (this.previewSummary) this.previewSummary.hidden = true;
      if (this.workspaceSummary) this.workspaceSummary.hidden = false;
      if (this.previewPrintButton) this.previewPrintButton.hidden = true;
      if (this.previewBackButton) this.previewBackButton.hidden = false;

      if (!this.previewPrintFrame.getAttribute('src')) this.previewPrintFrame.setAttribute('src', 'print/index.html');
      this.previewBackButton?.focus();
    }

    backToPreview({ focus = true } = {}) {
      if (!this.previewPanel) return;
      this.previewPanel.classList.remove('is-print-workspace');
      if (this.previewViewport) this.previewViewport.hidden = false;
      if (this.previewPrintWorkspace) this.previewPrintWorkspace.hidden = true;
      if (this.previewEyebrow) this.previewEyebrow.textContent = 'CSV IMPORT COMPLETE';
      if (this.previewTitle) this.previewTitle.textContent = 'eBook Preview';
      if (this.previewSummary) this.previewSummary.hidden = false;
      if (this.workspaceSummary) this.workspaceSummary.hidden = true;
      if (this.previewPrintButton) this.previewPrintButton.hidden = false;
      if (this.previewBackButton) this.previewBackButton.hidden = true;
      if (focus) this.previewPrintButton?.focus();
    }

    syncPrintWorkspaceTheme() {
      const theme = document.documentElement.dataset.theme || localStorage.getItem('heart-routine-theme') || 'dark-glass';
      this.previewPrintFrame?.contentWindow?.postMessage({ type: 'ait-pha-theme', theme }, '*');
    }

    closePreview() {
      if (!this.previewPanel || this.previewPanel.hidden) return;
      this.backToPreview({ focus: false });
      this.previewPanel.classList.remove('is-open');
      this.previewPanel.hidden = true;
      this.previewPanel.setAttribute('aria-hidden', 'true');
      document.body.classList.remove('ait-ebook-preview-open');
      this.previewBook?.replaceChildren();
      this.previewPrintFrame?.removeAttribute('src');
      this.previousFocus?.focus?.();
    }

    openImportPicker() {
      if (!this.importInput) return;
      this.importInput.value = '';
      this.importInput.click();
    }

    exportToCsv() {
      const pages = this.getPages();
      if (!pages.length) {
        window.alert('No eBook pages are available to export.');
        return;
      }

      const exportedAt = new Date().toISOString();
      const rows = pages.map((page, index) => [
        this.format,
        this.version,
        exportedAt,
        String(index + 1),
        page.dataset.title || `Page ${index + 1}`,
        page.className,
        page.innerHTML.trim()
      ]);
      const csv = [this.columns, ...rows]
        .map((row) => row.map((value) => this.escapeCsvCell(value)).join(','))
        .join('\r\n');
      const blob = new Blob([`\uFEFF${csv}`], { type: 'text/csv;charset=utf-8' });
      const url = URL.createObjectURL(blob);
      const link = document.createElement('a');
      link.hidden = true;
      link.href = url;
      link.download = `ait-ebook-backup-${exportedAt.slice(0, 10)}.csv`;
      document.body.appendChild(link);
      link.click();
      link.remove();
      window.setTimeout(() => URL.revokeObjectURL(url), 0);
    }

    async importFromFile(file) {
      try {
        if (!file || !/\.csv$/i.test(file.name || '')) {
          throw new Error('Please select a CSV backup file.');
        }

        const records = this.parseBackupCsv(await file.text());
        const currentPageCount = this.getPages().length;
        if (records.length !== currentPageCount) {
          throw new Error(`This project requires ${currentPageCount} eBook pages; the CSV contains ${records.length}.`);
        }

        const approved = window.confirm(
          `Import ${records.length} eBook pages from “${file.name}”? This replaces the current eBook content in this browser.`
        );
        if (!approved) return;

        const payload = {
          format: this.format,
          version: this.version,
          importedAt: new Date().toISOString(),
          pages: records
        };
        localStorage.setItem(this.storageKey, JSON.stringify(payload));
        localStorage.setItem(this.previewFlagKey, '1');
        window.alert('eBook CSV imported successfully. The book will reload and open a full-width preview.');
        window.location.reload();
      } catch (error) {
        window.alert(`eBook CSV import failed: ${error.message || 'Invalid CSV backup.'}`);
      }
    }

    parseBackupCsv(csvText) {
      const rows = this.parseCsv(String(csvText || '').replace(/^\uFEFF/, ''));
      if (rows.length < 2) throw new Error('The CSV backup contains no eBook pages.');

      const header = rows.shift().map((value) => value.trim());
      const indexes = Object.fromEntries(this.columns.map((column) => [column, header.indexOf(column)]));
      const missing = this.columns.filter((column) => indexes[column] < 0);
      if (missing.length) throw new Error(`Missing CSV column(s): ${missing.join(', ')}.`);

      const records = rows
        .filter((row) => row.some((value) => value !== ''))
        .map((row, rowIndex) => {
          const format = row[indexes.format] || '';
          const version = row[indexes.version] || '';
          if (format !== this.format || version !== this.version) {
            throw new Error(`Unsupported backup format on CSV row ${rowIndex + 2}.`);
          }

          return this.normalizeRecord({
            pageNumber: Number(row[indexes.page_number]),
            title: row[indexes.page_title] || '',
            classes: row[indexes.page_classes] || '',
            html: row[indexes.page_html] || ''
          }, rowIndex + 2);
        });

      if (!records.length) throw new Error('The CSV backup contains no eBook pages.');
      records.sort((left, right) => left.pageNumber - right.pageNumber);

      const pageNumbers = records.map((record) => record.pageNumber);
      if (new Set(pageNumbers).size !== pageNumbers.length) throw new Error('Duplicate page numbers were found in the CSV backup.');
      if (!pageNumbers.every((number, index) => number === index + 1)) {
        throw new Error('Page numbers must be consecutive and start at 1.');
      }

      return records;
    }

    normalizeRecord(record, csvRow = 0) {
      if (!Number.isInteger(record.pageNumber) || record.pageNumber < 1) {
        throw new Error(`Invalid page number${csvRow ? ` on CSV row ${csvRow}` : ''}.`);
      }

      const html = this.sanitizePageHtml(record.html);
      const template = document.createElement('template');
      template.innerHTML = html;
      if (!template.content.querySelector('.page-art') || !template.content.querySelector('.page-body')) {
        throw new Error(`Page ${record.pageNumber} is missing the required page structure.`);
      }

      return {
        pageNumber: record.pageNumber,
        title: String(record.title || `Page ${record.pageNumber}`).trim() || `Page ${record.pageNumber}`,
        classes: this.sanitizeClassName(record.classes),
        html
      };
    }

    sanitizeClassName(value) {
      const classes = String(value || '')
        .split(/\s+/)
        .filter((className) => /^[A-Za-z0-9_-]+$/.test(className));
      if (!classes.includes('paper-page')) classes.unshift('paper-page');
      return [...new Set(classes)].join(' ');
    }

    sanitizePageHtml(value) {
      const template = document.createElement('template');
      template.innerHTML = String(value || '');
      template.content
        .querySelectorAll('script,iframe,object,embed,base,meta,link')
        .forEach((element) => element.remove());
      template.content.querySelectorAll('*').forEach((element) => {
        Array.from(element.attributes).forEach((attribute) => {
          const name = attribute.name.toLowerCase();
          const content = attribute.value.trim();
          if (name.startsWith('on') || name === 'srcdoc') {
            element.removeAttribute(attribute.name);
            return;
          }
          if (['href', 'src', 'xlink:href', 'formaction'].includes(name) && /^(?:javascript:|data:text\/html)/i.test(content)) {
            element.removeAttribute(attribute.name);
          }
        });
      });
      return template.innerHTML.trim();
    }

    applyStoredBackup() {
      const saved = localStorage.getItem(this.storageKey);
      if (!saved) return;

      try {
        const payload = JSON.parse(saved);
        if (payload?.format !== this.format || payload?.version !== this.version || !Array.isArray(payload.pages)) {
          throw new Error('Unsupported saved eBook backup.');
        }

        const currentPageCount = this.getPages().length;
        const records = payload.pages
          .map((record) => this.normalizeRecord(record))
          .sort((left, right) => left.pageNumber - right.pageNumber);
        if (records.length !== currentPageCount) throw new Error('Saved eBook page count does not match this project.');

        const pageNumbers = records.map((record) => record.pageNumber);
        if (!pageNumbers.every((number, index) => number === index + 1)) throw new Error('Saved eBook pages are out of sequence.');

        const fragment = document.createDocumentFragment();
        records.forEach((record) => {
          const page = document.createElement('section');
          page.className = record.classes;
          page.dataset.title = record.title;
          page.innerHTML = record.html;
          fragment.appendChild(page);
        });
        this.book.replaceChildren(fragment);
      } catch (error) {
        console.warn('Saved eBook CSV backup could not be applied.', error);
      }
    }

    parseCsv(text) {
      const rows = [];
      let row = [];
      let field = '';
      let quoted = false;

      for (let index = 0; index < text.length; index += 1) {
        const character = text[index];
        if (quoted) {
          if (character === '"') {
            if (text[index + 1] === '"') {
              field += '"';
              index += 1;
            } else {
              quoted = false;
            }
          } else {
            field += character;
          }
          continue;
        }

        if (character === '"' && field === '') {
          quoted = true;
        } else if (character === ',') {
          row.push(field);
          field = '';
        } else if (character === '\r' || character === '\n') {
          if (character === '\r' && text[index + 1] === '\n') index += 1;
          row.push(field);
          rows.push(row);
          row = [];
          field = '';
        } else {
          field += character;
        }
      }

      if (quoted) throw new Error('The CSV contains an unterminated quoted field.');
      if (field !== '' || row.length) {
        row.push(field);
        rows.push(row);
      }
      return rows;
    }

    escapeCsvCell(value) {
      return `"${String(value ?? '').replace(/"/g, '""')}"`;
    }
  }

  window.AITEbookCsvBackupManager = new EbookCsvBackupManager();
})();

(() => {
  'use strict';
const AIT_PRINT_PAPER_SIZES={"a0":{"label":"A0","width":841,"height":1189,"unit":"mm","dimensions":"841 × 1189 mm","group":"ISO A"},"a1":{"label":"A1","width":594,"height":841,"unit":"mm","dimensions":"594 × 841 mm","group":"ISO A"},"a2":{"label":"A2","width":420,"height":594,"unit":"mm","dimensions":"420 × 594 mm","group":"ISO A"},"a3":{"label":"A3","width":297,"height":420,"unit":"mm","dimensions":"297 × 420 mm","group":"ISO A"},"a4":{"label":"A4","width":210,"height":297,"unit":"mm","dimensions":"210 × 297 mm","group":"ISO A"},"a5":{"label":"A5","width":148,"height":210,"unit":"mm","dimensions":"148 × 210 mm","group":"ISO A"},"a6":{"label":"A6","width":105,"height":148,"unit":"mm","dimensions":"105 × 148 mm","group":"ISO A"},"a7":{"label":"A7","width":74,"height":105,"unit":"mm","dimensions":"74 × 105 mm","group":"ISO A"},"a8":{"label":"A8","width":52,"height":74,"unit":"mm","dimensions":"52 × 74 mm","group":"ISO A"},"a9":{"label":"A9","width":37,"height":52,"unit":"mm","dimensions":"37 × 52 mm","group":"ISO A"},"a10":{"label":"A10","width":26,"height":37,"unit":"mm","dimensions":"26 × 37 mm","group":"ISO A"},"b0":{"label":"B0","width":1000,"height":1414,"unit":"mm","dimensions":"1000 × 1414 mm","group":"ISO B"},"b1":{"label":"B1","width":707,"height":1000,"unit":"mm","dimensions":"707 × 1000 mm","group":"ISO B"},"b2":{"label":"B2","width":500,"height":707,"unit":"mm","dimensions":"500 × 707 mm","group":"ISO B"},"b3":{"label":"B3","width":353,"height":500,"unit":"mm","dimensions":"353 × 500 mm","group":"ISO B"},"b4":{"label":"B4","width":250,"height":353,"unit":"mm","dimensions":"250 × 353 mm","group":"ISO B"},"b5":{"label":"B5","width":176,"height":250,"unit":"mm","dimensions":"176 × 250 mm","group":"ISO B"},"b6":{"label":"B6","width":125,"height":176,"unit":"mm","dimensions":"125 × 176 mm","group":"ISO B"},"b7":{"label":"B7","width":88,"height":125,"unit":"mm","dimensions":"88 × 125 mm","group":"ISO B"},"b8":{"label":"B8","width":62,"height":88,"unit":"mm","dimensions":"62 × 88 mm","group":"ISO B"},"b9":{"label":"B9","width":44,"height":62,"unit":"mm","dimensions":"44 × 62 mm","group":"ISO B"},"b10":{"label":"B10","width":31,"height":44,"unit":"mm","dimensions":"31 × 44 mm","group":"ISO B"},"c0":{"label":"C0","width":917,"height":1297,"unit":"mm","dimensions":"917 × 1297 mm","group":"ISO C"},"c1":{"label":"C1","width":648,"height":917,"unit":"mm","dimensions":"648 × 917 mm","group":"ISO C"},"c2":{"label":"C2","width":458,"height":648,"unit":"mm","dimensions":"458 × 648 mm","group":"ISO C"},"c3":{"label":"C3","width":324,"height":458,"unit":"mm","dimensions":"324 × 458 mm","group":"ISO C"},"c4":{"label":"C4","width":229,"height":324,"unit":"mm","dimensions":"229 × 324 mm","group":"ISO C"},"c5":{"label":"C5","width":162,"height":229,"unit":"mm","dimensions":"162 × 229 mm","group":"ISO C"},"c6":{"label":"C6","width":114,"height":162,"unit":"mm","dimensions":"114 × 162 mm","group":"ISO C"},"c7":{"label":"C7","width":81,"height":114,"unit":"mm","dimensions":"81 × 114 mm","group":"ISO C"},"c8":{"label":"C8","width":57,"height":81,"unit":"mm","dimensions":"57 × 81 mm","group":"ISO C"},"c9":{"label":"C9","width":40,"height":57,"unit":"mm","dimensions":"40 × 57 mm","group":"ISO C"},"c10":{"label":"C10","width":28,"height":40,"unit":"mm","dimensions":"28 × 40 mm","group":"ISO C"},"business-card":{"label":"Business Card","width":85,"height":55,"unit":"mm","dimensions":"85 × 55 mm","group":"Card"},"letter":{"label":"Letter","width":8.5,"height":11,"unit":"in","dimensions":"8.5 × 11 in","group":"North America"},"legal":{"label":"Legal","width":8.5,"height":14,"unit":"in","dimensions":"8.5 × 14 in","group":"North America"},"tabloid":{"label":"Tabloid","width":11,"height":17,"unit":"in","dimensions":"11 × 17 in","group":"North America"},"ledger":{"label":"Ledger","width":17,"height":11,"unit":"in","dimensions":"17 × 11 in","group":"North America"},"executive":{"label":"Executive","width":7.25,"height":10.5,"unit":"in","dimensions":"7.25 × 10.5 in","group":"North America"},"statement":{"label":"Statement","width":5.5,"height":8.5,"unit":"in","dimensions":"5.5 × 8.5 in","group":"North America"},"folio":{"label":"Folio","width":8.5,"height":13,"unit":"in","dimensions":"8.5 × 13 in","group":"North America"},"quarto":{"label":"Quarto","width":8.5,"height":10.83,"unit":"in","dimensions":"8.5 × 10.83 in","group":"North America"},"government-letter":{"label":"Government Letter","width":8,"height":10.5,"unit":"in","dimensions":"8 × 10.5 in","group":"North America"},"government-legal":{"label":"Government Legal","width":8.5,"height":13,"unit":"in","dimensions":"8.5 × 13 in","group":"North America"},"junior-legal":{"label":"Junior Legal","width":5,"height":8,"unit":"in","dimensions":"5 × 8 in","group":"North America"},"ansi-c":{"label":"ANSI C","width":17,"height":22,"unit":"in","dimensions":"17 × 22 in","group":"ANSI"},"ansi-d":{"label":"ANSI D","width":22,"height":34,"unit":"in","dimensions":"22 × 34 in","group":"ANSI"},"ansi-e":{"label":"ANSI E","width":34,"height":44,"unit":"in","dimensions":"34 × 44 in","group":"ANSI"},"arch-a":{"label":"ARCH A","width":9,"height":12,"unit":"in","dimensions":"9 × 12 in","group":"Architectural"},"arch-b":{"label":"ARCH B","width":12,"height":18,"unit":"in","dimensions":"12 × 18 in","group":"Architectural"},"arch-c":{"label":"ARCH C","width":18,"height":24,"unit":"in","dimensions":"18 × 24 in","group":"Architectural"},"arch-d":{"label":"ARCH D","width":24,"height":36,"unit":"in","dimensions":"24 × 36 in","group":"Architectural"},"arch-e":{"label":"ARCH E","width":36,"height":48,"unit":"in","dimensions":"36 × 48 in","group":"Architectural"},"4x6":{"label":"Photo 4×6","width":4,"height":6,"unit":"in","dimensions":"4 × 6 in","group":"Photo"},"5x7":{"label":"Photo 5×7","width":5,"height":7,"unit":"in","dimensions":"5 × 7 in","group":"Photo"},"8x10":{"label":"Photo 8×10","width":8,"height":10,"unit":"in","dimensions":"8 × 10 in","group":"Photo"},"square-5":{"label":"Square 5×5","width":5,"height":5,"unit":"in","dimensions":"5 × 5 in","group":"Photo"},"square-8":{"label":"Square 8×8","width":8,"height":8,"unit":"in","dimensions":"8 × 8 in","group":"Photo"},"index-3x5":{"label":"Index Card 3×5","width":3,"height":5,"unit":"in","dimensions":"3 × 5 in","group":"Card"},"index-4x6":{"label":"Index Card 4×6","width":4,"height":6,"unit":"in","dimensions":"4 × 6 in","group":"Card"},"index-5x8":{"label":"Index Card 5×8","width":5,"height":8,"unit":"in","dimensions":"5 × 8 in","group":"Card"}};
  const body = document.body;
  const book = document.getElementById('book');
  const select = document.getElementById('paperSize');
  const pages = [...document.querySelectorAll('.paper-page')];
  const zoomLabel = document.getElementById('zoomLabel');
  const status = document.getElementById('layoutStatus');
  const pageCount = document.getElementById('pageCount');
  let userZoom = 1;
  let resizeTimer = 0;

  const pageRules = {
    a0: '@page{size:A0 portrait;margin:0}',
    a4: '@page{size:A4 portrait;margin:0}',
    a5: '@page{size:A5 portrait;margin:0}',
    saddleStitch: '@page{size:A4 landscape;margin:0}',
    perfectBinding: '@page{size:A5 portrait;margin:0}',
    wireO: '@page{size:A5 portrait;margin:0}'
  };
  const dynamic = document.createElement('style');
  dynamic.id = 'dynamic-page-rule';
  document.head.appendChild(dynamic);

  pages.forEach((page, i) => {
    const n = page.querySelector('.folio-number');
    if (n) n.textContent = `পৃষ্ঠা ${i + 1} / ${pages.length}`;
  });
  if (pageCount) pageCount.textContent = `${pages.length} পৃষ্ঠা`;

  function updateResponsivePreview() {
    if (window.matchMedia('print').matches) return;

    const isPhoneOrTablet = window.innerWidth <= 900;
    if (!isPhoneOrTablet) {
      body.style.removeProperty('--preview-scale');
      return;
    }

    const paperWidthsMm = { a0: 841, a4: 210, a5: 148 };
    const selected = body.dataset.paper || 'a4';
    const paperWidthMm = paperWidthsMm[selected] || 210;
    const availableWidth = Math.max(240, window.innerWidth - 16);
    const cssPixelsPerMm = 96 / 25.4;
    const previewScale = availableWidth / (paperWidthMm * cssPixelsPerMm);
    body.style.setProperty('--preview-scale', String(previewScale));
  }

  function applyZoom() {
    updateResponsivePreview();
    book.style.transform = `scale(${userZoom})`;
    book.style.marginBottom = `${Math.max(34, (userZoom - 1) * book.offsetHeight + 34)}px`;
    zoomLabel.textContent = `${Math.round(userZoom * 100)}%`;
  }

  function validateLayout() {
    const overflowing = [];
    document.querySelectorAll('.page-body').forEach((el, i) => {
      if (el.scrollHeight > el.clientHeight + 2 || el.scrollWidth > el.clientWidth + 2) overflowing.push(i + 1);
    });
    if (overflowing.length) {
      if (status) { status.textContent = `⚠ Content overflow: page ${overflowing.join(', ')}`; status.className = 'layout-bad'; }
    } else {
      if (status) { status.textContent = '✓ সব পৃষ্ঠার content সম্পূর্ণ দৃশ্যমান'; status.className = 'layout-ok'; }
    }
  }

  function setPaper(size) {
    if (!pageRules[size]) size = 'a4';
    body.dataset.paper = size;
    select.value = size;
    dynamic.textContent = pageRules[size];
    localStorage.setItem('heart-routine-paper', size);
    userZoom = 1;
    updateResponsivePreview();
    applyZoom();
    requestAnimationFrame(validateLayout);
  }

  select.addEventListener('change', e => setPaper(e.target.value));
  document.getElementById('zoomIn').addEventListener('click', () => { userZoom = Math.min(2.2, userZoom + .1); applyZoom(); });
  document.getElementById('zoomOut').addEventListener('click', () => { userZoom = Math.max(.35, userZoom - .1); applyZoom(); });
  document.getElementById('resetZoom').addEventListener('click', () => { userZoom = 1; applyZoom(); });

  let activePrintConfig = { mode: 'normal', size: localStorage.getItem('heart-routine-paper') || 'a4' };
  let bookletContainer = null;

  function clearBookPrintArtifacts() {
    document.documentElement.removeAttribute('data-book-binding');
    document.documentElement.removeAttribute('data-saddle-final-paper');
    document.documentElement.removeAttribute('data-saddle-sheet');
    document.documentElement.style.removeProperty('--booklet-sheet-width');
    document.documentElement.style.removeProperty('--booklet-sheet-height');
    document.documentElement.style.removeProperty('--booklet-page-width');
    document.documentElement.style.removeProperty('--booklet-page-height');
    document.documentElement.style.removeProperty('--booklet-page-scale');
    document.body.classList.remove('book-print-active','book-print-saddle','book-print-perfect','book-print-wire');
    bookletContainer?.remove();
    bookletContainer = null;
  }

  function clonePageForBook(page, className='') {
    const clone = page.cloneNode(true);
    clone.removeAttribute('id');
    clone.classList.add('book-print-page');
    if (className) clone.classList.add(className);
    clone.querySelectorAll('[id]').forEach(element => element.removeAttribute('id'));
    return clone;
  }

  function createBlankBookPage() {
    const blank = document.createElement('article');
    blank.className = 'paper-page book-print-page book-print-blank';
    blank.setAttribute('aria-hidden','true');
    return blank;
  }

  function getSaddleSheetConfig(finalPaper = 'a5', finalOrientation = 'portrait') {
    const normalizedPaper = ['a3','a4','a5'].includes(finalPaper) ? finalPaper : 'a5';

    /*
     * Saddle-stitch uses a parent sheet twice the final portrait page width:
     * A5 pages -> A4 landscape sheet
     * A4 pages -> A3 landscape sheet
     * A3 pages -> A2 landscape sheet
     */
    const mapping = {
      a5: { sheet: 'A4', width: '297mm', height: '210mm', pageWidth: '148.5mm', pageHeight: '210mm', scale: 0.7071428571 },
      a4: { sheet: 'A3', width: '420mm', height: '297mm', pageWidth: '210mm', pageHeight: '297mm', scale: 1 },
      a3: { sheet: 'A2', width: '594mm', height: '420mm', pageWidth: '297mm', pageHeight: '420mm', scale: 1.4142857143 }
    };

    return {
      ...(mapping[normalizedPaper]||(()=>{
        const p=AIT_PRINT_PAPER_SIZES[normalizedPaper]||AIT_PRINT_PAPER_SIZES.a5;
        const widthMm=p.unit==='mm'?p.width:p.width*25.4;
        const heightMm=p.unit==='mm'?p.height:p.height*25.4;
        return{
          sheet:`Custom ${Math.round(widthMm*2)}×${Math.round(heightMm)} mm`,
          width:`${widthMm*2}mm`,
          height:`${heightMm}mm`,
          pageWidth:`${widthMm}mm`,
          pageHeight:`${heightMm}mm`
        };
      })()),
      finalPaper: normalizedPaper,
      finalOrientation: finalOrientation === 'landscape' ? 'landscape' : 'portrait'
    };
  }

  function createBookletSlot(page) {
    const slot = document.createElement('div');
    slot.className = 'booklet-page-slot';
    slot.append(page);
    return slot;
  }

  function prepareSaddleStitch(finalPaper = 'a5', finalOrientation = 'portrait') {
    clearBookPrintArtifacts();

    const sheet = getSaddleSheetConfig(finalPaper, finalOrientation);

    document.documentElement.dataset.bookBinding = 'saddle-stitch';
    document.documentElement.dataset.saddleFinalPaper = sheet.finalPaper;
    document.documentElement.dataset.saddleSheet = sheet.sheet.toLowerCase();
    document.body.classList.add('book-print-active','book-print-saddle');

    document.documentElement.style.setProperty('--booklet-sheet-width', sheet.width);
    document.documentElement.style.setProperty('--booklet-sheet-height', sheet.height);
    document.documentElement.style.setProperty('--booklet-page-width', sheet.pageWidth);
    document.documentElement.style.setProperty('--booklet-page-height', sheet.pageHeight);
    document.documentElement.style.setProperty('--booklet-page-scale', String(sheet.scale));

    const sourcePages = [...document.querySelectorAll('#book > .paper-page')];
    const padded = sourcePages.map(page => clonePageForBook(page));

    while (padded.length % 4 !== 0) {
      padded.push(createBlankBookPage());
    }

    bookletContainer = document.createElement('section');
    bookletContainer.id = 'bookletPrintStage';
    bookletContainer.className = 'booklet-print-stage';
    bookletContainer.setAttribute('aria-label', 'Saddle-stitch imposed print sheets');

    let first = 0;
    let last = padded.length - 1;
    let sheetNumber = 1;

    while (first < last) {
      // Front side: last page on left, first page on right.
      const front = document.createElement('div');
      front.className = 'booklet-sheet booklet-sheet--front';
      front.dataset.sheet = String(sheetNumber);
      front.dataset.side = 'front';
      front.append(createBookletSlot(padded[last]), createBookletSlot(padded[first]));
      bookletContainer.append(front);
      first += 1;
      last -= 1;

      // Back side: next page on left, previous page on right.
      const back = document.createElement('div');
      back.className = 'booklet-sheet booklet-sheet--back';
      back.dataset.sheet = String(sheetNumber);
      back.dataset.side = 'back';
      back.append(createBookletSlot(padded[first]), createBookletSlot(padded[last]));
      bookletContainer.append(back);
      first += 1;
      last -= 1;
      sheetNumber += 1;
    }

    document.body.append(bookletContainer);

    /*
     * The selected A5 is the final folded page size. The actual printer sheet is
     * A4 landscape, so @page must use the parent sheet, not A5 portrait.
     */
    dynamic.textContent=`@page{size:${sheet.width} ${sheet.height};margin:0}`;
  }

  function prepareBoundSequential(binding) {
    clearBookPrintArtifacts();
    const className = binding === 'perfect-binding' ? 'book-print-perfect' : 'book-print-wire';
    document.documentElement.dataset.bookBinding = binding;
    document.body.classList.add('book-print-active', className);
    dynamic.textContent = binding === 'perfect-binding' ? pageRules.perfectBinding : pageRules.wireO;
  }

  function getPrintPaperRule(paperKey,orientation='portrait'){
    const paper=AIT_PRINT_PAPER_SIZES[paperKey]||AIT_PRINT_PAPER_SIZES.a4;
    const width=`${paper.width}${paper.unit}`;
    const height=`${paper.height}${paper.unit}`;
    const landscape=orientation==='landscape';
    return {
      paper,
      width:landscape?height:width,
      height:landscape?width:height,
      pageRule:`@page{size:${landscape?height+' '+width:width+' '+height};margin:0}`
    };
  }

  function applyPrintConfig(config = {}, shouldPrint = false) {
    const mode = config.mode === 'book' ? 'book' : 'normal';
    const paper = Object.prototype.hasOwnProperty.call(AIT_PRINT_PAPER_SIZES,config.paper) ? config.paper : 'a4';
    const orientation = config.orientation === 'landscape' ? 'landscape' : 'portrait';
    const binding = ['saddle-stitch','perfect-binding','wire-o'].includes(config.binding) ? config.binding : 'saddle-stitch';

    activePrintConfig = {
      mode,
      paper,
      orientation,
      bookType: config.bookType || 'booklet',
      binding,
      duplex: config.duplex !== false,
      cropMarks: Boolean(config.cropMarks),
      pageNumbers:config.pageNumbers!==false,printQuality:config.printQuality||'high',printerType:config.printerType||'digital-press',resolution:Number(config.resolution||300),colorProfile:config.colorProfile||'cmyk-fogra39',pdfStandard:config.pdfStandard||'pdfx-4',renderingIntent:config.renderingIntent||'relative',bleed:Math.max(0,Number(config.bleed||0)),safeMargin:Math.max(0,Number(config.safeMargin||10)),spineMode:config.spineMode||'auto',spineWidth:Math.max(0,Number(config.spineWidth||0)),coverType:config.coverType||'separate-cover',coverStock:config.coverStock||'350-art-card',insidePaper:config.insidePaper||'157-matte',lamination:config.lamination||'matte',finishing:config.finishing||'emboss',imposition:config.imposition||'auto',spotUv:Boolean(config.spotUv),foilLayer:Boolean(config.foilLayer),insideCover:Boolean(config.insideCover)
    };

    localStorage.setItem('ait-pha-print-config', JSON.stringify(activePrintConfig));

    document.documentElement.dataset.printMode = mode;
    document.documentElement.dataset.printOrientation = orientation;
    document.documentElement.dataset.printPaper = paper;
    document.documentElement.dataset.bookType = activePrintConfig.bookType;
    document.documentElement.classList.toggle('print-crop-marks', activePrintConfig.cropMarks);
    document.documentElement.classList.toggle('print-hide-page-numbers', !activePrintConfig.pageNumbers);
    document.documentElement.dataset.printQuality=activePrintConfig.printQuality;
    document.documentElement.dataset.printerType=activePrintConfig.printerType;
    document.documentElement.dataset.coverType=activePrintConfig.coverType;
    document.documentElement.dataset.finishing=activePrintConfig.finishing;
    document.documentElement.classList.toggle('print-spot-uv',activePrintConfig.spotUv);
    document.documentElement.classList.toggle('print-foil-layer',activePrintConfig.foilLayer);
    document.documentElement.style.setProperty('--print-bleed',`${activePrintConfig.bleed}mm`);
    document.documentElement.style.setProperty('--print-safe-margin',`${activePrintConfig.safeMargin}mm`);
    const autoSpine=Math.max(0,document.querySelectorAll('#book > .paper-page').length*0.08);
    document.documentElement.style.setProperty('--print-spine-width',`${activePrintConfig.spineMode==='manual'?activePrintConfig.spineWidth:autoSpine.toFixed(2)}mm`);

    if (mode === 'normal') {
      clearBookPrintArtifacts();
      const paperRule=getPrintPaperRule(paper,orientation);
      dynamic.textContent=paperRule.pageRule;
      document.documentElement.style.setProperty('--selected-print-width',paperRule.width);
      document.documentElement.style.setProperty('--selected-print-height',paperRule.height);
      body.dataset.paper=paper;
    } else if (binding === 'saddle-stitch') {
      prepareSaddleStitch(paper, orientation);
    } else {
      prepareBoundSequential(binding);
      const paperRule=getPrintPaperRule(paper,orientation);
      dynamic.textContent=paperRule.pageRule;
      document.documentElement.style.setProperty('--selected-print-width',paperRule.width);
      document.documentElement.style.setProperty('--selected-print-height',paperRule.height);
    }

    if (shouldPrint) {
      document.documentElement.classList.add('print-preparing');
      document.getElementById('appHeader')?.classList.remove('controls-open');
      document.getElementById('exerciseMenu')?.classList.remove('is-open');
      book.style.transform = 'none';
      book.style.marginBottom = '0';
      setTimeout(() => window.print(), 80);
    }
  }

  document.getElementById('printBtn').addEventListener('click', () => {
    if (activePrintConfig.mode === 'book') {
      applyPrintConfig(activePrintConfig, false);
    } else {
      dynamic.textContent = pageRules[body.dataset.paper] || pageRules.a4;
    }
    document.documentElement.classList.add('print-preparing');
    document.getElementById('appHeader')?.classList.remove('controls-open');
    document.getElementById('exerciseMenu')?.classList.remove('is-open');
    book.style.transform = 'none';
    book.style.marginBottom = '0';
    window.print();
  });

  const terminalPrintSelectors = '#terminalLauncher,#terminalDock,#terminalDockBackdrop,#terminalModalShell,#jpgPanel';
  function suppressTerminalForOutput() {
    document.querySelectorAll(terminalPrintSelectors).forEach(element => {
      element.dataset.outputDisplay = element.style.display || '';
      element.style.setProperty('display', 'none', 'important');
      element.style.setProperty('visibility', 'hidden', 'important');
      element.style.setProperty('opacity', '0', 'important');
    });
  }
  function restoreTerminalAfterOutput() {
    document.querySelectorAll(terminalPrintSelectors).forEach(element => {
      element.style.removeProperty('display');
      element.style.removeProperty('visibility');
      element.style.removeProperty('opacity');
      delete element.dataset.outputDisplay;
    });
  }

  let activePosterConfig=null;

  function getPosterDimensions(config){
    const sizes={
      a3:{w:297,h:420},a2:{w:420,h:594},a1:{w:594,h:841},a0:{w:841,h:1189},
      '24x36':{w:609.6,h:914.4}
    };
    const base=config.size==='custom'?{w:Number(config.customWidth||420),h:Number(config.customHeight||594)}:(sizes[config.size]||sizes.a3);
    return config.orientation==='landscape'?{w:base.h,h:base.w}:{w:base.w,h:base.h};
  }

  function applyPosterConfig(config={},shouldPrint=false){
    activePosterConfig={...config};
    localStorage.setItem('ait-pha-poster-config',JSON.stringify(activePosterConfig));

    const d=getPosterDimensions(activePosterConfig);
    document.documentElement.dataset.posterMode='active';
    document.documentElement.dataset.posterLayout=activePosterConfig.layout||'hero';
    document.documentElement.dataset.posterDensity=activePosterConfig.density||'balanced';
    document.documentElement.dataset.posterTheme=activePosterConfig.theme||'current';
    document.documentElement.dataset.posterTypography=activePosterConfig.typography||'editorial';
    document.documentElement.dataset.posterPrinter=activePosterConfig.printerType||'digital';
    document.documentElement.classList.toggle('poster-crop-marks',Boolean(activePosterConfig.cropMarks));
    document.documentElement.classList.toggle('poster-registration-marks',Boolean(activePosterConfig.registrationMarks));
    document.documentElement.classList.toggle('poster-hide-background',!activePosterConfig.includeBackground);
    document.documentElement.style.setProperty('--poster-width',`${d.w}mm`);
    document.documentElement.style.setProperty('--poster-height',`${d.h}mm`);
    document.documentElement.style.setProperty('--poster-bleed',`${Number(activePosterConfig.bleed||0)}mm`);
    document.documentElement.style.setProperty('--poster-safe-margin',`${Number(activePosterConfig.safeMargin||10)}mm`);
    document.documentElement.style.setProperty('--poster-radius',`${Number(activePosterConfig.radius||16)}px`);
    document.documentElement.style.setProperty('--poster-gap',`${Number(activePosterConfig.gap||16)}px`);

    dynamic.textContent=`@page{size:${d.w}mm ${d.h}mm;margin:0}`;

    if(shouldPrint){
      document.documentElement.classList.add('poster-print-active','print-preparing');
      document.getElementById('appHeader')?.classList.remove('controls-open');
      book.style.transform='none';
      book.style.marginBottom='0';
      setTimeout(()=>window.print(),80);
    }
  }

  window.addEventListener('message',event=>{
    if(event.data?.type!=='ait-pha-poster-request')return;
    applyPosterConfig(event.data.config||{},Boolean(event.data.print));
  });

  window.addEventListener('message', event => {
    if (event.data?.type !== 'ait-pha-print-request') return;
    applyPrintConfig(event.data.config || {}, Boolean(event.data.print));
  });

  window.addEventListener('beforeprint', () => {
    if (activePrintConfig.mode === 'book') {
      applyPrintConfig(activePrintConfig, false);
    } else {
      dynamic.textContent = pageRules[body.dataset.paper] || pageRules.a4;
    }
    document.documentElement.classList.add('print-preparing');
    suppressTerminalForOutput();
    book.style.transform = 'none';
    book.style.marginBottom = '0';
  });

  window.addEventListener('afterprint', () => {
    document.documentElement.classList.remove('print-preparing');
    restoreTerminalAfterOutput();
    if (activePrintConfig.mode === 'book') clearBookPrintArtifacts();
    applyZoom();
  });

  window.addEventListener('load', () => {
    updateResponsivePreview();
    applyZoom();
    validateLayout();
  });

  window.addEventListener('resize', () => {
    clearTimeout(resizeTimer);
    resizeTimer = window.setTimeout(() => {
      if (window.innerWidth <= 900 && userZoom < 1) userZoom = 1;
      updateResponsivePreview();
      applyZoom();
      validateLayout();
    }, 80);
  });


  // ---------------- SINGLE A0 COMPOSITE DSLR JPG EXPORT ----------------
  const jpgBtn = document.getElementById('jpgBtn');
  const jpgPanel = document.getElementById('jpgPanel');
  const jpgDpi = document.getElementById('jpgDpi');
  const jpgQuality = document.getElementById('jpgQuality');
  const downloadJpg = document.getElementById('downloadJpg');
  const exportProgress = document.getElementById('exportProgress');
  const exportBar = document.getElementById('exportBar');

  function openJpgPanel() {
    jpgPanel.hidden = false;
    exportProgress.textContent = 'সব ৯টি পৃষ্ঠা নিয়ে A0 poster তৈরির জন্য প্রস্তুত';
    exportBar.style.width = '0%';
  }
  function closeJpgPanel() {
    if (!downloadJpg.disabled) jpgPanel.hidden = true;
  }
  jpgBtn.addEventListener('click', openJpgPanel);
  document.getElementById('closeJpgPanel').addEventListener('click', closeJpgPanel);
  document.getElementById('cancelJpg').addEventListener('click', closeJpgPanel);
  jpgPanel.addEventListener('click', e => { if (e.target === jpgPanel) closeJpgPanel(); });

  function downloadBlob(blob, filename) {
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = filename;
    document.body.appendChild(a);
    a.click();
    a.remove();
    setTimeout(() => URL.revokeObjectURL(url), 30000);
  }

  function canvasToBlob(canvas, quality) {
    return new Promise((resolve, reject) => {
      canvas.toBlob(blob => blob ? resolve(blob) : reject(new Error('JPG encoding failed')), 'image/jpeg', quality);
    });
  }

  async function ensureExporter() {
    if (window.html2canvas) return;
    throw new Error('JPG exporter library load হয়নি। Internet connection চালু রেখে page reload করুন।');
  }

  function buildA0Poster() {
    const old = document.getElementById('a0CompositeStage');
    if (old) old.remove();

    const stage = document.createElement('section');
    stage.id = 'a0CompositeStage';
    stage.className = 'a0-composite-stage';
    stage.setAttribute('aria-hidden', 'true');

    const heading = document.createElement('header');
    heading.className = 'a0-composite-heading';
    heading.innerHTML = '<b>হৃদ্‌স্বাস্থ্য উন্নয়নের দৈনিক রুটিন ও খাদ্য পরিকল্পনা</b><span>সম্পূর্ণ ৯-পৃষ্ঠার A0 রেফারেন্স পোস্টার</span>';
    stage.appendChild(heading);

    const grid = document.createElement('div');
    grid.className = 'a0-composite-grid';
    stage.appendChild(grid);

    pages.forEach((page, index) => {
      const sourceArt = page.querySelector('.page-art');
      const cell = document.createElement('article');
      cell.className = 'a0-composite-cell';
      cell.dataset.page = String(index + 1);

      const clone = sourceArt.cloneNode(true);
      clone.classList.add('a0-composite-page-art');
      clone.style.transform = 'none';
      clone.style.left = '0';
      clone.style.top = '0';
      clone.style.boxShadow = 'none';
      cell.appendChild(clone);
      grid.appendChild(cell);
    });

    document.body.appendChild(stage);

    // Scale every complete 210×297 mm ebook page into its A0 grid cell.
    [...stage.querySelectorAll('.a0-composite-cell')].forEach(cell => {
      const art = cell.querySelector('.a0-composite-page-art');
      const naturalWidth = art.offsetWidth;
      const naturalHeight = art.offsetHeight;
      const availableWidth = cell.clientWidth;
      const availableHeight = cell.clientHeight;
      const scale = Math.min(availableWidth / naturalWidth, availableHeight / naturalHeight);
      art.style.transformOrigin = 'top left';
      art.style.transform = `scale(${scale})`;
      art.style.left = `${(availableWidth - naturalWidth * scale) / 2}px`;
      art.style.top = `${(availableHeight - naturalHeight * scale) / 2}px`;
    });

    return stage;
  }

  async function exportCompositeA0(dpi, quality) {
    await ensureExporter();
    await document.fonts.ready;

    exportProgress.textContent = 'সব ৯টি পূর্ণ পৃষ্ঠা A0 layout-এ সাজানো হচ্ছে…';
    exportBar.style.width = '12%';
    const stage = buildA0Poster();
    await new Promise(resolve => requestAnimationFrame(() => requestAnimationFrame(resolve)));

    const targetWidth = Math.round(841 / 25.4 * dpi);
    const targetHeight = Math.round(1189 / 25.4 * dpi);
    const scale = targetWidth / stage.offsetWidth;

    exportProgress.textContent = `সম্পূর্ণ A0 poster ${targetWidth.toLocaleString()} × ${targetHeight.toLocaleString()} px render হচ্ছে…`;
    exportBar.style.width = '28%';

    const canvas = await window.html2canvas(stage, {
      backgroundColor: '#fffdf7',
      scale,
      width: stage.offsetWidth,
      height: stage.offsetHeight,
      windowWidth: stage.offsetWidth,
      windowHeight: stage.offsetHeight,
      scrollX: 0,
      scrollY: 0,
      useCORS: true,
      allowTaint: false,
      logging: false,
      imageTimeout: 30000,
      removeContainer: true,
      onclone: clonedDoc => {
        clonedDoc.querySelectorAll(
          '#terminalLauncher,#terminalDock,#terminalDockBackdrop,#terminalModalShell,#jpgPanel,#legacyControlBridge,' +
          '.terminal-launcher,.terminal-dock,.terminal-dock-backdrop,.terminal-modal-shell,.terminal-modal,.terminal-modal-backdrop,.no-print'
        ).forEach(element => element.remove());

        const clonedStage = clonedDoc.getElementById('a0CompositeStage');
        if (clonedStage) {
          clonedStage.querySelectorAll('.no-print,.terminal-launcher,.terminal-dock,.terminal-modal').forEach(element => element.remove());
          clonedStage.style.position = 'absolute';
          clonedStage.style.left = '0';
          clonedStage.style.top = '0';
          clonedStage.style.visibility = 'visible';
          clonedStage.style.zIndex = '1';
        }
      }
    });
    exportBar.style.width = '82%';

    let output = canvas;
    if (canvas.width !== targetWidth || canvas.height !== targetHeight) {
      output = document.createElement('canvas');
      output.width = targetWidth;
      output.height = targetHeight;
      const ctx = output.getContext('2d', { alpha: false });
      ctx.fillStyle = '#fffdf7';
      ctx.fillRect(0, 0, targetWidth, targetHeight);
      ctx.drawImage(canvas, 0, 0, targetWidth, targetHeight);
    }

    exportProgress.textContent = 'JPG encode ও download প্রস্তুত হচ্ছে…';
    exportBar.style.width = '92%';
    const blob = await canvasToBlob(output, quality);
    downloadBlob(blob, `heart-routine-complete-9-page-A0-${dpi}dpi-${targetWidth}x${targetHeight}.jpg`);

    stage.remove();
    output.width = 1; output.height = 1;
    if (canvas !== output) { canvas.width = 1; canvas.height = 1; }
    exportBar.style.width = '100%';
  }

  downloadJpg.addEventListener('click', async () => {
    const dpi = Number(jpgDpi.value || 300);
    const quality = Number(jpgQuality.value || .98);
    downloadJpg.disabled = true;
    document.body.classList.add('is-exporting');
    suppressTerminalForOutput();
    exportBar.style.width = '2%';

    try {
      await exportCompositeA0(dpi, quality);
      exportProgress.textContent = '✓ সব ৯টি page নিয়ে একটি সম্পূর্ণ A0 JPG download হয়েছে';
    } catch (error) {
      console.error(error);
      const stage = document.getElementById('a0CompositeStage');
      if (stage) stage.remove();
      exportProgress.textContent = `⚠ ${error.message || 'Export ব্যর্থ হয়েছে'} — 240 বা 180 DPI দিয়ে আবার চেষ্টা করুন।`;
    } finally {
      downloadJpg.disabled = false;
      document.body.classList.remove('is-exporting');
      restoreTerminalAfterOutput();
    }
  });


  setPaper(localStorage.getItem('heart-routine-paper') || 'a4');
  try {
    const savedPrintConfig = JSON.parse(localStorage.getItem('ait-pha-print-config') || 'null');
    if (savedPrintConfig?.mode) activePrintConfig = savedPrintConfig;
  } catch (error) {}
})();


// V9 responsive sticky header interactions.
(() => {
  const appHeader = document.getElementById('appHeader');
  const menuToggle = document.getElementById('headerMenuToggle');
  const controls = document.getElementById('headerControls');
  const exerciseMenu = document.getElementById('exerciseMenu');
  const exerciseToggle = document.getElementById('exerciseMenuToggle');
  const progressBar = document.getElementById('headerProgressBar');
  const menuBackdrop = document.getElementById('headerMenuBackdrop');

  if (!appHeader) return;

  const setControlsOpen = (open) => {
    appHeader.classList.toggle('controls-open', open);
    menuToggle?.setAttribute('aria-expanded', String(open));
    document.body.classList.toggle('mobile-tools-open', open && window.innerWidth <= 720);
  };

  const setExerciseOpen = (open) => {
    exerciseMenu?.classList.toggle('is-open', open);
    exerciseToggle?.setAttribute('aria-expanded', String(open));
  };

  menuToggle?.addEventListener('click', (event) => {
    event.stopPropagation();
    setControlsOpen(!appHeader.classList.contains('controls-open'));
  });

  menuBackdrop?.addEventListener('click', () => {
    setExerciseOpen(false);
    setControlsOpen(false);
  });

  exerciseToggle?.addEventListener('click', (event) => {
    event.stopPropagation();
    setExerciseOpen(!exerciseMenu.classList.contains('is-open'));
  });

  document.addEventListener('click', (event) => {
    if (controls && !appHeader.contains(event.target)) setControlsOpen(false);
    if (exerciseMenu && !exerciseMenu.contains(event.target)) setExerciseOpen(false);
  });

  document.addEventListener('keydown', (event) => {
    if (event.key !== 'Escape') return;
    setExerciseOpen(false);
    setControlsOpen(false);
    menuToggle?.focus();
  });

  const updateHeaderState = () => {
    document.body.classList.toggle('header-scrolled', window.scrollY > 24);
    const scrollable = document.documentElement.scrollHeight - window.innerHeight;
    const progress = scrollable > 0 ? Math.min(100, (window.scrollY / scrollable) * 100) : 0;
    if (progressBar) progressBar.style.width = `${progress}%`;
  };

  window.addEventListener('scroll', updateHeaderState, { passive: true });
  window.addEventListener('resize', () => {
    if (window.innerWidth > 1180) setControlsOpen(false);
    if (window.innerWidth > 720) document.body.classList.remove('mobile-tools-open');
  });
  updateHeaderState();
})();



// V99.5 rebuilt floating terminal, grouped command modals and appearance themes.
(() => {
  const root = document.documentElement;
  const launcher = document.getElementById('terminalLauncher');
  const dock = document.getElementById('terminalDock');
  const dockBackdrop = document.getElementById('terminalDockBackdrop');
  const dockClose = document.getElementById('terminalDockClose');
  const shell = document.getElementById('terminalModalShell');
  const modalBackdrop = document.getElementById('terminalModalBackdrop');
  const activeThemeLabel = document.getElementById('terminalActiveTheme');
  if (!launcher || !dock || !shell) return;

  const themes = {'dark-glass':'Dark Glass','classic-light':'Classic Light',sapphire:'Sapphire',emerald:'Emerald','royal-purple':'Royal Purple','carbon-oled':'Carbon OLED',crimson:'Crimson',coffee:'Coffee',aurora:'Aurora'};
  let lastFocus = launcher;
  const pages = () => [...document.querySelectorAll('.paper-page')];

  function setDock(open){ dock.classList.toggle('open',open); dockBackdrop?.classList.toggle('open',open); launcher.setAttribute('aria-expanded',String(open)); dock.setAttribute('aria-hidden',String(!open)); document.body.classList.toggle('terminal-ui-open',open || shell.classList.contains('open')); if(open) dockClose?.focus(); }
  function closeModal(){ const open=shell.querySelector('.terminal-modal:not([hidden])'); if(open) open.hidden=true; shell.classList.remove('open'); shell.setAttribute('aria-hidden','true'); document.body.classList.toggle('terminal-ui-open',dock.classList.contains('open')); lastFocus?.focus?.(); }
  function openModal(id){ const modal=document.getElementById(id); if(!modal)return; lastFocus=document.activeElement; shell.querySelectorAll('.terminal-modal').forEach(m=>m.hidden=true); modal.hidden=false; shell.classList.add('open'); shell.setAttribute('aria-hidden','false'); setDock(false); requestAnimationFrame(()=>modal.querySelector('button,[href],input,select')?.focus()); }
  function clickId(id){ document.getElementById(id)?.click(); }
  function syncZoom(){ const value=document.getElementById('zoomLabel')?.textContent || '100%'; const out=document.getElementById('terminalZoomLabel'); if(out)out.textContent=value; }
  function syncPaper(){ const value=document.getElementById('paperSize')?.value || document.body.dataset.paper || 'a4'; document.querySelectorAll('[data-paper-command]').forEach(b=>b.classList.toggle('active',b.dataset.paperCommand===value)); }
  function applyTheme(value,persist=true){ const selected=themes[value]?value:'dark-glass'; root.dataset.theme=selected; root.style.colorScheme=selected==='classic-light'?'light':'dark'; document.querySelectorAll('[data-theme-value]').forEach(b=>{const on=b.dataset.themeValue===selected;b.classList.toggle('active',on);b.setAttribute('aria-pressed',String(on));}); if(activeThemeLabel)activeThemeLabel.textContent=`${themes[selected]} active`; if(persist)localStorage.setItem('heart-routine-theme',selected); syncExerciseTheme(selected); }
  function nearestPageIndex(){ const y=window.scrollY+window.innerHeight*.35; let best=0,dist=Infinity; pages().forEach((p,i)=>{const d=Math.abs(p.offsetTop-y);if(d<dist){dist=d;best=i;}});return best; }
  function goPage(delta){ const list=pages(); if(!list.length)return; const i=Math.max(0,Math.min(list.length-1,nearestPageIndex()+delta)); list[i].scrollIntoView({behavior:'smooth',block:'start'}); }


  const exerciseShell=document.getElementById('terminalExerciseShell');
  const exerciseFrame=document.getElementById('terminalExerciseFrame');
  const exerciseTitle=document.getElementById('terminalExerciseTitle');
  class ReusableWorkspaceNavigator {
    constructor({shell,frame,breadcrumb,backButton,forwardButton,homeButton,terminalButton,closeButton,onHome,onTerminal,onClose,onThemeSync}) {
      this.shell=shell;
      this.frame=frame;
      this.breadcrumb=breadcrumb;
      this.backButton=backButton;
      this.forwardButton=forwardButton;
      this.homeButton=homeButton;
      this.terminalButton=terminalButton;
      this.closeButton=closeButton;
      this.onHome=onHome;
      this.onTerminal=onTerminal;
      this.onClose=onClose;
      this.onThemeSync=onThemeSync;
      this.history=[];
      this.index=-1;
      this.bind();
      this.update();
    }

    bind(){
      this.backButton?.addEventListener('click',()=>this.back());
      this.forwardButton?.addEventListener('click',()=>this.forward());
      this.homeButton?.addEventListener('click',()=>this.home());
      this.terminalButton?.addEventListener('click',()=>this.onTerminal?.());
      this.closeButton?.addEventListener('click',()=>this.close());
      this.breadcrumb?.addEventListener('click',event=>{
        const button=event.target.closest('[data-workspace-history-index]');
        if(!button)return;
        this.go(Number(button.dataset.workspaceHistoryIndex));
      });
    }

    open(state,{replace=false}={}){
      const normalized=this.normalize(state);
      if(replace&&this.index>=0){
        this.history[this.index]=normalized;
      }else{
        this.history=this.history.slice(0,this.index+1);
        this.history.push(normalized);
        this.index=this.history.length-1;
      }
      this.render();
    }

    normalize(state){
      return {
        src:String(state.src||'about:blank'),
        title:String(state.title||'Workspace'),
        breadcrumb:Array.isArray(state.breadcrumb)&&state.breadcrumb.length
          ? state.breadcrumb.map(item=>String(item))
          : ['Workspace',String(state.title||'Workspace')],
        parentModal:String(state.parentModal||'toolsModal'),
        parentLabel:String(state.parentLabel||'Tools')
      };
    }

    render(){
      const state=this.history[this.index];
      if(!state)return;
      this.frame.dataset.parentModal=state.parentModal;
      this.frame.dataset.parentLabel=state.parentLabel;
      this.frame.src=state.src;
      this.shell.classList.add('open');
      this.shell.setAttribute('aria-hidden','false');
      document.body.classList.add('terminal-ui-open');
      this.renderBreadcrumb();
      this.update();
      this.frame.addEventListener('load',()=>this.onThemeSync?.(),{once:true});
    }

    renderBreadcrumb(){
      const state=this.history[this.index];
      if(!this.breadcrumb||!state)return;
      this.breadcrumb.innerHTML=state.breadcrumb.map((label,index)=>{
        const isLast=index===state.breadcrumb.length-1;
        const historyIndex=this.findHistoryIndexForCrumb(state.breadcrumb,index);
        return `<span class="terminal-workspace-breadcrumb__item ${isLast?'is-current':''}">
          ${index?'<i aria-hidden="true">›</i>':''}
          <button type="button" ${isLast||historyIndex<0?'disabled':''} data-workspace-history-index="${historyIndex}">${this.escape(label)}</button>
        </span>`;
      }).join('');
    }

    findHistoryIndexForCrumb(crumbs,crumbIndex){
      const target=crumbs.slice(0,crumbIndex+1).join(' / ');
      for(let i=this.index;i>=0;i--){
        if(this.history[i].breadcrumb.join(' / ')===target)return i;
      }
      return -1;
    }

    back(){
      if(this.index<=0)return;
      this.index--;
      this.render();
    }

    forward(){
      if(this.index>=this.history.length-1)return;
      this.index++;
      this.render();
    }

    go(index){
      if(!Number.isInteger(index)||index<0||index>=this.history.length)return;
      this.index=index;
      this.render();
    }

    home(){
      this.clear();
      this.onHome?.();
    }

    close(){
      this.clear();
      this.onClose?.();
    }

    clear(){
      this.history=[];
      this.index=-1;
      this.frame.src='about:blank';
      this.shell.classList.remove('open');
      this.shell.setAttribute('aria-hidden','true');
      document.body.classList.remove('terminal-ui-open');
      this.renderBreadcrumb();
      this.update();
    }

    update(){
      if(this.backButton)this.backButton.disabled=this.index<=0;
      if(this.forwardButton)this.forwardButton.disabled=this.index<0||this.index>=this.history.length-1;
    }

    escape(value){
      const div=document.createElement('div');
      div.textContent=value;
      return div.innerHTML;
    }
  }

  function syncExerciseTheme(theme=root.dataset.theme||'dark-glass'){ if(exerciseFrame?.contentWindow) exerciseFrame.contentWindow.postMessage({type:'ait-pha-theme',theme},'*'); }
  const workspaceNavigator=new ReusableWorkspaceNavigator({
    shell:exerciseShell,
    frame:exerciseFrame,
    breadcrumb:document.getElementById('terminalWorkspaceBreadcrumb'),
    backButton:document.getElementById('terminalWorkspaceBack'),
    forwardButton:document.getElementById('terminalWorkspaceForward'),
    homeButton:document.getElementById('terminalWorkspaceHome'),
    terminalButton:document.getElementById('terminalWorkspaceTerminal'),
    closeButton:document.getElementById('terminalExerciseClose'),
    onHome:()=>{setDock(true);},
    onTerminal:()=>{setDock(true);},
    onClose:()=>{},
    onThemeSync:()=>syncExerciseTheme()
  });

  function openExercise(button){
    if(!exerciseShell||!exerciseFrame)return;
    closeModal();
    const title=button.dataset.exerciseTitle||'Tool Workspace';
    const kicker=button.dataset.workspaceKicker||'Tools / Workspace';
    const breadcrumb=kicker.split('/').map(part=>part.trim()).filter(Boolean);
    workspaceNavigator.open({
      src:button.dataset.exerciseSrc,
      title,
      breadcrumb:[...breadcrumb,title],
      parentModal:button.dataset.parentModal||(button.closest('#plannerModal')?'plannerModal':button.closest('#calculatorModal')?'calculatorModal':'exerciseModal'),
      parentLabel:button.dataset.parentLabel||(button.closest('#plannerModal')?'AIT Planner':button.closest('#calculatorModal')?'Calculator':'Exercise')
    });
  }

  function closeExercise(){
    workspaceNavigator.back();
  }

  function exitExercise(){
    workspaceNavigator.close();
  }

  function openPlannerDataModule(moduleId,foodId='',foodMode=''){
    const isFood=moduleId==='foodsModule';
    const isProfile=moduleId==='profilesModule';
    if(!isFood&&!isProfile)return;

    closeModal();

    let src='';
    let title='';
    let breadcrumb=[];

    if(isFood){
      const query=foodId
        ? `?edit=${encodeURIComponent(foodId)}`
        : foodMode==='create'
          ? '?create=1'
          : '';
      src=`data-center/food/index.html${query}`;
      title=foodId?'Edit Food':'Food Data Workspace';
      breadcrumb=['Workspace','Data Center','Data','Food',...(foodId?['Edit']:foodMode==='create'?['Create']:[])];
    }else{
      src='planner/health-planner/index.html?module=profilesModule';
      title='Profile List';
      breadcrumb=['Workspace','Data Center','Data','Profile'];
    }

    workspaceNavigator.open({
      src,
      title,
      breadcrumb,
      parentModal:'dataManagerModal',
      parentLabel:'Data'
    });
  }

  function downloadPlannerBackup(){
    const keys=['ait-pha-health-planner-v4','ait-pha-health-planner-v3','heart-routine-theme'];
    const payload={exportedAt:new Date().toISOString(),version:'99.24',storage:{}};
    keys.forEach(key=>{const value=localStorage.getItem(key);if(value!==null)payload.storage[key]=value;});
    const blob=new Blob([JSON.stringify(payload,null,2)],{type:'application/json'});
    const url=URL.createObjectURL(blob);
    const link=document.createElement('a');
    link.href=url;
    link.download=`ait-health-planner-backup-${new Date().toISOString().slice(0,10)}.json`;
    link.click();
    URL.revokeObjectURL(url);
  }

  function importPlannerBackup(file){
    if(!file)return;
    const reader=new FileReader();
    reader.onload=()=>{
      try{
        const payload=JSON.parse(String(reader.result||''));
        if(!payload.storage||typeof payload.storage!=='object')throw new Error('Invalid backup format');
        Object.entries(payload.storage).forEach(([key,value])=>localStorage.setItem(key,String(value)));
        alert('Planner data imported successfully.');
        location.reload();
      }catch(error){alert(`Import failed: ${error.message}`);}
    };
    reader.readAsText(file);
  }

  shell.addEventListener('click',event=>{
    const plannerButton=event.target.closest('[data-planner-module]');
    if(plannerButton){
      event.preventDefault();
      event.stopPropagation();
      const moduleId=plannerButton.getAttribute('data-planner-module');
      openPlannerDataModule(moduleId);
      return;
    }
    const actionButton=event.target.closest('[data-workspace-action]');
    if(!actionButton)return;
    event.preventDefault();
    const action=actionButton.dataset.workspaceAction;
    if(action==='backup'){downloadPlannerBackup();return;}
    if(action==='sync'){localStorage.setItem('ait-health-planner-last-sync',new Date().toISOString());alert('Local planner data synchronized.');return;}
    if(action==='import'){document.getElementById('terminalDataImportFile')?.click();return;}
    if(action==='poster'){document.documentElement.dataset.printMode='poster';closeModal();setTimeout(()=>{window.print();delete document.documentElement.dataset.printMode;},80);}
  });

  document.getElementById('terminalDataImportFile')?.addEventListener('change',event=>{
    importPlannerBackup(event.target.files?.[0]);
    event.target.value='';
  });

  window.addEventListener('message',event=>{
    if(event.data?.type==='ait-pha-workspace-breadcrumb'){
      workspaceNavigator.home();
      openModal(event.data.target||'workspaceModal');
    }
  });

  window.addEventListener('message',event=>{
    if(event.data?.type==='ait-pha-open-terminal')setDock(true);
  });

  window.addEventListener('message',event=>{
    if(event.data?.type==='ait-pha-open-data-center-food'){
      openPlannerDataModule('foodsModule',event.data.foodId||'',event.data.mode||'');
    }
    if(event.data?.type==='ait-pha-food-data-updated'){
      try{exerciseFrame.contentWindow?.postMessage({type:'ait-pha-refresh-food-data'},'*')}catch(error){}
    }
  });

  window.addEventListener('message',e=>{
    if(e.data?.type!=='ait-pha-open-tool'||!e.data.src)return;
    exerciseTitle.textContent=e.data.title||'Tool Workspace';
    exerciseFrame.dataset.parentModal='plannerModal';
    exerciseFrame.dataset.parentLabel='Planner';

    exerciseFrame.src=e.data.src;
    exerciseFrame.addEventListener('load',()=>syncExerciseTheme(),{once:true});
  });


  class DynamicTerminalController{
    constructor(schema,mount){this.schema=schema||{menu:[]};this.mount=mount;this.stack=[];this.bind();this.render();}
    bind(){this.mount?.addEventListener('click',e=>{const back=e.target.closest('[data-dynamic-terminal-back]');if(back){e.preventDefault();this.back();return;}const btn=e.target.closest('[data-dynamic-terminal-item]');if(!btn)return;e.preventDefault();const item=this.find(btn.dataset.dynamicTerminalItem);if(item)this.activate(item);});}
    render(items=this.schema.menu||[],title='Terminal'){
      if(!this.mount)return;
      this.mount.innerHTML=`${this.stack.length?`<button class="dynamic-terminal-back" data-dynamic-terminal-back type="button">← ${this.escape(title)}</button>`:''}${items.map(item=>`<button class="terminal-group-card" data-dynamic-terminal-item="${this.escape(item.id)}" type="button"><span class="terminal-group-card__icon">${this.escape(item.icon||'•')}</span><span><b>${this.escape(item.label||item.id)}</b><small>${this.escape(item.description||'')}</small></span><i>${item.children?.length?'→':'↗'}</i></button>`).join('')}`;
    }
    activate(item){
      if(item.children?.length){this.stack.push(item);this.render(item.children,item.label);return;}
      const a=item.action||{};
      if(a.type==='workspace'){workspaceNavigator.open({src:a.route,title:a.title||item.label,breadcrumb:a.breadcrumb||[...this.stack.map(x=>x.label),item.label],parentModal:'toolsModal',parentLabel:this.stack.at(-1)?.label||'Terminal'});setDock(false);return;}
      if(a.type==='modal'){openModal(a.modalId);return;}
      if(a.type==='command'){
        if(a.command==='ebook-export-csv'){window.AITEbookCsvBackupManager?.exportToCsv();setDock(false);}
        if(a.command==='ebook-import-csv'){window.AITEbookCsvBackupManager?.openImportPicker();setDock(false);}
        if(a.command==='backup')downloadPlannerBackup();
        if(a.command==='sync'){localStorage.setItem('ait-health-planner-last-sync',new Date().toISOString());alert('Local planner data synchronized.');}
        if(a.command==='import')document.getElementById('terminalDataImportFile')?.click();
        if(a.command==='print'){setDock(false);setTimeout(()=>clickId('printBtn'),80);}
        if(a.command==='image'){setDock(false);setTimeout(()=>clickId('jpgBtn'),80);}
        if(a.command==='poster'){document.documentElement.dataset.printMode='poster';setDock(false);setTimeout(()=>{window.print();delete document.documentElement.dataset.printMode;},80);}
      }
    }
    back(){this.stack.pop();const p=this.stack.at(-1);this.render(p?.children||this.schema.menu||[],p?.label||'Terminal');}
    find(id,items=this.schema.menu||[]){for(const item of items){if(item.id===id)return item;const found=item.children&&this.find(id,item.children);if(found)return found;}return null;}
    escape(v){const d=document.createElement('div');d.textContent=String(v??'');return d.innerHTML;}
  }
  const dynamicTerminalController=new DynamicTerminalController(window.AIT_TERMINAL_SCHEMA,document.getElementById('dynamicTerminalMenuMount'));

  launcher.addEventListener('click',()=>setDock(!dock.classList.contains('open')));
  document.getElementById('terminalToolsTrigger')?.addEventListener('click',event=>{event.preventDefault();event.stopPropagation();openModal('toolsModal');}); dockClose?.addEventListener('click',()=>setDock(false)); dockBackdrop?.addEventListener('click',()=>setDock(false));
  document.addEventListener('click',event=>{
    const modalTrigger=event.target.closest('[data-open-terminal-modal]');
    if(!modalTrigger)return;
    event.preventDefault();
    event.stopPropagation();
    const modalId=modalTrigger.getAttribute('data-open-terminal-modal');
    if(modalId)openModal(modalId);
  });
  document.querySelectorAll('[data-close-terminal-modal]').forEach(b=>b.addEventListener('click',closeModal)); modalBackdrop?.addEventListener('click',closeModal);
  document.querySelectorAll('[data-theme-value]').forEach(b=>b.addEventListener('click',()=>applyTheme(b.dataset.themeValue)));
  document.querySelectorAll('[data-paper-command]').forEach(b=>b.addEventListener('click',()=>{const s=document.getElementById('paperSize');if(s){s.value=b.dataset.paperCommand;s.dispatchEvent(new Event('change',{bubbles:true}));}syncPaper();}));
  shell.addEventListener('click',e=>{const pageButton=e.target.closest('[data-page-index]');if(pageButton){const list=pages();const index=Number(pageButton.dataset.pageIndex);if(Number.isInteger(index)&&list[index]){closeModal();setTimeout(()=>list[index].scrollIntoView({behavior:'smooth',block:'start'}),80);}return;}const b=e.target.closest('[data-command]');if(!b)return;const c=b.dataset.command;if(c==='print'){closeModal();setTimeout(()=>clickId('printBtn'),80);}if(c==='image'){closeModal();setTimeout(()=>clickId('jpgBtn'),80);}if(c==='top')window.scrollTo({top:0,behavior:'smooth'});if(c==='bottom')window.scrollTo({top:document.documentElement.scrollHeight,behavior:'smooth'});if(c==='zoom-in'){clickId('zoomIn');setTimeout(syncZoom,0);}if(c==='zoom-out'){clickId('zoomOut');setTimeout(syncZoom,0);}if(c==='zoom-reset'){clickId('resetZoom');setTimeout(syncZoom,0);}if(c==='previous')goPage(-1);if(c==='next')goPage(1);});
  document.getElementById('terminalFocusMode')?.addEventListener('change',e=>document.body.classList.toggle('terminal-focus-mode',e.target.checked));
  document.getElementById('terminalCompactHeader')?.addEventListener('change',e=>document.body.classList.toggle('terminal-compact-header',e.target.checked));
  document.getElementById('terminalFullscreen')?.addEventListener('change',async e=>{try{if(e.target.checked&&!document.fullscreenElement)await document.documentElement.requestFullscreen();else if(!e.target.checked&&document.fullscreenElement)await document.exitFullscreen();}catch(err){e.target.checked=!!document.fullscreenElement;}});
  document.addEventListener('fullscreenchange',()=>{const c=document.getElementById('terminalFullscreen');if(c)c.checked=!!document.fullscreenElement;});
  document.addEventListener('keydown',e=>{if(e.key!=='Escape')return;if(exerciseShell?.classList.contains('open'))exitExercise();else if(shell.classList.contains('open'))closeModal();else if(dock.classList.contains('open')){setDock(false);launcher.focus();}});
  window.addEventListener('beforeprint',()=>{setDock(false);closeModal();});
  document.getElementById('paperSize')?.addEventListener('change',syncPaper); document.getElementById('zoomIn')?.addEventListener('click',()=>setTimeout(syncZoom,0)); document.getElementById('zoomOut')?.addEventListener('click',()=>setTimeout(syncZoom,0)); document.getElementById('resetZoom')?.addEventListener('click',()=>setTimeout(syncZoom,0));
  applyTheme(localStorage.getItem('heart-routine-theme')||'dark-glass',false); syncPaper(); syncZoom();
})();


// V99.6 emergency terminal visibility guard.
document.addEventListener('DOMContentLoaded', function () {
  var launcher = document.getElementById('terminalLauncher');
  if (!launcher) return;
  launcher.hidden = false;
  launcher.removeAttribute('hidden');
  launcher.style.setProperty('display','flex','important');
  launcher.style.setProperty('visibility','visible','important');
  launcher.style.setProperty('opacity','1','important');
  launcher.style.setProperty('z-index','2147483647','important');
  launcher.setAttribute('title','Open Workspace, Navigation, Tools, Interaction and Appearance terminal');
});
