(function defineAswEbookComponent(global, document) {
  'use strict';

  class AswEbookComponent {
    constructor(options = {}) {
      this.root = this.resolveElement(options.root);
      this.mount = this.resolveElement(options.mount) || this.root?.querySelector('[data-asw-ebook-mount]');
      this.status = this.root?.querySelector('[data-asw-ebook-status]') || null;
      this.storageKey = String(options.storageKey || 'asw-starter:ebook-document');
      this.onActivity = typeof options.onActivity === 'function' ? options.onActivity : () => {};
      this.onNotify = typeof options.onNotify === 'function' ? options.onNotify : () => {};
      this.state = this.normalize(this.load());
      this.activePageId = this.state.pages[0].id;
      this.printStage = null;
      this.printActive = false;
      this.dynamicStyle = document.createElement('style');
      this.dynamicStyle.id = 'aswEbookComponentPrintRule';
      this.dynamicStyle.textContent = '@media print { @page { size: A4 portrait; margin: 0; } }';
      document.head.appendChild(this.dynamicStyle);
      this.bind();
      this.render();
    }

    resolveElement(value) {
      if (value instanceof Element) return value;
      return typeof value === 'string' ? document.querySelector(value) : null;
    }

    createId(prefix) {
      const suffix = global.crypto?.randomUUID?.() || `${Date.now()}-${Math.random().toString(16).slice(2)}`;
      return `${prefix}-${suffix}`;
    }

    emptyCard() {
      return { id: this.createId('ebook-card'), eyebrow: '', title: '', body: '' };
    }

    emptyPanel() {
      return {
        id: this.createId('ebook-panel'),
        number: '',
        title: '',
        cards: [this.emptyCard(), this.emptyCard(), this.emptyCard()]
      };
    }

    emptyPage() {
      return {
        id: this.createId('ebook-page'),
        chapter: '',
        title: '',
        subtitle: '',
        folioTitle: '',
        panels: [this.emptyPanel()]
      };
    }

    emptyDocument() {
      return { schemaVersion: 1, title: '', pages: [this.emptyPage()] };
    }

    normalize(input) {
      const source = input && typeof input === 'object' && !Array.isArray(input) ? input : {};
      const pages = Array.isArray(source.pages) ? source.pages.map((page) => this.normalizePage(page)).filter(Boolean) : [];
      return {
        schemaVersion: 1,
        title: this.clean(source.title, 240),
        pages: pages.length ? pages : [this.emptyPage()]
      };
    }

    normalizePage(input) {
      if (!input || typeof input !== 'object') return null;
      const panels = Array.isArray(input.panels) ? input.panels.map((panel) => this.normalizePanel(panel)).filter(Boolean) : [];
      return {
        id: this.clean(input.id, 140) || this.createId('ebook-page'),
        chapter: this.clean(input.chapter, 120),
        title: this.clean(input.title, 240),
        subtitle: this.clean(input.subtitle, 420),
        folioTitle: this.clean(input.folioTitle, 180),
        panels: panels.length ? panels : [this.emptyPanel()]
      };
    }

    normalizePanel(input) {
      if (!input || typeof input !== 'object') return null;
      const cards = Array.isArray(input.cards) ? input.cards.map((card) => this.normalizeCard(card)).filter(Boolean) : [];
      return {
        id: this.clean(input.id, 140) || this.createId('ebook-panel'),
        number: this.clean(input.number, 24),
        title: this.clean(input.title, 220),
        cards: cards.length ? cards : [this.emptyCard()]
      };
    }

    normalizeCard(input) {
      if (!input || typeof input !== 'object') return null;
      return {
        id: this.clean(input.id, 140) || this.createId('ebook-card'),
        eyebrow: this.clean(input.eyebrow, 80),
        title: this.clean(input.title, 180),
        body: this.clean(input.body, 600)
      };
    }

    clean(value, maxLength = 240) {
      return String(value ?? '').replace(/\u00a0/g, ' ').trim().slice(0, maxLength);
    }

    load() {
      try {
        const raw = global.localStorage.getItem(this.storageKey);
        return raw ? JSON.parse(raw) : null;
      } catch (error) {
        return null;
      }
    }

    save(label = '', detail = '') {
      try {
        global.localStorage.setItem(this.storageKey, JSON.stringify(this.state));
      } catch (error) {
        this.onNotify('eBook could not be saved', error.message, true);
      }
      if (label) this.onActivity(label, detail);
      global.dispatchEvent(new CustomEvent('asw:ebook:changed', { detail: this.summary() }));
      this.renderStatus();
    }

    bind() {
      if (!this.root || !this.mount) return;
      this.root.addEventListener('click', (event) => this.handleClick(event));
      this.root.addEventListener('input', (event) => this.handleInput(event));
      this.root.addEventListener('keydown', (event) => this.handleKeydown(event));
      this.root.addEventListener('paste', (event) => this.handlePaste(event));
      global.addEventListener('beforeprint', () => {
        if (this.printActive) document.documentElement.classList.add('asw-print-preparing');
      });
      global.addEventListener('afterprint', () => this.cleanupPrint());
    }

    handleClick(event) {
      const target = event.target instanceof Element ? event.target : null;
      if (!target) return;
      const action = target.closest('[data-asw-ebook-action]');
      if (action) {
        event.preventDefault();
        this.runAction(action.dataset.aswEbookAction, action);
        return;
      }
      const page = target.closest('[data-asw-ebook-page-id]');
      if (page) this.setActivePage(page.dataset.aswEbookPageId);
    }

    handleInput(event) {
      const field = event.target instanceof Element ? event.target.closest('[data-asw-ebook-field]') : null;
      if (!field) return;
      const page = this.pageById(field.dataset.aswEbookPageId);
      if (!page) return;
      const value = this.clean(field.textContent, field.dataset.aswEbookField === 'card-body' ? 600 : 420);
      const panel = page.panels.find((item) => item.id === field.dataset.aswEbookPanelId);
      const card = panel?.cards.find((item) => item.id === field.dataset.aswEbookCardId);
      const key = field.dataset.aswEbookField;
      if (['chapter', 'title', 'subtitle', 'folioTitle'].includes(key)) page[key] = value;
      if (panel && key === 'panel-number') panel.number = value;
      if (panel && key === 'panel-title') panel.title = value;
      if (card && key === 'card-eyebrow') card.eyebrow = value;
      if (card && key === 'card-title') card.title = value;
      if (card && key === 'card-body') card.body = value;
      this.save();
    }

    handleKeydown(event) {
      const field = event.target instanceof Element ? event.target.closest('[data-asw-ebook-field]') : null;
      if (!field) return;
      if (event.key === 'Enter' && field.dataset.aswEbookField !== 'card-body') event.preventDefault();
    }

    handlePaste(event) {
      const field = event.target instanceof Element ? event.target.closest('[data-asw-ebook-field]') : null;
      if (!field) return;
      event.preventDefault();
      this.insertPlainText(event.clipboardData?.getData('text/plain') || '');
    }

    insertPlainText(text) {
      const selection = global.getSelection?.();
      if (!selection?.rangeCount) return;
      const range = selection.getRangeAt(0);
      range.deleteContents();
      const node = document.createTextNode(text);
      range.insertNode(node);
      range.setStartAfter(node);
      range.collapse(true);
      selection.removeAllRanges();
      selection.addRange(range);
      node.parentElement?.dispatchEvent(new Event('input', { bubbles: true }));
    }

    runAction(action, button) {
      const handlers = {
        'add-page': () => this.addPage(),
        'add-panel': () => this.addPanel(),
        'add-card': () => this.addCard(),
        reset: () => this.reset(),
        print: () => this.print(),
        'remove-page': () => this.removePage(button.dataset.aswEbookPageId),
        'remove-panel': () => this.removePanel(button.dataset.aswEbookPageId, button.dataset.aswEbookPanelId),
        'remove-card': () => this.removeCard(button.dataset.aswEbookPageId, button.dataset.aswEbookPanelId, button.dataset.aswEbookCardId)
      };
      handlers[action]?.();
    }

    pageById(id = this.activePageId) {
      return this.state.pages.find((page) => page.id === id) || this.state.pages[0];
    }

    setActivePage(id) {
      if (!this.state.pages.some((page) => page.id === id)) return;
      this.activePageId = id;
      this.mount.querySelectorAll('[data-asw-ebook-page-id]').forEach((page) => {
        page.classList.toggle('asw-ebook-is-active', page.dataset.aswEbookPageId === id);
      });
      this.renderStatus();
    }

    addPage() {
      const page = this.emptyPage();
      this.state.pages.push(page);
      this.activePageId = page.id;
      this.save('eBook page added', `Page ${this.state.pages.length}`);
      this.render();
      this.onNotify('Page added', `Empty page ${this.state.pages.length} is ready.`);
    }

    addPanel() {
      const page = this.pageById();
      page.panels.push(this.emptyPanel());
      this.save('eBook panel added', `Page ${this.pageNumber(page.id)}`);
      this.render();
      this.onNotify('Panel added', 'The active eBook page has a new empty panel.');
    }

    addCard() {
      const page = this.pageById();
      const panel = page.panels[page.panels.length - 1] || this.emptyPanel();
      if (!page.panels.length) page.panels.push(panel);
      panel.cards.push(this.emptyCard());
      this.save('eBook card added', `Page ${this.pageNumber(page.id)}`);
      this.render();
      this.onNotify('Card added', 'A new card was added to the last panel.');
    }

    removePage(id) {
      if (this.state.pages.length === 1) {
        this.state.pages = [this.emptyPage()];
        this.activePageId = this.state.pages[0].id;
      } else {
        this.state.pages = this.state.pages.filter((page) => page.id !== id);
        this.activePageId = this.state.pages[0].id;
      }
      this.save('eBook page removed');
      this.render();
    }

    removePanel(pageId, panelId) {
      const page = this.pageById(pageId);
      page.panels = page.panels.filter((panel) => panel.id !== panelId);
      if (!page.panels.length) page.panels = [this.emptyPanel()];
      this.save('eBook panel removed', `Page ${this.pageNumber(page.id)}`);
      this.render();
    }

    removeCard(pageId, panelId, cardId) {
      const page = this.pageById(pageId);
      const panel = page.panels.find((item) => item.id === panelId);
      if (!panel) return;
      panel.cards = panel.cards.filter((card) => card.id !== cardId);
      if (!panel.cards.length) panel.cards = [this.emptyCard()];
      this.save('eBook card removed', `Page ${this.pageNumber(page.id)}`);
      this.render();
    }

    reset() {
      if (!global.confirm('Reset the eBook to one empty template page?')) return;
      this.state = this.emptyDocument();
      this.activePageId = this.state.pages[0].id;
      this.save('eBook reset', 'One empty A4 template page');
      this.render();
      this.onNotify('eBook reset', 'The empty AIT-PHA-style template is ready.');
    }

    summary() {
      const panels = this.state.pages.reduce((total, page) => total + page.panels.length, 0);
      const cards = this.state.pages.reduce((total, page) => total + page.panels.reduce((count, panel) => count + panel.cards.length, 0), 0);
      return { pages: this.state.pages.length, panels, cards, activePage: this.pageNumber(this.activePageId) };
    }

    pageNumber(id) {
      const index = this.state.pages.findIndex((page) => page.id === id);
      return index < 0 ? 1 : index + 1;
    }

    getState() {
      return JSON.parse(JSON.stringify(this.state));
    }

    render() {
      if (!this.mount) return;
      const book = this.element('div', 'asw-ebook-book');
      book.setAttribute('aria-label', 'Editable empty eBook');
      this.state.pages.forEach((page, index) => book.appendChild(this.renderPage(page, index)));
      this.mount.replaceChildren(book);
      this.setActivePage(this.activePageId);
      this.renderStatus();
    }

    renderPage(page, index) {
      const article = this.element('article', 'asw-ebook-page');
      article.dataset.aswEbookPageId = page.id;
      article.setAttribute('aria-label', `eBook page ${index + 1}`);
      article.classList.toggle('asw-ebook-is-active', page.id === this.activePageId);

      const art = this.element('div', 'asw-ebook-page__art');
      const outerFrame = this.element('span', 'asw-ebook-frame asw-ebook-frame--outer');
      const innerFrame = this.element('span', 'asw-ebook-frame asw-ebook-frame--inner');
      outerFrame.setAttribute('aria-hidden', 'true');
      innerFrame.setAttribute('aria-hidden', 'true');

      const content = this.element('div', 'asw-ebook-page__content');
      const header = this.element('header', 'asw-ebook-page-header');
      header.append(
        this.editable('span', 'asw-ebook-page-header__chapter', page.chapter, 'Chapter', 'chapter', page),
        this.editable('h2', 'asw-ebook-page-header__title', page.title, 'Page title', 'title', page),
        this.editable('p', 'asw-ebook-page-header__subtitle', page.subtitle, 'Page subtitle', 'subtitle', page)
      );

      const body = this.element('section', 'asw-ebook-page-body');
      body.setAttribute('aria-label', 'Page body');
      page.panels.forEach((panel) => body.appendChild(this.renderPanel(page, panel)));
      content.append(header, body);

      const footer = this.element('footer', 'asw-ebook-folio');
      footer.append(
        this.editable('span', 'asw-ebook-folio__title', page.folioTitle, 'eBook title', 'folioTitle', page),
        this.textElement('span', `Page ${index + 1} / ${this.state.pages.length}`)
      );

      const remove = this.element('button', 'asw-ebook-page__remove asw-ebook-screen-only');
      remove.type = 'button';
      remove.dataset.aswEbookAction = 'remove-page';
      remove.dataset.aswEbookPageId = page.id;
      remove.setAttribute('aria-label', `Remove page ${index + 1}`);
      remove.textContent = '×';

      art.append(outerFrame, innerFrame, content, footer, remove);
      article.appendChild(art);
      return article;
    }

    renderPanel(page, panel) {
      const section = this.element('section', 'asw-ebook-panel');
      const header = this.element('header', 'asw-ebook-panel__header');
      header.append(
        this.editable('span', 'asw-ebook-panel__number', panel.number, '01', 'panel-number', page, panel),
        this.editable('h3', 'asw-ebook-panel__title', panel.title, 'Panel title', 'panel-title', page, panel)
      );
      const remove = this.element('button', 'asw-ebook-panel__remove asw-ebook-screen-only');
      remove.type = 'button';
      remove.dataset.aswEbookAction = 'remove-panel';
      remove.dataset.aswEbookPageId = page.id;
      remove.dataset.aswEbookPanelId = panel.id;
      remove.setAttribute('aria-label', 'Remove panel');
      remove.textContent = '×';
      header.appendChild(remove);

      const grid = this.element('div', 'asw-ebook-card-grid');
      panel.cards.forEach((card) => grid.appendChild(this.renderCard(page, panel, card)));
      section.append(header, grid);
      return section;
    }

    renderCard(page, panel, card) {
      const article = this.element('article', 'asw-ebook-card');
      article.append(
        this.editable('span', 'asw-ebook-card__eyebrow', card.eyebrow, 'Card', 'card-eyebrow', page, panel, card),
        this.editable('h4', 'asw-ebook-card__title', card.title, 'Card title', 'card-title', page, panel, card),
        this.editable('p', 'asw-ebook-card__body', card.body, 'Card content', 'card-body', page, panel, card)
      );
      const remove = this.element('button', 'asw-ebook-card__remove asw-ebook-screen-only');
      remove.type = 'button';
      remove.dataset.aswEbookAction = 'remove-card';
      remove.dataset.aswEbookPageId = page.id;
      remove.dataset.aswEbookPanelId = panel.id;
      remove.dataset.aswEbookCardId = card.id;
      remove.setAttribute('aria-label', 'Remove card');
      remove.textContent = '×';
      article.appendChild(remove);
      return article;
    }

    editable(tag, className, value, placeholder, field, page, panel = null, card = null) {
      const element = this.element(tag, className);
      element.textContent = value;
      element.contentEditable = 'plaintext-only';
      element.spellcheck = true;
      element.tabIndex = 0;
      element.setAttribute('role', 'textbox');
      element.setAttribute('aria-label', placeholder);
      element.dataset.placeholder = placeholder;
      element.dataset.aswEbookField = field;
      element.dataset.aswEbookPageId = page.id;
      if (panel) element.dataset.aswEbookPanelId = panel.id;
      if (card) element.dataset.aswEbookCardId = card.id;
      return element;
    }

    element(tag, className = '') {
      const element = document.createElement(tag);
      if (className) element.className = className;
      return element;
    }

    textElement(tag, value, className = '') {
      const element = this.element(tag, className);
      element.textContent = value;
      return element;
    }

    renderStatus() {
      if (!this.status) return;
      const summary = this.summary();
      this.status.textContent = `${summary.pages} page${summary.pages === 1 ? '' : 's'} · ${summary.panels} panel${summary.panels === 1 ? '' : 's'} · ${summary.cards} card${summary.cards === 1 ? '' : 's'} · Page ${summary.activePage} active`;
    }

    print() {
      const externalEvent = new CustomEvent('asw:ebook:print', { cancelable: true, detail: this.summary() });
      global.dispatchEvent(externalEvent);
      this.onActivity('eBook print requested', `${this.state.pages.length} A4 page${this.state.pages.length === 1 ? '' : 's'}`);
      if (externalEvent.defaultPrevented) return;
      if (!this.preparePrint()) {
        this.onNotify('eBook print unavailable', 'The editable eBook page could not be prepared.', true);
        return;
      }
      this.printActive = true;
      document.documentElement.classList.add('asw-ebook-component-print-active', 'asw-print-preparing');
      try {
        global.print();
      } catch (error) {
        this.cleanupPrint();
        this.onNotify('eBook print unavailable', error.message, true);
      }
    }

    preparePrint() {
      this.cleanupPrintStage();
      const source = this.mount?.querySelector('.asw-ebook-book');
      if (!source) return false;
      const stage = this.element('div', 'asw-ebook-workspace asw-ebook-component-print-stage');
      stage.id = 'aswEbookComponentPrintStage';
      const clone = source.cloneNode(true);
      clone.querySelectorAll('[contenteditable]').forEach((field) => {
        field.removeAttribute('contenteditable');
        field.removeAttribute('tabindex');
        field.removeAttribute('role');
      });
      clone.querySelectorAll('.asw-ebook-screen-only').forEach((element) => element.remove());
      stage.appendChild(clone);
      document.body.appendChild(stage);
      this.printStage = stage;
      return true;
    }

    cleanupPrintStage() {
      this.printStage?.remove();
      this.printStage = null;
    }

    cleanupPrint() {
      if (!this.printActive && !this.printStage) return;
      document.documentElement.classList.remove('asw-ebook-component-print-active', 'asw-print-preparing');
      this.cleanupPrintStage();
      this.printActive = false;
    }
  }

  global.ASWEbookComponent = AswEbookComponent;
}(window, document));
