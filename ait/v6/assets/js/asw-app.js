(function bootstrapSoftwareStarter(global, document) {
  'use strict';

  class AswEventBus {
    constructor() {
      this.target = new EventTarget();
    }

    on(name, listener) {
      const handler = (event) => listener(event.detail);
      this.target.addEventListener(name, handler);
      return () => this.target.removeEventListener(name, handler);
    }

    emit(name, detail = {}) {
      this.target.dispatchEvent(new CustomEvent(name, { detail }));
    }
  }

  class AswStorageRepository {
    constructor(namespace) {
      this.namespace = namespace;
      this.prefix = `${namespace}:`;
    }

    get(key, fallback = null) {
      try {
        const raw = global.localStorage.getItem(this.key(key));
        return raw === null ? fallback : JSON.parse(raw);
      } catch (error) {
        return fallback;
      }
    }

    set(key, value) {
      try {
        global.localStorage.setItem(this.key(key), JSON.stringify(value));
        return true;
      } catch (error) {
        return false;
      }
    }

    remove(key) {
      global.localStorage.removeItem(this.key(key));
    }

    key(key) {
      return `${this.prefix}${key}`;
    }

    entries() {
      const result = {};
      for (let index = 0; index < global.localStorage.length; index += 1) {
        const storageKey = global.localStorage.key(index);
        if (!storageKey || !storageKey.startsWith(this.prefix)) continue;
        const shortKey = storageKey.slice(this.prefix.length);
        result[shortKey] = this.get(shortKey, null);
      }
      return result;
    }

    restore(entries) {
      if (!entries || typeof entries !== 'object' || Array.isArray(entries)) {
        throw new TypeError('Backup data is not a valid starter state object.');
      }
      Object.entries(entries).forEach(([key, value]) => {
        if (!/^[a-z0-9._-]+$/i.test(key)) return;
        this.set(key, value);
      });
    }

    stats() {
      let keys = 0;
      let bytes = 0;
      for (let index = 0; index < global.localStorage.length; index += 1) {
        const storageKey = global.localStorage.key(index);
        if (!storageKey || !storageKey.startsWith(this.prefix)) continue;
        const value = global.localStorage.getItem(storageKey) || '';
        keys += 1;
        bytes += new Blob([storageKey, value]).size;
      }
      return { keys, bytes };
    }
  }

  class AswActivityService {
    constructor(repository, eventBus, limit = 100) {
      this.repository = repository;
      this.eventBus = eventBus;
      this.limit = limit;
      this.items = this.repository.get('activity', []);
      if (!Array.isArray(this.items)) this.items = [];
    }

    record(category, label, detail = '') {
      const item = {
        id: global.crypto?.randomUUID?.() || `${Date.now()}-${Math.random().toString(16).slice(2)}`,
        category: String(category || 'app'),
        label: String(label || 'Activity'),
        detail: String(detail || ''),
        timestamp: new Date().toISOString()
      };
      this.items.unshift(item);
      this.items = this.items.slice(0, this.limit);
      this.persist();
      return item;
    }

    clear() {
      this.items = [];
      this.persist();
    }

    list() {
      return [...this.items];
    }

    persist() {
      this.repository.set('activity', this.items);
      this.eventBus.emit('activity:changed', { items: this.list() });
    }
  }

  class AswAppearanceManager {
    constructor(config, repository, activity, eventBus) {
      this.config = config;
      this.repository = repository;
      this.activity = activity;
      this.eventBus = eventBus;
      this.state = Object.assign({ theme: 'dark-glass', font: 'system', scale: 100 }, repository.get('appearance', {}));
      this.normalize();
      this.apply(false);
    }

    normalize() {
      const themeIds = this.config.themes.map((item) => item.id);
      const fontIds = this.config.fonts.map((item) => item.id);
      if (!themeIds.includes(this.state.theme)) this.state.theme = 'dark-glass';
      if (!fontIds.includes(this.state.font)) this.state.font = 'system';
      this.state.scale = Math.min(120, Math.max(85, Number(this.state.scale) || 100));
    }

    apply(emit = true) {
      document.documentElement.dataset.aswTheme = this.state.theme;
      document.documentElement.dataset.aswFont = this.state.font;
      document.documentElement.style.setProperty('--asw-font-scale', String(this.state.scale / 100));
      this.repository.set('appearance', this.state);
      if (emit) this.eventBus.emit('appearance:changed', { ...this.state });
    }

    setTheme(themeId) {
      if (!this.config.themes.some((item) => item.id === themeId)) return;
      this.state.theme = themeId;
      this.apply();
      this.activity.record('appearance', 'Theme changed', this.getThemeLabel());
    }

    setFont(fontId) {
      if (!this.config.fonts.some((item) => item.id === fontId)) return;
      this.state.font = fontId;
      this.apply();
      this.activity.record('appearance', 'Typography changed', this.getFontLabel());
    }

    setScale(scale) {
      this.state.scale = Math.min(120, Math.max(85, Number(scale) || 100));
      this.apply();
      this.activity.record('appearance', 'Typography scale changed', `${this.state.scale}%`);
    }

    applySet(setId) {
      const set = this.config.sets.find((item) => item.id === setId);
      if (!set) return;
      this.state = { theme: set.theme, font: set.font, scale: set.scale };
      this.apply();
      this.activity.record('appearance', 'Appearance set applied', set.label);
    }

    getThemeLabel() {
      return this.config.themes.find((item) => item.id === this.state.theme)?.label || this.state.theme;
    }

    getFontLabel() {
      return this.config.fonts.find((item) => item.id === this.state.font)?.label || this.state.font;
    }

    matchingSetId() {
      return this.config.sets.find((item) => item.theme === this.state.theme && item.font === this.state.font && Number(item.scale) === Number(this.state.scale))?.id || '';
    }
  }

  class AswInteractionManager {
    constructor(repository, activity, eventBus) {
      this.repository = repository;
      this.activity = activity;
      this.eventBus = eventBus;
      this.state = Object.assign({ zoom: 100, density: 'comfortable', focus: false, reduceMotion: false }, repository.get('interaction', {}));
      this.normalize();
      this.apply(false);
      document.addEventListener('fullscreenchange', () => this.eventBus.emit('interaction:changed', { ...this.state, fullscreen: Boolean(document.fullscreenElement) }));
    }

    normalize() {
      this.state.zoom = Math.min(125, Math.max(80, Number(this.state.zoom) || 100));
      if (!['comfortable', 'compact'].includes(this.state.density)) this.state.density = 'comfortable';
      this.state.focus = Boolean(this.state.focus);
      this.state.reduceMotion = Boolean(this.state.reduceMotion);
    }

    apply(emit = true) {
      document.documentElement.style.setProperty('--asw-ui-zoom', String(this.state.zoom / 100));
      document.documentElement.dataset.aswDensity = this.state.density;
      document.documentElement.dataset.aswFocus = String(this.state.focus);
      document.documentElement.dataset.aswReduceMotion = String(this.state.reduceMotion);
      this.repository.set('interaction', this.state);
      if (emit) this.eventBus.emit('interaction:changed', { ...this.state, fullscreen: Boolean(document.fullscreenElement) });
    }

    setZoom(value) {
      this.state.zoom = Math.min(125, Math.max(80, Number(value) || 100));
      this.apply();
      this.activity.record('interaction', 'Interface zoom changed', `${this.state.zoom}%`);
    }

    setDensity(value) {
      if (!['comfortable', 'compact'].includes(value)) return;
      this.state.density = value;
      this.apply();
      this.activity.record('interaction', 'Interface density changed', this.state.density);
    }

    setFocus(enabled) {
      this.state.focus = Boolean(enabled);
      this.apply();
      this.activity.record('interaction', 'Focus mode changed', this.state.focus ? 'Enabled' : 'Disabled');
    }

    setReduceMotion(enabled) {
      this.state.reduceMotion = Boolean(enabled);
      this.apply();
      this.activity.record('interaction', 'Reduced motion changed', this.state.reduceMotion ? 'Enabled' : 'Disabled');
    }

    async toggleFullscreen() {
      try {
        if (document.fullscreenElement) {
          await document.exitFullscreen();
          this.activity.record('interaction', 'Full screen exited');
        } else {
          await document.documentElement.requestFullscreen();
          this.activity.record('interaction', 'Full screen entered');
        }
      } catch (error) {
        this.activity.record('interaction', 'Full screen unavailable', error.message);
      }
    }
  }

  class AswNavigationManager {
    constructor(items, repository, activity, eventBus) {
      this.items = items;
      this.repository = repository;
      this.activity = activity;
      this.eventBus = eventBus;
      const remembered = repository.get('navigation', { current: 'home' });
      const hashTarget = global.location.hash.replace(/^#/, '');
      this.current = this.isValid(hashTarget) ? hashTarget : this.isValid(remembered.current) ? remembered.current : 'home';
      this.history = [this.current];
      this.historyIndex = 0;
      this.show(this.current, false, false);
    }

    isValid(id) {
      return this.items.some((item) => item.id === id);
    }

    show(id, track = true, addHistory = true) {
      if (!this.isValid(id)) return;
      document.querySelectorAll('[data-asw-view]').forEach((view) => {
        view.hidden = view.dataset.aswView !== id;
      });
      this.current = id;
      this.repository.set('navigation', { current: id });
      if (addHistory && this.history[this.historyIndex] !== id) {
        this.history = this.history.slice(0, this.historyIndex + 1);
        this.history.push(id);
        this.historyIndex = this.history.length - 1;
      }
      if (global.location.hash !== `#${id}`) global.history.replaceState(null, '', `#${id}`);
      if (track) this.activity.record('navigation', 'Workspace view opened', this.label(id));
      this.eventBus.emit('navigation:changed', this.status());
      document.getElementById('aswMain')?.focus({ preventScroll: true });
      global.scrollTo({ top: 0, behavior: document.documentElement.dataset.aswReduceMotion === 'true' ? 'auto' : 'smooth' });
    }

    back() {
      if (this.historyIndex <= 0) return;
      this.historyIndex -= 1;
      this.show(this.history[this.historyIndex], true, false);
    }

    forward() {
      if (this.historyIndex >= this.history.length - 1) return;
      this.historyIndex += 1;
      this.show(this.history[this.historyIndex], true, false);
    }

    status() {
      return { current: this.current, canBack: this.historyIndex > 0, canForward: this.historyIndex < this.history.length - 1 };
    }

    label(id = this.current) {
      return this.items.find((item) => item.id === id)?.label || id;
    }
  }

  class AswNotificationService {
    constructor(repository, activity, eventBus, region) {
      this.repository = repository;
      this.activity = activity;
      this.eventBus = eventBus;
      this.region = region;
      this.state = Object.assign({ enabled: true, browser: false, position: 'bottom-right' }, repository.get('notifications', {}));
      if (!['bottom-right', 'top-right'].includes(this.state.position)) this.state.position = 'bottom-right';
      this.apply(false);
    }

    apply(emit = true) {
      if (this.region) this.region.dataset.position = this.state.position;
      this.repository.set('notifications', this.state);
      if (emit) this.eventBus.emit('notification:changed', { ...this.state });
    }

    setEnabled(enabled) {
      this.state.enabled = Boolean(enabled);
      this.apply();
      this.activity.record('notification', 'In-app notifications changed', this.state.enabled ? 'Enabled' : 'Disabled');
    }

    setPosition(position) {
      if (!['bottom-right', 'top-right'].includes(position)) return;
      this.state.position = position;
      this.apply();
      this.activity.record('notification', 'Notification position changed', position);
    }

    async requestBrowserPermission() {
      if (!('Notification' in global)) {
        this.notify('Browser notifications are not supported', 'Use in-app notifications instead.', true);
        this.activity.record('notification', 'Browser notification unavailable');
        return;
      }
      try {
        const permission = await global.Notification.requestPermission();
        this.state.browser = permission === 'granted';
        this.apply();
        this.activity.record('notification', 'Browser notification permission', permission);
        this.notify('Browser notification setting updated', `Permission: ${permission}`, true);
      } catch (error) {
        this.activity.record('notification', 'Browser notification request failed', error.message);
      }
    }

    notify(title, message = '', force = false) {
      if (!force && !this.state.enabled) return;
      if (this.region) {
        const toast = document.createElement('article');
        toast.className = 'asw-toast';
        toast.innerHTML = '<span class="asw-toast__mark" aria-hidden="true"></span><span class="asw-toast__copy"><b></b><small></small></span><button type="button" aria-label="Dismiss notification">×</button>';
        toast.querySelector('b').textContent = title;
        toast.querySelector('small').textContent = message;
        toast.querySelector('button').addEventListener('click', () => toast.remove());
        this.region.appendChild(toast);
        global.setTimeout(() => toast.remove(), 5200);
      }
      if (this.state.browser && 'Notification' in global && global.Notification.permission === 'granted' && document.hidden) {
        new global.Notification(title, { body: message });
      }
    }
  }

  class AswBackupService {
    constructor(config, repository, activity, notification) {
      this.config = config;
      this.repository = repository;
      this.activity = activity;
      this.notification = notification;
    }

    export() {
      const exportedAt = new Date().toISOString();
      this.repository.set('last-backup', exportedAt);
      this.activity.record('backup', 'Starter backup exported', exportedAt);
      const payload = {
        schema: 'asw-software-starter-backup',
        schemaVersion: 1,
        appVersion: this.config.app.version,
        exportedAt,
        data: this.repository.entries()
      };
      const blob = new Blob([JSON.stringify(payload, null, 2)], { type: 'application/json' });
      const url = URL.createObjectURL(blob);
      const anchor = document.createElement('a');
      anchor.href = url;
      anchor.download = `software-starter-backup-${exportedAt.slice(0, 10)}.json`;
      document.body.appendChild(anchor);
      anchor.click();
      anchor.remove();
      URL.revokeObjectURL(url);
      this.notification.notify('Backup created', 'Starter state downloaded as JSON.');
    }

    async import(file) {
      if (!(file instanceof File)) return;
      const text = await file.text();
      const payload = JSON.parse(text);
      if (payload?.schema !== 'asw-software-starter-backup' || payload?.schemaVersion !== 1 || !payload?.data) {
        throw new TypeError('This file is not a compatible Software Starter backup.');
      }
      this.repository.restore(payload.data);
      this.activity.items = this.repository.get('activity', []);
      if (!Array.isArray(this.activity.items)) this.activity.items = [];
      this.activity.record('backup', 'Starter backup imported', file.name);
      this.notification.notify('Backup restored', 'Reloading the starter with restored preferences.', true);
      global.setTimeout(() => global.location.reload(), 350);
    }
  }

  class AswBookModuleService {
    constructor(repository, activity, notification, eventBus) {
      this.repository = repository;
      this.activity = activity;
      this.notification = notification;
      this.eventBus = eventBus;
      this.taxonomyTypes = ['template', 'category', 'tag', 'author', 'genre'];
      this.state = this.normalize(this.repository.get('book-module', {}));
    }

    emptyState() {
      return {
        schemaVersion: 1,
        taxonomies: Object.fromEntries(this.taxonomyTypes.map((type) => [type, []])),
        books: []
      };
    }

    normalize(input) {
      const state = this.emptyState();
      const source = input && typeof input === 'object' && !Array.isArray(input) ? input : {};
      this.taxonomyTypes.forEach((type) => {
        const rows = Array.isArray(source.taxonomies?.[type]) ? source.taxonomies[type] : [];
        state.taxonomies[type] = rows.map((row) => this.normalizeTaxonomyRecord(row, type)).filter(Boolean);
      });
      const books = Array.isArray(source.books) ? source.books : [];
      state.books = books.map((row) => this.normalizeBookRecord(row)).filter(Boolean);
      return state;
    }

    normalizeTaxonomyRecord(row, type) {
      if (!row || typeof row !== 'object') return null;
      const name = this.clean(row.name, 180);
      if (!name) return null;
      const now = new Date().toISOString();
      return {
        id: this.clean(row.id, 120) || this.createId(`book-${type}`),
        name,
        slug: this.clean(row.slug, 180) || this.slugify(name),
        createdAt: this.validDate(row.createdAt) || now,
        updatedAt: this.validDate(row.updatedAt) || this.validDate(row.createdAt) || now
      };
    }

    normalizeBookRecord(row) {
      if (!row || typeof row !== 'object') return null;
      const title = this.clean(row.title, 240);
      if (!title) return null;
      const now = new Date().toISOString();
      return {
        id: this.clean(row.id, 120) || this.createId('book-record'),
        title,
        slug: this.clean(row.slug, 220) || this.slugify(title),
        status: ['draft', 'published', 'archived'].includes(row.status) ? row.status : 'draft',
        template: this.clean(row.template, 180),
        category: this.clean(row.category, 180),
        tag: this.clean(row.tag, 180),
        author: this.clean(row.author, 180),
        genre: this.clean(row.genre, 180),
        createdAt: this.validDate(row.createdAt) || now,
        updatedAt: this.validDate(row.updatedAt) || this.validDate(row.createdAt) || now
      };
    }

    clean(value, maxLength = 240) {
      return String(value ?? '').trim().slice(0, maxLength);
    }

    validDate(value) {
      if (!value) return '';
      const date = new Date(value);
      return Number.isNaN(date.getTime()) ? '' : date.toISOString();
    }

    createId(prefix) {
      const suffix = global.crypto?.randomUUID?.() || `${Date.now()}-${Math.random().toString(16).slice(2)}`;
      return `${prefix}-${suffix}`;
    }

    slugify(value) {
      return this.clean(value, 220)
        .normalize('NFKD')
        .toLowerCase()
        .replace(/[^\p{L}\p{N}]+/gu, '-')
        .replace(/^-+|-+$/g, '') || `record-${Date.now()}`;
    }

    persist(label = '', detail = '') {
      this.repository.set('book-module', this.state);
      if (label) this.activity.record('book', label, detail);
      this.eventBus.emit('book:changed', this.stats());
    }

    listTaxonomy(type) {
      return this.taxonomyTypes.includes(type) ? [...this.state.taxonomies[type]] : [];
    }

    addTaxonomy(type, name, slug = '') {
      if (!this.taxonomyTypes.includes(type)) throw new TypeError('Unknown Book taxonomy workspace.');
      const safeName = this.clean(name, 180);
      if (!safeName) throw new TypeError('Name is required.');
      if (this.state.taxonomies[type].some((row) => row.name.toLocaleLowerCase() === safeName.toLocaleLowerCase())) {
        throw new TypeError(`${safeName} already exists in ${type}.`);
      }
      const now = new Date().toISOString();
      const record = {
        id: this.createId(`book-${type}`),
        name: safeName,
        slug: this.clean(slug, 180) || this.slugify(safeName),
        createdAt: now,
        updatedAt: now
      };
      this.state.taxonomies[type].unshift(record);
      this.persist(`${this.title(type)} created`, record.name);
      this.notification.notify(`${this.title(type)} saved`, record.name);
      return record;
    }

    removeTaxonomy(type, id) {
      if (!this.taxonomyTypes.includes(type)) return false;
      const index = this.state.taxonomies[type].findIndex((row) => row.id === id);
      if (index < 0) return false;
      const [record] = this.state.taxonomies[type].splice(index, 1);
      this.persist(`${this.title(type)} removed`, record.name);
      this.notification.notify(`${this.title(type)} removed`, record.name);
      return true;
    }

    listBooks() {
      return [...this.state.books];
    }

    addBook(input) {
      const title = this.clean(input?.title, 240);
      if (!title) throw new TypeError('Book title is required.');
      const slug = this.clean(input?.slug, 220) || this.slugify(title);
      if (this.state.books.some((row) => row.slug.toLocaleLowerCase() === slug.toLocaleLowerCase())) {
        throw new TypeError(`The Book slug "${slug}" already exists.`);
      }
      const now = new Date().toISOString();
      const record = this.normalizeBookRecord({
        ...input,
        id: this.createId('book-record'),
        title,
        slug,
        createdAt: now,
        updatedAt: now
      });
      this.state.books.unshift(record);
      this.persist('Book created', record.title);
      this.notification.notify('Book saved', record.title);
      return record;
    }

    removeBook(id) {
      const index = this.state.books.findIndex((row) => row.id === id);
      if (index < 0) return false;
      const [record] = this.state.books.splice(index, 1);
      this.persist('Book removed', record.title);
      this.notification.notify('Book removed', record.title);
      return true;
    }

    stats() {
      const taxonomy = this.taxonomyTypes.reduce((total, type) => total + this.state.taxonomies[type].length, 0);
      return {
        books: this.state.books.length,
        taxonomy,
        records: taxonomy + this.state.books.length,
        backup: this.repository.get('book-last-backup', null)
      };
    }

    exportCsv() {
      const columns = ['record_type', 'id', 'name', 'slug', 'title', 'status', 'template', 'category', 'tag', 'author', 'genre', 'created_at', 'updated_at'];
      const rows = [columns];
      rows.push(['meta', 'asw-book-module-csv-v1', 'Book Module Backup', '', '', 'schema-v1', '', '', '', '', '', '', '']);
      this.taxonomyTypes.forEach((type) => {
        this.state.taxonomies[type].forEach((record) => rows.push([
          `taxonomy.${type}`, record.id, record.name, record.slug, '', '', '', '', '', '', '', record.createdAt, record.updatedAt
        ]));
      });
      this.state.books.forEach((record) => rows.push([
        'book', record.id, '', record.slug, record.title, record.status, record.template, record.category, record.tag, record.author, record.genre, record.createdAt, record.updatedAt
      ]));
      const csv = rows.map((row) => row.map((value) => this.csvCell(value)).join(',')).join('\r\n');
      const exportedAt = new Date().toISOString();
      const blob = new Blob([`\ufeff${csv}`], { type: 'text/csv;charset=utf-8' });
      const url = URL.createObjectURL(blob);
      const anchor = document.createElement('a');
      anchor.href = url;
      anchor.download = `book-module-backup-${exportedAt.slice(0, 10)}.csv`;
      document.body.appendChild(anchor);
      anchor.click();
      anchor.remove();
      URL.revokeObjectURL(url);
      this.repository.set('book-last-backup', exportedAt);
      this.activity.record('book-backup', 'Book CSV backup exported', `${this.stats().records} records`);
      this.eventBus.emit('book:changed', this.stats());
      this.notification.notify('Book backup created', 'Taxonomy and Book records downloaded as CSV.');
    }

    async importCsv(file) {
      if (!file || typeof file.text !== 'function') return;
      const matrix = this.parseCsv(await file.text());
      if (matrix.length < 1) throw new TypeError('The CSV file is empty.');
      const headers = matrix[0].map((value) => this.clean(value).replace(/^\ufeff/, '').toLowerCase());
      const required = ['record_type', 'id', 'name', 'slug', 'title'];
      if (!required.every((name) => headers.includes(name))) {
        throw new TypeError('This CSV is not a compatible Book module backup.');
      }
      const imported = this.emptyState();
      let validBackup = false;
      matrix.slice(1).forEach((values) => {
        if (!values.some((value) => String(value).trim())) return;
        const row = Object.fromEntries(headers.map((header, index) => [header, this.csvValue(values[index] ?? '')]));
        const type = this.clean(row.record_type, 80).toLowerCase();
        if (type === 'meta') {
          if (row.id === 'asw-book-module-csv-v1') validBackup = true;
          return;
        }
        if (type.startsWith('taxonomy.')) {
          const taxonomyType = type.slice('taxonomy.'.length);
          if (!this.taxonomyTypes.includes(taxonomyType)) return;
          const record = this.normalizeTaxonomyRecord({ id: row.id, name: row.name, slug: row.slug, createdAt: row.created_at, updatedAt: row.updated_at }, taxonomyType);
          if (record) imported.taxonomies[taxonomyType].push(record);
          return;
        }
        if (type === 'book') {
          const record = this.normalizeBookRecord({
            id: row.id,
            title: row.title,
            slug: row.slug,
            status: row.status,
            template: row.template,
            category: row.category,
            tag: row.tag,
            author: row.author,
            genre: row.genre,
            createdAt: row.created_at,
            updatedAt: row.updated_at
          });
          if (record) imported.books.push(record);
        }
      });
      if (!validBackup) throw new TypeError('This CSV does not contain the Book module backup signature.');
      this.state = imported;
      this.persist('Book CSV backup imported', file.name || 'book-module.csv');
      this.notification.notify('Book backup restored', `${this.stats().records} records imported from CSV.`, true);
    }

    csvCell(value) {
      let text = String(value ?? '');
      if (/^[=+\-@]/.test(text)) text = `'${text}`;
      return /[",\r\n]/.test(text) ? `"${text.replace(/"/g, '""')}"` : text;
    }

    csvValue(value) {
      const text = String(value ?? '');
      return /^'[=+\-@]/.test(text) ? text.slice(1) : text;
    }

    parseCsv(text) {
      const rows = [];
      let row = [];
      let cell = '';
      let quoted = false;
      const source = String(text ?? '').replace(/^\ufeff/, '');
      for (let index = 0; index < source.length; index += 1) {
        const character = source[index];
        if (quoted) {
          if (character === '"' && source[index + 1] === '"') {
            cell += '"';
            index += 1;
          } else if (character === '"') {
            quoted = false;
          } else {
            cell += character;
          }
          continue;
        }
        if (character === '"') {
          quoted = true;
        } else if (character === ',') {
          row.push(cell);
          cell = '';
        } else if (character === '\n' || character === '\r') {
          if (character === '\r' && source[index + 1] === '\n') index += 1;
          row.push(cell);
          rows.push(row);
          row = [];
          cell = '';
        } else {
          cell += character;
        }
      }
      if (quoted) throw new TypeError('The CSV contains an unterminated quoted field.');
      if (cell.length || row.length) {
        row.push(cell);
        rows.push(row);
      }
      return rows;
    }

    title(value) {
      return String(value || '').charAt(0).toUpperCase() + String(value || '').slice(1);
    }
  }

  class AswBookPrintService {
    constructor(book, appearance, activity, notification, eventBus) {
      this.book = book;
      this.appearance = appearance;
      this.activity = activity;
      this.notification = notification;
      this.eventBus = eventBus;
      this.stage = document.getElementById('aswBookPrintStage');
      this.paper = 'a4';
      this.active = false;
      this.dynamicStyle = document.createElement('style');
      this.dynamicStyle.id = 'aswBookDynamicPrintStyle';
      document.head.appendChild(this.dynamicStyle);
      global.addEventListener('beforeprint', () => {
        if (!this.active) return;
        document.documentElement.classList.add('asw-print-preparing');
        this.render();
      });
      global.addEventListener('afterprint', () => this.cleanup());
    }

    open(paper = 'A4') {
      const safePaper = ['a0', 'a4', 'a5'].includes(String(paper).toLowerCase()) ? String(paper).toLowerCase() : 'a4';
      const externalEvent = new CustomEvent('asw:book:report:print', {
        cancelable: true,
        detail: { paper: safePaper.toUpperCase(), orientation: 'portrait', books: this.book.listBooks().length }
      });
      global.dispatchEvent(externalEvent);
      this.activity.record('book-report', 'Book print requested', `${safePaper.toUpperCase()} · portrait`);
      if (externalEvent.defaultPrevented) return;
      this.paper = safePaper;
      this.active = true;
      document.documentElement.classList.add('asw-book-print-active', 'asw-print-preparing');
      this.dynamicStyle.textContent = `@media print { @page { size: ${safePaper.toUpperCase()} portrait; margin: 0; } }`;
      if (this.stage) {
        this.stage.dataset.paper = safePaper;
        this.stage.setAttribute('aria-hidden', 'false');
      }
      this.render();
      global.print();
    }

    cleanup() {
      if (!this.active) return;
      document.documentElement.classList.remove('asw-book-print-active', 'asw-print-preparing');
      if (this.stage) this.stage.setAttribute('aria-hidden', 'true');
      this.active = false;
    }

    render() {
      if (!this.stage) return;
      const books = this.book.listBooks();
      const stats = this.book.stats();
      this.stage.replaceChildren();
      this.stage.appendChild(this.summaryPage(books, stats));
      books.forEach((book, index) => this.stage.appendChild(this.bookPage(book, index + 2, books.length + 1)));
    }

    summaryPage(books, stats) {
      const page = this.page('Book Module', 'Print Report', 1, books.length + 1);
      const intro = document.createElement('p');
      intro.className = 'asw-book-print-lead';
      intro.textContent = 'A theme- and typography-tuned snapshot of the Book module workspace.';
      page.querySelector('.asw-book-print-page__body').appendChild(intro);
      const grid = document.createElement('dl');
      grid.className = 'asw-book-print-stats';
      [
        ['Books', stats.books],
        ['Taxonomy records', stats.taxonomy],
        ['Theme', this.appearance.getThemeLabel()],
        ['Typography', `${this.appearance.getFontLabel()} · ${this.appearance.state.scale}%`]
      ].forEach(([label, value]) => {
        const item = document.createElement('div');
        const term = document.createElement('dt');
        const detail = document.createElement('dd');
        term.textContent = String(label);
        detail.textContent = String(value);
        item.append(term, detail);
        grid.appendChild(item);
      });
      page.querySelector('.asw-book-print-page__body').appendChild(grid);
      const list = document.createElement('ol');
      list.className = 'asw-book-print-index';
      if (!books.length) {
        const empty = document.createElement('li');
        empty.textContent = 'No Book records yet. The print workflow is ready for future records.';
        list.appendChild(empty);
      } else {
        books.slice(0, 8).forEach((book) => {
          const item = document.createElement('li');
          item.textContent = `${book.title} · ${this.title(book.status)}`;
          list.appendChild(item);
        });
        if (books.length > 8) {
          const more = document.createElement('li');
          more.textContent = `+ ${books.length - 8} more Book records on following pages`;
          list.appendChild(more);
        }
      }
      page.querySelector('.asw-book-print-page__body').appendChild(list);
      return page;
    }

    bookPage(book, pageNumber, pageCount) {
      const page = this.page('Book Record', book.title, pageNumber, pageCount);
      const body = page.querySelector('.asw-book-print-page__body');
      const metadata = document.createElement('dl');
      metadata.className = 'asw-book-print-metadata';
      [
        ['Slug', book.slug],
        ['Status', this.title(book.status)],
        ['Template', book.template || '—'],
        ['Category', book.category || '—'],
        ['Tag', book.tag || '—'],
        ['Author', book.author || '—'],
        ['Genre', book.genre || '—'],
        ['Updated', new Intl.DateTimeFormat(undefined, { dateStyle: 'medium' }).format(new Date(book.updatedAt))]
      ].forEach(([label, value]) => {
        const row = document.createElement('div');
        const term = document.createElement('dt');
        const detail = document.createElement('dd');
        term.textContent = String(label);
        detail.textContent = String(value);
        row.append(term, detail);
        metadata.appendChild(row);
      });
      body.appendChild(metadata);
      return page;
    }

    page(kicker, title, pageNumber, pageCount) {
      const page = document.createElement('article');
      page.className = 'asw-book-print-page';
      const header = document.createElement('header');
      header.className = 'asw-book-print-page__header';
      const mark = document.createElement('span');
      mark.textContent = kicker;
      const heading = document.createElement('h1');
      heading.textContent = title;
      header.append(mark, heading);
      const body = document.createElement('div');
      body.className = 'asw-book-print-page__body';
      const footer = document.createElement('footer');
      footer.className = 'asw-book-print-page__footer';
      const date = document.createElement('span');
      date.textContent = new Intl.DateTimeFormat(undefined, { dateStyle: 'medium' }).format(new Date());
      const folio = document.createElement('span');
      folio.textContent = `Page ${pageNumber} / ${pageCount}`;
      footer.append(date, folio);
      page.append(header, body, footer);
      return page;
    }

    title(value) {
      return String(value || '').charAt(0).toUpperCase() + String(value || '').slice(1);
    }
  }

  class AswReportService {
    constructor(config, appearance, navigation, activity, notification) {
      this.config = config;
      this.appearance = appearance;
      this.navigation = navigation;
      this.activity = activity;
      this.notification = notification;
      this.dynamicStyle = document.createElement('style');
      this.dynamicStyle.id = 'aswDynamicPrintStyle';
      document.head.appendChild(this.dynamicStyle);
    }

    openPrint(kind, paper, orientation) {
      const validDocumentSizes = ['A4', 'A5', 'Letter'];
      const validPosterSizes = ['A3', 'A2', 'A1', 'A0'];
      const validSizes = kind === 'poster' ? validPosterSizes : validDocumentSizes;
      const safePaper = validSizes.includes(paper) ? paper : validSizes[0];
      const safeOrientation = ['portrait', 'landscape'].includes(orientation) ? orientation : 'portrait';
      const eventName = kind === 'poster' ? 'asw:report:poster' : 'asw:report:print';
      const externalEvent = new CustomEvent(eventName, { cancelable: true, detail: { paper: safePaper, orientation: safeOrientation, view: this.navigation.current } });
      global.dispatchEvent(externalEvent);
      this.activity.record('report', kind === 'poster' ? 'Poster output requested' : 'Print output requested', `${safePaper} · ${safeOrientation}`);
      if (externalEvent.defaultPrevented) return;
      this.dynamicStyle.textContent = `@media print { @page { size: ${safePaper} ${safeOrientation}; margin: ${kind === 'poster' ? '0' : '12mm'}; } }`;
      document.body.dataset.aswPrintKind = kind;
      global.print();
    }

    exportImage(width, height) {
      const safeWidth = Math.min(3200, Math.max(800, Number(width) || 1600));
      const safeHeight = Math.min(2400, Math.max(600, Number(height) || 1000));
      const externalEvent = new CustomEvent('asw:report:image', { cancelable: true, detail: { width: safeWidth, height: safeHeight, view: this.navigation.current } });
      global.dispatchEvent(externalEvent);
      this.activity.record('report', 'Image output requested', `${safeWidth} × ${safeHeight}px`);
      if (externalEvent.defaultPrevented) return;

      const styles = getComputedStyle(document.documentElement);
      const canvas = document.createElement('canvas');
      canvas.width = safeWidth;
      canvas.height = safeHeight;
      const context = canvas.getContext('2d');
      if (!context) return;
      const background = styles.getPropertyValue('--asw-bg').trim() || '#07111f';
      const panel = styles.getPropertyValue('--asw-card-solid').trim() || '#122842';
      const text = styles.getPropertyValue('--asw-text').trim() || '#f4f8ff';
      const muted = styles.getPropertyValue('--asw-muted').trim() || '#9fb1c6';
      const primary = styles.getPropertyValue('--asw-primary').trim() || '#38bdf8';
      const primary2 = styles.getPropertyValue('--asw-primary-2').trim() || '#a78bfa';
      context.fillStyle = background;
      context.fillRect(0, 0, safeWidth, safeHeight);
      const gradient = context.createLinearGradient(0, 0, safeWidth, safeHeight);
      gradient.addColorStop(0, primary);
      gradient.addColorStop(1, primary2);
      context.globalAlpha = .15;
      context.fillStyle = gradient;
      context.fillRect(0, 0, safeWidth, safeHeight);
      context.globalAlpha = 1;
      const margin = Math.round(safeWidth * .07);
      const panelY = Math.round(safeHeight * .12);
      const panelHeight = safeHeight - panelY * 2;
      context.fillStyle = panel;
      this.roundedRect(context, margin, panelY, safeWidth - margin * 2, panelHeight, Math.max(24, safeWidth * .02));
      context.fill();
      context.fillStyle = primary;
      context.font = `800 ${Math.max(17, safeWidth * .015)}px ${styles.fontFamily}`;
      context.fillText('SOFTWARE STARTER · IMAGE REPORT', margin * 1.5, panelY + panelHeight * .18);
      context.fillStyle = text;
      context.font = `800 ${Math.max(42, safeWidth * .055)}px ${styles.fontFamily}`;
      context.fillText(this.config.app.name, margin * 1.5, panelY + panelHeight * .36);
      context.fillStyle = muted;
      context.font = `600 ${Math.max(20, safeWidth * .022)}px ${styles.fontFamily}`;
      context.fillText(`View: ${this.navigation.label()}`, margin * 1.5, panelY + panelHeight * .52);
      context.fillText(`Theme: ${this.appearance.getThemeLabel()}`, margin * 1.5, panelY + panelHeight * .61);
      context.fillText(`Typography: ${this.appearance.getFontLabel()} · ${this.appearance.state.scale}%`, margin * 1.5, panelY + panelHeight * .70);
      context.fillStyle = primary;
      context.fillRect(margin * 1.5, panelY + panelHeight * .79, Math.max(90, safeWidth * .12), Math.max(5, safeHeight * .008));
      context.fillStyle = muted;
      context.font = `500 ${Math.max(16, safeWidth * .014)}px ${styles.fontFamily}`;
      context.fillText(new Date().toLocaleString(), margin * 1.5, panelY + panelHeight * .89);

      canvas.toBlob((blob) => {
        if (!blob) return;
        const url = URL.createObjectURL(blob);
        const anchor = document.createElement('a');
        anchor.href = url;
        anchor.download = `software-starter-${this.navigation.current}-${new Date().toISOString().slice(0, 10)}.png`;
        document.body.appendChild(anchor);
        anchor.click();
        anchor.remove();
        URL.revokeObjectURL(url);
        this.notification.notify('Image created', 'PNG summary downloaded.');
      }, 'image/png');
    }

    roundedRect(context, x, y, width, height, radius) {
      const r = Math.min(radius, width / 2, height / 2);
      context.beginPath();
      context.moveTo(x + r, y);
      context.arcTo(x + width, y, x + width, y + height, r);
      context.arcTo(x + width, y + height, x, y + height, r);
      context.arcTo(x, y + height, x, y, r);
      context.arcTo(x, y, x + width, y, r);
      context.closePath();
    }
  }

  class AswTerminalView {
    constructor(config, mount) {
      this.config = config;
      this.mount = mount;
    }

    escape(value) {
      return String(value ?? '').replace(/[&<>'"]/g, (character) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', "'": '&#39;', '"': '&quot;' }[character]));
    }

    menuCards(items, attribute = 'data-asw-modal-target') {
      return items.map((item) => `<button class="asw-terminal-menu-card" type="button" ${attribute}="${this.escape(item.modal)}"><span class="asw-menu-icon" aria-hidden="true">${this.escape(item.icon)}</span><span class="asw-terminal-menu-card__copy"><b>${this.escape(item.label)}</b><small>${this.escape(item.description)}</small></span><i class="asw-terminal-menu-card__arrow" aria-hidden="true">→</i></button>`).join('');
    }

    commandCards(items) {
      return items.map((item) => `<button class="asw-command-card" type="button" data-asw-modal-target="${this.escape(item.modal)}"><span class="asw-command-card__icon" aria-hidden="true">${this.escape(item.icon)}</span><span class="asw-command-card__copy"><b>${this.escape(item.label)}</b><small>${this.escape(item.description)}</small></span></button>`).join('');
    }

    modal(id, eyebrow, title, description, body, parent = '') {
      const back = parent ? `<button class="asw-back-button" type="button" data-asw-modal-target="${this.escape(parent)}">← ${this.escape(this.modalLabel(parent))}</button>` : '';
      return `<section class="asw-terminal-modal" id="aswModal-${this.escape(id)}" data-asw-modal="${this.escape(id)}" role="dialog" aria-modal="true" aria-labelledby="aswModalTitle-${this.escape(id)}" hidden><header class="asw-terminal-modal__header"><div class="asw-terminal-modal__heading"><span class="asw-terminal-modal__eyebrow">${this.escape(eyebrow)}</span><h2 id="aswModalTitle-${this.escape(id)}">${this.escape(title)}</h2><p>${this.escape(description)}</p></div><div class="asw-terminal-modal__actions">${back}<button class="asw-icon-button" type="button" data-asw-close-modal aria-label="Close">×</button></div></header><div class="asw-terminal-modal__body">${body}</div></section>`;
    }

    modalLabel(id) {
      const labels = {
        workspace: 'Workspace',
        module: 'Module',
        'book-module': 'Book',
        'book-taxonomy': 'Taxonomy',
        'book-posttype': 'Post Type',
        'book-post-type': 'Book',
        'book-data-center': 'Data Center',
        'book-report': 'Report',
        'data-center': 'Data Center',
        report: 'Report',
        settings: 'Settings',
        appearance: 'Appearance',
        theme: 'Theme',
        typography: 'Typography',
        'appearance-sets': 'Appearance'
      };
      return labels[id] || 'Back';
    }

    section(title, description, body) {
      return `<section class="asw-control-section"><div class="asw-control-section__head"><h3>${this.escape(title)}</h3><p>${this.escape(description)}</p></div>${body}</section>`;
    }

    bookTaxonomyWorkspace(type, label) {
      return this.section(`Create ${label}`, `Add records directly to the Book module's ${label} workspace.`, `<div class="asw-form-grid"><label class="asw-field"><span>Name</span><input type="text" maxlength="180" autocomplete="off" data-asw-book-taxonomy-name="${this.escape(type)}" placeholder="${this.escape(label)} name"></label><label class="asw-field"><span>Slug (optional)</span><input type="text" maxlength="180" autocomplete="off" data-asw-book-taxonomy-slug="${this.escape(type)}" placeholder="generated-from-name"></label></div><div class="asw-inline-actions"><button class="asw-button asw-button--primary" type="button" data-asw-action="book-taxonomy-add:${this.escape(type)}">Add ${this.escape(label)}</button></div>`) + this.section(`${label} records`, 'Local module records are immediately available to the Book List workspace and CSV backup.', `<div class="asw-book-record-list" data-asw-book-taxonomy-list="${this.escape(type)}"></div>`);
    }

    render() {
      const themes = this.config.appearance.themes.map((theme) => `<button class="asw-theme-card" type="button" data-asw-theme-choice="${this.escape(theme.id)}"><span class="asw-theme-swatch" aria-hidden="true">${theme.colors.map((color) => `<i style="--asw-swatch:${this.escape(color)}"></i>`).join('')}</span><b>${this.escape(theme.label)}</b><small>${this.escape(theme.description)}</small></button>`).join('');
      const fonts = this.config.appearance.fonts.map((font) => `<button class="asw-font-card" type="button" data-asw-font-choice="${this.escape(font.id)}"><span class="asw-font-sample">Aa 123</span><b>${this.escape(font.label)}</b><small>${this.escape(font.description)}</small></button>`).join('');
      const sets = this.config.appearance.sets.map((set) => `<button class="asw-preset-card" type="button" data-asw-set-choice="${this.escape(set.id)}"><span class="asw-preset-card__mark">SET</span><b>${this.escape(set.label)}</b><small>${this.escape(set.description)}</small></button>`).join('');
      const nav = this.config.navigation.map((item) => `<button class="asw-nav-card" type="button" data-asw-nav-target="${this.escape(item.id)}"><span class="asw-menu-icon" aria-hidden="true">${this.escape(item.icon)}</span><span class="asw-command-card__copy"><b>${this.escape(item.label)}</b><small>${this.escape(item.description)}</small></span></button>`).join('');

      const workspaceBody = this.section('Workspace modules', 'A stable structure for domain modules plus generic data and output controls.', `<div class="asw-command-grid">${this.commandCards(this.config.workspace.items)}</div>`);
      const moduleBody = this.section('Software modules', 'Each module owns its domain flow while terminal settings remain shared.', `<div class="asw-command-grid">${this.commandCards(this.config.workspace.modules)}</div>`);
      const bookModuleBody = this.section('Book module', 'A software-native Book flow with taxonomy, record type, data portability and report output.', `<div class="asw-command-grid">${this.commandCards(this.config.book.items)}</div>`);
      const bookTaxonomyBody = this.section('Book taxonomy', 'Classification workspaces are independent data collections and do not depend on a CMS.', `<div class="asw-command-grid">${this.commandCards(this.config.book.taxonomy)}</div>`);
      const bookTemplateBody = this.bookTaxonomyWorkspace('template', 'Template');
      const bookCategoryBody = this.bookTaxonomyWorkspace('category', 'Category');
      const bookTagBody = this.bookTaxonomyWorkspace('tag', 'Tag');
      const bookAuthorBody = this.bookTaxonomyWorkspace('author', 'Author');
      const bookGenreBody = this.bookTaxonomyWorkspace('genre', 'Genre');
      const bookPosttypeBody = this.section('Record types', 'Post Type is a generic domain-record layer in this starter.', `<div class="asw-command-grid">${this.commandCards(this.config.book.postTypes)}</div>`);
      const bookPostTypeBody = this.section('Book record workspaces', 'Book is the record type; its workspaces can expand without changing the terminal shell.', `<div class="asw-command-grid">${this.commandCards(this.config.book.bookWorkspaces)}</div>`);
      const bookListBody = this.section('Book repository', 'Create Book records and connect them to the taxonomy workspaces.', '<div class="asw-stat-grid"><article class="asw-stat"><span>Books</span><strong data-asw-book-stat="books">0</strong><small>Book records</small></article><article class="asw-stat"><span>Taxonomy</span><strong data-asw-book-stat="taxonomy">0</strong><small>Classification records</small></article><article class="asw-stat"><span>Total records</span><strong data-asw-book-stat="records">0</strong><small>CSV backup scope</small></article><article class="asw-stat"><span>Last CSV backup</span><strong data-asw-book-stat="backup">Never</strong><small>Local export</small></article></div>') + this.section('Create Book', 'Taxonomy links are optional; add taxonomy records first to populate these selectors.', '<div class="asw-form-grid asw-book-form-grid"><label class="asw-field"><span>Title</span><input id="aswBookTitle" type="text" maxlength="240" autocomplete="off" placeholder="Book title"></label><label class="asw-field"><span>Slug (optional)</span><input id="aswBookSlug" type="text" maxlength="220" autocomplete="off" placeholder="generated-from-title"></label><label class="asw-field"><span>Template</span><select id="aswBookTemplate" data-asw-book-taxonomy-select="template"><option value="">No template</option></select></label><label class="asw-field"><span>Category</span><select id="aswBookCategory" data-asw-book-taxonomy-select="category"><option value="">No category</option></select></label><label class="asw-field"><span>Tag</span><select id="aswBookTag" data-asw-book-taxonomy-select="tag"><option value="">No tag</option></select></label><label class="asw-field"><span>Author</span><select id="aswBookAuthor" data-asw-book-taxonomy-select="author"><option value="">No author</option></select></label><label class="asw-field"><span>Genre</span><select id="aswBookGenre" data-asw-book-taxonomy-select="genre"><option value="">No genre</option></select></label><label class="asw-field"><span>Status</span><select id="aswBookStatus"><option value="draft">Draft</option><option value="published">Published</option><option value="archived">Archived</option></select></label></div><div class="asw-inline-actions"><button class="asw-button asw-button--primary" type="button" data-asw-action="book-create">Add Book</button></div>') + this.section('Book List', 'This workspace is the Book record source used by CSV Backup and Print.', '<div class="asw-book-record-list" id="aswBookList"></div>');
      const bookEbookBody = this.section('Empty eBook', 'An editable A4 master template adapted from the supplied AIT-PHA v9 page system.', '<div class="asw-ebook-workspace" id="aswEbookWorkspace"><div class="asw-ebook-toolbar"><div class="asw-ebook-toolbar__group"><button type="button" data-asw-ebook-action="add-page">+ Page</button><button type="button" data-asw-ebook-action="add-panel">+ Panel</button><button type="button" data-asw-ebook-action="add-card">+ Card</button></div><div class="asw-ebook-toolbar__group"><button type="button" data-asw-ebook-action="print">Print eBook</button><button type="button" data-asw-ebook-action="reset">Reset</button></div><span class="asw-ebook-toolbar__status" data-asw-ebook-status>1 page · 1 panel · 3 cards</span></div><div class="asw-ebook-help"><b>Editable template</b><span>Click the Chapter, Page title, Page subtitle, Panel and Card placeholders to enter plain text. Add pages, panels or cards as the eBook grows.</span></div><div class="asw-ebook-canvas" id="aswEbookComponentMount" data-asw-ebook-mount></div></div>');
      const bookDataCenterBody = this.section('Book Data Center', 'Portable Book data stays scoped to this module.', `<div class="asw-command-grid">${this.commandCards(this.config.book.dataCenter)}</div>`);
      const bookBackupBody = this.section('CSV Backup', 'Export or restore all Template, Category, Tag, Author, Genre and Book records in one UTF-8 CSV.', '<div class="asw-stat-grid"><article class="asw-stat"><span>Book records</span><strong data-asw-book-stat="books">0</strong><small>Post Type / Book</small></article><article class="asw-stat"><span>Taxonomy records</span><strong data-asw-book-stat="taxonomy">0</strong><small>Five workspaces</small></article><article class="asw-stat"><span>Total rows</span><strong data-asw-book-stat="records">0</strong><small>Backup data rows</small></article><article class="asw-stat"><span>Last export</span><strong data-asw-book-stat="backup">Never</strong><small>CSV backup</small></article></div><div class="asw-command-grid asw-command-grid--two asw-book-backup-actions"><button class="asw-command-card" type="button" data-asw-action="book-backup-export"><span class="asw-command-card__icon">↓</span><span class="asw-command-card__copy"><b>Export CSV</b><small>Download a spreadsheet-friendly UTF-8 backup of the complete Book module.</small></span></button><button class="asw-command-card" type="button" data-asw-action="book-backup-import"><span class="asw-command-card__icon">↑</span><span class="asw-command-card__copy"><b>Import CSV</b><small>Replace Book module records with a compatible exported CSV file.</small></span></button></div>');
      const bookReportBody = this.section('Book reports', 'Report workspaces are isolated from storage and can grow independently.', `<div class="asw-command-grid">${this.commandCards(this.config.book.report)}</div>`);
      const bookPrintBody = this.section('Color Print', 'The print workflow uses the AIT-PHA paper preparation pattern with terminal UI removed from output.', '<div class="asw-form-grid"><label class="asw-field"><span>Paper size</span><select id="aswBookPrintPaper"><option value="A4">A4</option><option value="A5">A5</option><option value="A0">A0</option></select></label><div class="asw-book-print-preview"><span>PRINT SCOPE</span><strong><span data-asw-book-print-count>0</span> Book records</strong><small>Summary page + one page per Book record</small></div></div><div class="asw-book-print-help"><b>Print setup</b><span>Portrait · Scale 100% · Background graphics ON · Headers/footers OFF. A safe print gutter is prepared automatically.</span></div><div class="asw-inline-actions"><button class="asw-button asw-button--primary" type="button" data-asw-action="book-print-now">Color Print</button></div>');
      const dataBody = this.section('Repository overview', 'These metrics describe only this starter namespace.', '<div class="asw-stat-grid"><article class="asw-stat"><span>Stored keys</span><strong data-asw-data-stat="keys">0</strong><small>Local state entries</small></article><article class="asw-stat"><span>Local size</span><strong data-asw-data-stat="bytes">0 B</strong><small>Approximate storage</small></article><article class="asw-stat"><span>Activities</span><strong data-asw-data-stat="activities">0</strong><small>Recent events</small></article><article class="asw-stat"><span>Last backup</span><strong data-asw-data-stat="backup">Never</strong><small>Last JSON export</small></article></div><div class="asw-inline-actions"><button class="asw-button asw-button--primary" type="button" data-asw-nav-target="data-center">Open Data Center view</button><button class="asw-button" type="button" data-asw-action="refresh-data-center">Refresh metrics</button></div>');
      const backupBody = this.section('Backup state', 'Exports and imports only data inside the configured starter namespace.', '<div class="asw-command-grid asw-command-grid--two"><button class="asw-command-card" type="button" data-asw-action="backup-export"><span class="asw-command-card__icon">↓</span><span class="asw-command-card__copy"><b>Export JSON Backup</b><small>Download themes, interaction settings, activity and starter state.</small></span></button><button class="asw-command-card" type="button" data-asw-action="backup-import"><span class="asw-command-card__icon">↑</span><span class="asw-command-card__copy"><b>Import JSON Backup</b><small>Restore a compatible Software Starter backup.</small></span></button></div>');
      const reportBody = this.section('Report formats', 'Each output fires a cancellable browser event so a future project can replace the default handler.', `<div class="asw-command-grid">${this.commandCards(this.config.workspace.report)}</div><div class="asw-inline-actions"><button class="asw-button" type="button" data-asw-nav-target="reports">Open Report view</button></div>`);
      const printBody = this.section('Print setup', 'Default output uses the browser print dialog; override the asw:report:print event when needed.', '<div class="asw-form-grid"><label class="asw-field"><span>Paper size</span><select id="aswPrintPaper"><option value="A4">A4</option><option value="A5">A5</option><option value="Letter">Letter</option></select></label><label class="asw-field"><span>Orientation</span><select id="aswPrintOrientation"><option value="portrait">Portrait</option><option value="landscape">Landscape</option></select></label></div><div class="asw-inline-actions"><button class="asw-button asw-button--primary" type="button" data-asw-action="print-now">Open Print Dialog</button></div>');
      const posterBody = this.section('Poster setup', 'Large-format output uses zero page margin by default.', '<div class="asw-form-grid"><label class="asw-field"><span>Poster size</span><select id="aswPosterPaper"><option value="A3">A3</option><option value="A2">A2</option><option value="A1">A1</option><option value="A0">A0</option></select></label><label class="asw-field"><span>Orientation</span><select id="aswPosterOrientation"><option value="landscape">Landscape</option><option value="portrait">Portrait</option></select></label></div><div class="asw-inline-actions"><button class="asw-button asw-button--primary" type="button" data-asw-action="poster-now">Open Poster Print Dialog</button></div>');
      const imageBody = this.section('Image setup', 'The starter creates a dependency-free PNG summary. Prevent asw:report:image to plug in a full workspace renderer.', '<div class="asw-form-grid"><label class="asw-field"><span>Width (px)</span><input id="aswImageWidth" type="number" min="800" max="3200" step="100" value="1600"></label><label class="asw-field"><span>Height (px)</span><input id="aswImageHeight" type="number" min="600" max="2400" step="100" value="1000"></label></div><div class="asw-inline-actions"><button class="asw-button asw-button--primary" type="button" data-asw-action="image-now">Download PNG</button></div>');
      const settingsBody = this.section('Settings modules', 'Reusable application controls are grouped here so the root terminal stays compact.', `<div class="asw-command-grid">${this.commandCards(this.config.settings.items)}</div>`);
      const appearanceBody = this.section('Appearance modules', 'Theme and type are intentionally separated and can also be applied together.', `<div class="asw-command-grid">${this.commandCards(this.config.appearance.items)}</div>`);
      const themeBody = this.section('Theme library', 'Nine neutral themes are included and every terminal surface follows the active theme.', `<div class="asw-theme-grid">${themes}</div>`);
      const typographyBody = this.section('Font family', 'System stacks keep the starter fast and dependency-free.', `<div class="asw-font-grid">${fonts}</div>`) + this.section('Typography scale', 'Adjust type independently from interface zoom.', '<div class="asw-field"><span>Scale: <output id="aswFontScaleOutput">100%</output></span><input id="aswFontScale" type="range" min="85" max="120" step="5" value="100"></div>');
      const setsBody = this.section('Coordinated sets', 'One click applies theme, family, and typography scale together.', `<div class="asw-preset-grid">${sets}</div>`);
      const interactionBody = this.section('Interface zoom', 'Scale the working surface without changing your typography preset.', '<div class="asw-field"><span>Zoom: <output id="aswZoomOutput">100%</output></span><input id="aswZoom" type="range" min="80" max="125" step="5" value="100"></div>') + this.section('Density', 'Choose spacing for the reusable shell.', '<div class="asw-segment" data-asw-density-segment><button type="button" data-asw-density-choice="comfortable">Comfortable</button><button type="button" data-asw-density-choice="compact">Compact</button></div>') + this.section('Display behavior', 'These preferences are stored independently from domain data.', '<div class="asw-toggle-list"><label class="asw-toggle-row"><span class="asw-toggle-row__copy"><b>Focus mode</b><small>Hide the application header and footer.</small></span><span class="asw-switch"><input id="aswFocusToggle" type="checkbox"><i></i></span></label><label class="asw-toggle-row"><span class="asw-toggle-row__copy"><b>Reduce motion</b><small>Minimize interface transitions and animated movement.</small></span><span class="asw-switch"><input id="aswMotionToggle" type="checkbox"><i></i></span></label></div><div class="asw-inline-actions"><button class="asw-button" type="button" data-asw-action="toggle-fullscreen">Toggle Full Screen</button></div>');
      const navigationBody = this.section('History', 'Back and forward operate on this starter session.', '<div class="asw-history-actions"><button class="asw-button" type="button" data-asw-action="nav-back">← Back</button><button class="asw-button" type="button" data-asw-action="nav-forward">Forward →</button></div>') + this.section('Application views', 'Replace these neutral destinations with the views from your next project.', `<div class="asw-command-grid asw-command-grid--four">${nav}</div>`);
      const notificationBody = this.section('Notification behavior', 'In-app messages require no permission; browser notifications are optional.', '<div class="asw-toggle-list"><label class="asw-toggle-row"><span class="asw-toggle-row__copy"><b>In-app notifications</b><small>Show terminal notices and operation results.</small></span><span class="asw-switch"><input id="aswNotificationToggle" type="checkbox"><i></i></span></label></div><div class="asw-form-grid" style="margin-top:14px"><label class="asw-field"><span>Toast position</span><select id="aswNotificationPosition"><option value="bottom-right">Bottom right</option><option value="top-right">Top right</option></select></label></div><div class="asw-inline-actions"><button class="asw-button asw-button--primary" type="button" data-asw-action="test-notification">Send Test</button><button class="asw-button" type="button" data-asw-action="browser-notification">Request Browser Permission</button></div>');
      const activityBody = this.section('Recent activity', 'Theme, typography, navigation, terminal, workspace and output actions are captured here.', '<div class="asw-inline-actions" style="margin:0 0 13px"><button class="asw-button asw-button--danger" type="button" data-asw-action="clear-activity">Clear Activity</button></div><ol class="asw-activity-list" id="aswActivityList"></ol>');

      const modals = [
        this.modal('workspace', 'TERMINAL / WORKSPACE', 'Workspace', 'Module, Data Center, Backup and Report', workspaceBody),
        this.modal('module', 'WORKSPACE / MODULE', 'Module', 'Domain software modules', moduleBody, 'workspace'),
        this.modal('book-module', 'WORKSPACE / MODULE / BOOK', 'Book', 'Taxonomy, Post Type, Data Center and Report', bookModuleBody, 'module'),
        this.modal('book-taxonomy', 'BOOK / TAXONOMY', 'Taxonomy', 'Template, Category, Tag, Author and Genre', bookTaxonomyBody, 'book-module'),
        this.modal('book-taxonomy-template', 'BOOK / TAXONOMY / TEMPLATE', 'Template', 'Book Template workspace', bookTemplateBody, 'book-taxonomy'),
        this.modal('book-taxonomy-category', 'BOOK / TAXONOMY / CATEGORY', 'Category', 'Book Category workspace', bookCategoryBody, 'book-taxonomy'),
        this.modal('book-taxonomy-tag', 'BOOK / TAXONOMY / TAG', 'Tag', 'Book Tag workspace', bookTagBody, 'book-taxonomy'),
        this.modal('book-taxonomy-author', 'BOOK / TAXONOMY / AUTHOR', 'Author', 'Book Author workspace', bookAuthorBody, 'book-taxonomy'),
        this.modal('book-taxonomy-genre', 'BOOK / TAXONOMY / GENRE', 'Genre', 'Book Genre workspace', bookGenreBody, 'book-taxonomy'),
        this.modal('book-posttype', 'BOOK / POST TYPE', 'Post Type', 'Domain record types', bookPosttypeBody, 'book-module'),
        this.modal('book-post-type', 'BOOK / POST TYPE / BOOK', 'Book', 'Book record type', bookPostTypeBody, 'book-posttype'),
        this.modal('book-list', 'BOOK / POST TYPE / BOOK / LIST', 'List', 'Book record workspace', bookListBody, 'book-post-type'),
        this.modal('book-ebook', 'BOOK / POST TYPE / BOOK / EBOOK', 'eBook', 'Empty AIT-PHA-style eBook component workspace', bookEbookBody, 'book-post-type'),
        this.modal('book-data-center', 'BOOK / DATA CENTER', 'Data Center', 'Book data portability', bookDataCenterBody, 'book-module'),
        this.modal('book-backup', 'BOOK / DATA CENTER / BACKUP', 'Backup', 'CSV export and import', bookBackupBody, 'book-data-center'),
        this.modal('book-report', 'BOOK / REPORT', 'Report', 'Book output workspaces', bookReportBody, 'book-module'),
        this.modal('book-print', 'BOOK / REPORT / PRINT', 'Print', 'AIT-PHA-style color print preparation', bookPrintBody, 'book-report'),
        this.modal('data-center', 'WORKSPACE / DATA CENTER', 'Data Center', 'Generic storage and adapter surface', dataBody, 'workspace'),
        this.modal('backup', 'WORKSPACE / BACKUP', 'Backup', 'Portable starter state', backupBody, 'workspace'),
        this.modal('report', 'WORKSPACE / REPORT', 'Report', 'Print, Poster and Image', reportBody, 'workspace'),
        this.modal('print', 'WORKSPACE / REPORT / PRINT', 'Print', 'Document output settings', printBody, 'report'),
        this.modal('poster', 'WORKSPACE / REPORT / POSTER', 'Poster', 'Large-format output settings', posterBody, 'report'),
        this.modal('image', 'WORKSPACE / REPORT / IMAGE', 'Image', 'PNG output and integration hook', imageBody, 'report'),
        this.modal('settings', 'TERMINAL / SETTINGS', 'Settings', 'Appearance, Interaction, Navigation, Notification and Activity', settingsBody),
        this.modal('appearance', 'SETTINGS / APPEARANCE', 'Appearance', 'Theme, Typography and coordinated sets', appearanceBody, 'settings'),
        this.modal('theme', 'APPEARANCE / THEME', 'Theme', 'Interface color system', themeBody, 'appearance'),
        this.modal('typography', 'APPEARANCE / TYPOGRAPHY', 'Typography', 'Font family and scale', typographyBody, 'appearance'),
        this.modal('appearance-sets', 'APPEARANCE / SETS', 'Theme + Typography Sets', 'Coordinated appearance presets', setsBody, 'appearance'),
        this.modal('interaction', 'SETTINGS / INTERACTION', 'Interaction', 'Viewport and display behavior', interactionBody, 'settings'),
        this.modal('navigation', 'SETTINGS / NAVIGATION', 'Navigation', 'Generic application destinations', navigationBody, 'settings'),
        this.modal('notification', 'SETTINGS / NOTIFICATION', 'Notification', 'In-app and browser message behavior', notificationBody, 'settings'),
        this.modal('activity', 'SETTINGS / ACTIVITY', 'Activity', 'Recent terminal and workspace actions', activityBody, 'settings')
      ].join('');

      this.mount.innerHTML = `<button class="asw-terminal-launcher" id="aswTerminalLauncher" type="button" aria-expanded="false" aria-controls="aswTerminalDock"><span class="asw-terminal-launcher__icon" aria-hidden="true">&gt;_</span><span class="asw-terminal-launcher__copy"><b>${this.escape(this.config.terminal.launcherLabel)}</b><small>Control center</small></span></button><button class="asw-terminal-backdrop" id="aswTerminalBackdrop" type="button" tabindex="-1" aria-label="Close terminal"></button><aside class="asw-terminal-dock" id="aswTerminalDock" aria-hidden="true" aria-label="${this.escape(this.config.terminal.title)}"><header class="asw-terminal-dock__header"><div class="asw-terminal-brand"><span class="asw-terminal-brand__mark" aria-hidden="true">⌘</span><span class="asw-terminal-brand__copy"><strong>${this.escape(this.config.terminal.title)}</strong><small>${this.escape(this.config.terminal.subtitle)}</small></span></div><button class="asw-icon-button" type="button" data-asw-close-dock aria-label="Close terminal">×</button></header><div class="asw-terminal-menu">${this.menuCards(this.config.menu)}</div><footer class="asw-terminal-dock__footer"><span class="asw-status-dot"></span><span data-asw-terminal-status>Starter ready</span></footer></aside><div class="asw-terminal-modal-shell" id="aswTerminalModalShell" aria-hidden="true"><button class="asw-terminal-modal-backdrop" type="button" data-asw-close-modal tabindex="-1" aria-label="Close dialog"></button>${modals}</div>`;
    }
  }

  class AswTerminalController {
    constructor(root, activity, eventBus) {
      this.root = root;
      this.activity = activity;
      this.eventBus = eventBus;
      this.launcher = root.querySelector('#aswTerminalLauncher');
      this.dock = root.querySelector('#aswTerminalDock');
      this.backdrop = root.querySelector('#aswTerminalBackdrop');
      this.shell = root.querySelector('#aswTerminalModalShell');
      this.activeModal = '';
      this.lastFocus = null;
      this.pathMap = {
        workspace: 'workspace',
        'workspace:module': 'module',
        'workspace:module:book': 'book-module',
        'workspace:module:book:taxonomy': 'book-taxonomy',
        'workspace:module:book:taxonomy:template': 'book-taxonomy-template',
        'workspace:module:book:taxonomy:category': 'book-taxonomy-category',
        'workspace:module:book:taxonomy:tag': 'book-taxonomy-tag',
        'workspace:module:book:taxonomy:author': 'book-taxonomy-author',
        'workspace:module:book:taxonomy:genre': 'book-taxonomy-genre',
        'workspace:module:book:posttype': 'book-posttype',
        'workspace:module:book:posttype:book': 'book-post-type',
        'workspace:module:book:posttype:book:list': 'book-list',
        'workspace:module:book:posttype:book:ebook': 'book-ebook',
        'workspace:module:book:data-center': 'book-data-center',
        'workspace:module:book:data-center:backup': 'book-backup',
        'workspace:module:book:report': 'book-report',
        'workspace:module:book:report:print': 'book-print',
        'workspace:data-center': 'data-center',
        'workspace:backup': 'backup',
        'workspace:report': 'report',
        'workspace:report:print': 'print',
        'workspace:report:poster': 'poster',
        'workspace:report:image': 'image',
        settings: 'settings',
        'settings:appearance': 'appearance',
        'settings:appearance:theme': 'theme',
        'settings:appearance:typography': 'typography',
        'settings:appearance:sets': 'appearance-sets',
        'settings:interaction': 'interaction',
        'settings:navigation': 'navigation',
        'settings:notification': 'notification',
        'settings:activity': 'activity',
        appearance: 'appearance',
        'appearance:theme': 'theme',
        'appearance:typography': 'typography',
        'appearance:sets': 'appearance-sets',
        interaction: 'interaction',
        navigation: 'navigation',
        notification: 'notification',
        activity: 'activity'
      };
    }

    openDock(track = true) {
      this.closeModal(false);
      this.lastFocus = document.activeElement;
      this.dock.classList.add('asw-is-open');
      this.backdrop.classList.add('asw-is-open');
      this.dock.setAttribute('aria-hidden', 'false');
      this.launcher.setAttribute('aria-expanded', 'true');
      if (track) this.activity.record('terminal', 'Terminal opened');
      this.dock.querySelector('button')?.focus();
    }

    closeDock(track = true) {
      if (!this.dock.classList.contains('asw-is-open')) return;
      this.dock.classList.remove('asw-is-open');
      this.backdrop.classList.remove('asw-is-open');
      this.dock.setAttribute('aria-hidden', 'true');
      this.launcher.setAttribute('aria-expanded', 'false');
      if (track) this.activity.record('terminal', 'Terminal closed');
    }

    openModal(id, track = true) {
      const modal = this.root.querySelector(`[data-asw-modal="${CSS.escape(id)}"]`);
      if (!modal) return;
      this.closeDock(false);
      this.root.querySelectorAll('[data-asw-modal]').forEach((item) => { item.hidden = true; });
      modal.hidden = false;
      this.shell.classList.add('asw-is-open');
      this.shell.setAttribute('aria-hidden', 'false');
      this.activeModal = id;
      if (track) this.activity.record('terminal', 'Terminal panel opened', modal.querySelector('h2')?.textContent || id);
      global.requestAnimationFrame(() => modal.querySelector('button, select, input')?.focus());
      this.eventBus.emit('terminal:modal', { id });
    }

    closeModal(track = true) {
      if (!this.shell.classList.contains('asw-is-open')) return;
      const label = this.root.querySelector(`[data-asw-modal="${CSS.escape(this.activeModal)}"] h2`)?.textContent || this.activeModal;
      this.shell.classList.remove('asw-is-open');
      this.shell.setAttribute('aria-hidden', 'true');
      this.root.querySelectorAll('[data-asw-modal]').forEach((item) => { item.hidden = true; });
      this.activeModal = '';
      if (track) this.activity.record('terminal', 'Terminal panel closed', label);
      if (this.lastFocus instanceof HTMLElement) this.lastFocus.focus({ preventScroll: true });
    }

    openPath(path) {
      const id = this.pathMap[path] || this.pathMap[String(path).split(':')[0]];
      if (id) this.openModal(id);
    }
  }

  class AswApp {
    constructor(config) {
      this.config = config;
      this.eventBus = new AswEventBus();
      this.repository = new AswStorageRepository(config.app.storageNamespace);
      this.activity = new AswActivityService(this.repository, this.eventBus);
      this.appearance = new AswAppearanceManager(config.appearance, this.repository, this.activity, this.eventBus);
      this.interaction = new AswInteractionManager(this.repository, this.activity, this.eventBus);
      this.navigation = new AswNavigationManager(config.navigation, this.repository, this.activity, this.eventBus);
      this.notification = new AswNotificationService(this.repository, this.activity, this.eventBus, document.getElementById('aswToastRegion'));
      this.backup = new AswBackupService(config, this.repository, this.activity, this.notification);
      this.book = new AswBookModuleService(this.repository, this.activity, this.notification, this.eventBus);
      this.report = new AswReportService(config, this.appearance, this.navigation, this.activity, this.notification);
      this.bookPrint = new AswBookPrintService(this.book, this.appearance, this.activity, this.notification, this.eventBus);
      this.terminalView = new AswTerminalView(config, document.getElementById('aswTerminalMount'));
      this.terminalView.render();
      this.ebookComponent = typeof global.ASWEbookComponent === 'function' ? new global.ASWEbookComponent({
        root: '#aswEbookWorkspace',
        mount: '#aswEbookComponentMount',
        storageKey: this.repository.key('ebook-document'),
        onActivity: (label, detail = '') => this.activity.record('ebook', label, detail),
        onNotify: (title, message = '', force = false) => this.notification.notify(title, message, force)
      }) : null;
      this.terminal = new AswTerminalController(document.getElementById('aswTerminalMount'), this.activity, this.eventBus);
      this.bind();
      this.renderState();
      this.activity.record('system', 'Software Starter ready', `Version ${config.app.version}`);
      this.dispatchReady();
    }

    bind() {
      document.addEventListener('click', (event) => this.handleClick(event));
      document.addEventListener('change', (event) => this.handleChange(event));
      document.addEventListener('input', (event) => this.handleInput(event));
      document.addEventListener('keydown', (event) => {
        if (event.key !== 'Escape') return;
        if (this.terminal.shell.classList.contains('asw-is-open')) this.terminal.closeModal();
        else if (this.terminal.dock.classList.contains('asw-is-open')) this.terminal.closeDock();
      });
      document.getElementById('aswBackupImport')?.addEventListener('change', async (event) => {
        const file = event.target.files?.[0];
        if (!file) return;
        try {
          await this.backup.import(file);
        } catch (error) {
          this.activity.record('backup', 'Backup import failed', error.message);
          this.notification.notify('Backup import failed', error.message, true);
        } finally {
          event.target.value = '';
        }
      });
      document.getElementById('aswBookCsvImport')?.addEventListener('change', async (event) => {
        const file = event.target.files?.[0];
        if (!file) return;
        try {
          await this.book.importCsv(file);
        } catch (error) {
          this.activity.record('book-backup', 'Book CSV import failed', error.message);
          this.notification.notify('Book CSV import failed', error.message, true);
        } finally {
          event.target.value = '';
        }
      });
      this.eventBus.on('appearance:changed', () => this.renderState());
      this.eventBus.on('interaction:changed', () => this.renderState());
      this.eventBus.on('navigation:changed', () => this.renderState());
      this.eventBus.on('notification:changed', () => this.renderState());
      this.eventBus.on('activity:changed', () => this.renderState());
      this.eventBus.on('book:changed', () => this.renderBook());
      this.eventBus.on('terminal:modal', ({ id }) => {
        if (id === 'data-center' || id === 'activity' || id.startsWith('book-')) this.renderState();
      });
      global.addEventListener('hashchange', () => {
        const target = global.location.hash.replace(/^#/, '');
        if (this.navigation.isValid(target) && target !== this.navigation.current) this.navigation.show(target);
      });
    }

    handleClick(event) {
      const target = event.target instanceof Element ? event.target : null;
      if (!target) return;

      if (target.closest('[data-asw-open-terminal]') || target.closest('#aswTerminalLauncher')) {
        this.terminal.openDock();
        return;
      }
      if (target.closest('[data-asw-close-dock]') || target.closest('#aswTerminalBackdrop')) {
        this.terminal.closeDock();
        return;
      }
      if (target.closest('[data-asw-close-modal]')) {
        this.terminal.closeModal();
        return;
      }
      const pathButton = target.closest('[data-asw-terminal-path]');
      if (pathButton) {
        this.terminal.openPath(pathButton.dataset.aswTerminalPath);
        return;
      }
      const modalButton = target.closest('[data-asw-modal-target]');
      if (modalButton) {
        this.terminal.openModal(modalButton.dataset.aswModalTarget);
        return;
      }
      const taxonomyRemove = target.closest('[data-asw-book-remove-taxonomy]');
      if (taxonomyRemove) {
        const type = taxonomyRemove.dataset.aswBookRemoveTaxonomy;
        const id = taxonomyRemove.dataset.aswBookRecordId;
        if (type && id && global.confirm(`Remove this ${type} record from the Book module?`)) this.book.removeTaxonomy(type, id);
        return;
      }
      const bookRemove = target.closest('[data-asw-book-remove-record]');
      if (bookRemove) {
        const id = bookRemove.dataset.aswBookRecordId;
        if (id && global.confirm('Remove this Book record?')) this.book.removeBook(id);
        return;
      }
      const themeButton = target.closest('[data-asw-theme-choice]');
      if (themeButton) {
        this.appearance.setTheme(themeButton.dataset.aswThemeChoice);
        this.notification.notify('Theme applied', this.appearance.getThemeLabel());
        return;
      }
      const fontButton = target.closest('[data-asw-font-choice]');
      if (fontButton) {
        this.appearance.setFont(fontButton.dataset.aswFontChoice);
        this.notification.notify('Typography applied', this.appearance.getFontLabel());
        return;
      }
      const setButton = target.closest('[data-asw-set-choice]');
      if (setButton) {
        this.appearance.applySet(setButton.dataset.aswSetChoice);
        this.notification.notify('Appearance set applied', setButton.querySelector('b')?.textContent || 'Preset');
        return;
      }
      const densityButton = target.closest('[data-asw-density-choice]');
      if (densityButton) {
        this.interaction.setDensity(densityButton.dataset.aswDensityChoice);
        return;
      }
      const navButton = target.closest('[data-asw-nav-target]');
      if (navButton) {
        event.preventDefault();
        this.navigation.show(navButton.dataset.aswNavTarget);
        if (this.terminal.shell.classList.contains('asw-is-open')) this.terminal.closeModal(false);
        return;
      }
      const actionButton = target.closest('[data-asw-action]');
      if (actionButton) this.runAction(actionButton.dataset.aswAction);
    }

    handleChange(event) {
      const target = event.target;
      if (!(target instanceof HTMLInputElement || target instanceof HTMLSelectElement)) return;
      if (target.id === 'aswFocusToggle') this.interaction.setFocus(target.checked);
      if (target.id === 'aswMotionToggle') this.interaction.setReduceMotion(target.checked);
      if (target.id === 'aswNotificationToggle') this.notification.setEnabled(target.checked);
      if (target.id === 'aswNotificationPosition') this.notification.setPosition(target.value);
    }

    handleInput(event) {
      const target = event.target;
      if (!(target instanceof HTMLInputElement)) return;
      if (target.id === 'aswFontScale') {
        const output = document.getElementById('aswFontScaleOutput');
        if (output) output.textContent = `${target.value}%`;
      }
      if (target.id === 'aswZoom') {
        const output = document.getElementById('aswZoomOutput');
        if (output) output.textContent = `${target.value}%`;
      }
      if (target.id === 'aswFontScale' && event.type === 'input') {
        global.clearTimeout(this.fontScaleTimer);
        this.fontScaleTimer = global.setTimeout(() => this.appearance.setScale(target.value), 180);
      }
      if (target.id === 'aswZoom' && event.type === 'input') {
        global.clearTimeout(this.zoomTimer);
        this.zoomTimer = global.setTimeout(() => this.interaction.setZoom(target.value), 180);
      }
    }

    runAction(action) {
      if (action.startsWith('book-taxonomy-add:')) {
        this.addBookTaxonomy(action.slice('book-taxonomy-add:'.length));
        return;
      }
      const actions = {
        'refresh-data-center': () => {
          this.activity.record('workspace', 'Data Center refreshed');
          this.renderState();
          global.dispatchEvent(new CustomEvent('asw:data:refresh'));
          this.notification.notify('Data Center refreshed', 'Starter storage metrics updated.');
        },
        'backup-export': () => this.backup.export(),
        'backup-import': () => {
          this.activity.record('backup', 'Backup import selected');
          document.getElementById('aswBackupImport')?.click();
        },
        'book-create': () => this.createBook(),
        'book-backup-export': () => this.book.exportCsv(),
        'book-backup-import': () => {
          this.activity.record('book-backup', 'Book CSV import selected');
          document.getElementById('aswBookCsvImport')?.click();
        },
        'book-print-now': () => {
          const paper = document.getElementById('aswBookPrintPaper')?.value || 'A4';
          this.terminal.closeModal(false);
          this.bookPrint.open(paper);
        },
        'print-now': () => this.report.openPrint('print', document.getElementById('aswPrintPaper')?.value, document.getElementById('aswPrintOrientation')?.value),
        'poster-now': () => this.report.openPrint('poster', document.getElementById('aswPosterPaper')?.value, document.getElementById('aswPosterOrientation')?.value),
        'image-now': () => this.report.exportImage(document.getElementById('aswImageWidth')?.value, document.getElementById('aswImageHeight')?.value),
        'toggle-fullscreen': () => this.interaction.toggleFullscreen(),
        'nav-back': () => this.navigation.back(),
        'nav-forward': () => this.navigation.forward(),
        'test-notification': () => {
          this.activity.record('notification', 'Test notification sent');
          this.notification.notify('Software Starter', 'Notification channel is working.', true);
        },
        'browser-notification': () => this.notification.requestBrowserPermission(),
        'clear-activity': () => {
          if (!global.confirm('Clear the local activity history for this starter?')) return;
          this.activity.clear();
          this.activity.record('activity', 'Activity history cleared');
          this.notification.notify('Activity cleared', 'A fresh activity history has started.');
        }
      };
      actions[action]?.();
    }

    addBookTaxonomy(type) {
      const name = document.querySelector(`[data-asw-book-taxonomy-name="${CSS.escape(type)}"]`);
      const slug = document.querySelector(`[data-asw-book-taxonomy-slug="${CSS.escape(type)}"]`);
      if (!(name instanceof HTMLInputElement) || !(slug instanceof HTMLInputElement)) return;
      try {
        this.book.addTaxonomy(type, name.value, slug.value);
        name.value = '';
        slug.value = '';
        name.focus();
      } catch (error) {
        this.activity.record('book', 'Taxonomy record rejected', error.message);
        this.notification.notify('Could not save taxonomy record', error.message, true);
      }
    }

    createBook() {
      const value = (id) => document.getElementById(id)?.value || '';
      try {
        this.book.addBook({
          title: value('aswBookTitle'),
          slug: value('aswBookSlug'),
          template: value('aswBookTemplate'),
          category: value('aswBookCategory'),
          tag: value('aswBookTag'),
          author: value('aswBookAuthor'),
          genre: value('aswBookGenre'),
          status: value('aswBookStatus') || 'draft'
        });
        const title = document.getElementById('aswBookTitle');
        const slug = document.getElementById('aswBookSlug');
        if (title instanceof HTMLInputElement) title.value = '';
        if (slug instanceof HTMLInputElement) slug.value = '';
        title?.focus();
      } catch (error) {
        this.activity.record('book', 'Book record rejected', error.message);
        this.notification.notify('Could not save Book', error.message, true);
      }
    }

    renderState() {
      this.renderBrand();
      this.renderAppearance();
      this.renderInteraction();
      this.renderNavigation();
      this.renderNotification();
      this.renderActivity();
      this.renderDataStats();
      this.renderBook();
      this.renderSummaries();
    }

    renderBrand() {
      document.querySelectorAll('[data-asw-brand-title]').forEach((element) => { element.textContent = this.config.app.name; });
      document.querySelectorAll('[data-asw-brand-subtitle]').forEach((element) => { element.textContent = this.config.app.subtitle; });
      document.title = this.config.app.name;
    }

    renderAppearance() {
      document.querySelectorAll('[data-asw-theme-choice]').forEach((button) => button.classList.toggle('asw-is-active', button.dataset.aswThemeChoice === this.appearance.state.theme));
      document.querySelectorAll('[data-asw-font-choice]').forEach((button) => button.classList.toggle('asw-is-active', button.dataset.aswFontChoice === this.appearance.state.font));
      const matchingSet = this.appearance.matchingSetId();
      document.querySelectorAll('[data-asw-set-choice]').forEach((button) => button.classList.toggle('asw-is-active', button.dataset.aswSetChoice === matchingSet));
      const scale = document.getElementById('aswFontScale');
      const output = document.getElementById('aswFontScaleOutput');
      if (scale) scale.value = String(this.appearance.state.scale);
      if (output) output.textContent = `${this.appearance.state.scale}%`;
    }

    renderInteraction() {
      const zoom = document.getElementById('aswZoom');
      const output = document.getElementById('aswZoomOutput');
      if (zoom) zoom.value = String(this.interaction.state.zoom);
      if (output) output.textContent = `${this.interaction.state.zoom}%`;
      const focus = document.getElementById('aswFocusToggle');
      const motion = document.getElementById('aswMotionToggle');
      if (focus) focus.checked = this.interaction.state.focus;
      if (motion) motion.checked = this.interaction.state.reduceMotion;
      document.querySelectorAll('[data-asw-density-choice]').forEach((button) => button.classList.toggle('asw-is-active', button.dataset.aswDensityChoice === this.interaction.state.density));
    }

    renderNavigation() {
      document.querySelectorAll('.asw-nav-card[data-asw-nav-target]').forEach((button) => button.classList.toggle('asw-is-active', button.dataset.aswNavTarget === this.navigation.current));
      const back = document.querySelector('[data-asw-action="nav-back"]');
      const forward = document.querySelector('[data-asw-action="nav-forward"]');
      if (back) back.disabled = !this.navigation.status().canBack;
      if (forward) forward.disabled = !this.navigation.status().canForward;
    }

    renderNotification() {
      const toggle = document.getElementById('aswNotificationToggle');
      const position = document.getElementById('aswNotificationPosition');
      if (toggle) toggle.checked = this.notification.state.enabled;
      if (position) position.value = this.notification.state.position;
    }

    renderActivity() {
      const list = document.getElementById('aswActivityList');
      if (!list) return;
      const items = this.activity.list();
      list.replaceChildren();
      if (!items.length) {
        const empty = document.createElement('li');
        empty.className = 'asw-empty-state';
        empty.textContent = 'No activity yet. Your next terminal action will appear here.';
        list.appendChild(empty);
        return;
      }
      items.forEach((item) => {
        const row = document.createElement('li');
        row.className = 'asw-activity-item';
        const mark = document.createElement('span');
        mark.className = 'asw-activity-item__mark';
        mark.textContent = item.category.slice(0, 2);
        const copy = document.createElement('span');
        copy.className = 'asw-activity-item__copy';
        const label = document.createElement('b');
        label.textContent = item.label;
        const detail = document.createElement('small');
        detail.textContent = item.detail || item.category;
        copy.append(label, detail);
        const time = document.createElement('time');
        time.dateTime = item.timestamp;
        time.textContent = new Intl.DateTimeFormat(undefined, { hour: '2-digit', minute: '2-digit', month: 'short', day: 'numeric' }).format(new Date(item.timestamp));
        row.append(mark, copy, time);
        list.appendChild(row);
      });
    }

    renderDataStats() {
      const stats = this.repository.stats();
      const activities = this.activity.list().length;
      const backup = this.repository.get('last-backup', null);
      const values = {
        keys: String(stats.keys),
        bytes: this.formatBytes(stats.bytes),
        activities: String(activities),
        backup: backup ? new Intl.DateTimeFormat(undefined, { month: 'short', day: 'numeric' }).format(new Date(backup)) : 'Never'
      };
      Object.entries(values).forEach(([key, value]) => {
        document.querySelectorAll(`[data-asw-data-stat="${key}"]`).forEach((element) => { element.textContent = value; });
      });
    }

    renderBook() {
      const stats = this.book.stats();
      const values = {
        books: String(stats.books),
        taxonomy: String(stats.taxonomy),
        records: String(stats.records),
        backup: stats.backup ? new Intl.DateTimeFormat(undefined, { month: 'short', day: 'numeric' }).format(new Date(stats.backup)) : 'Never'
      };
      Object.entries(values).forEach(([key, value]) => {
        document.querySelectorAll(`[data-asw-book-stat="${key}"]`).forEach((element) => { element.textContent = value; });
      });
      document.querySelectorAll('[data-asw-book-print-count]').forEach((element) => { element.textContent = String(stats.books); });
      this.book.taxonomyTypes.forEach((type) => this.renderBookTaxonomy(type));
      this.renderBookSelectors();
      this.renderBookList();
    }

    renderBookTaxonomy(type) {
      document.querySelectorAll(`[data-asw-book-taxonomy-list="${CSS.escape(type)}"]`).forEach((container) => {
        container.replaceChildren();
        const records = this.book.listTaxonomy(type);
        if (!records.length) {
          container.appendChild(this.bookEmptyState(`No ${this.book.title(type)} records yet.`));
          return;
        }
        records.forEach((record) => {
          const row = document.createElement('article');
          row.className = 'asw-book-record-row';
          const mark = document.createElement('span');
          mark.className = 'asw-book-record-row__mark';
          mark.textContent = this.book.title(type).slice(0, 2).toUpperCase();
          const copy = document.createElement('span');
          copy.className = 'asw-book-record-row__copy';
          const name = document.createElement('b');
          const slug = document.createElement('small');
          name.textContent = record.name;
          slug.textContent = record.slug;
          copy.append(name, slug);
          const remove = document.createElement('button');
          remove.className = 'asw-book-row-action';
          remove.type = 'button';
          remove.textContent = 'Remove';
          remove.dataset.aswBookRemoveTaxonomy = type;
          remove.dataset.aswBookRecordId = record.id;
          row.append(mark, copy, remove);
          container.appendChild(row);
        });
      });
    }

    renderBookSelectors() {
      document.querySelectorAll('[data-asw-book-taxonomy-select]').forEach((select) => {
        if (!(select instanceof HTMLSelectElement)) return;
        const type = select.dataset.aswBookTaxonomySelect;
        const current = select.value;
        const blank = document.createElement('option');
        blank.value = '';
        blank.textContent = `No ${type}`;
        select.replaceChildren(blank);
        this.book.listTaxonomy(type).forEach((record) => {
          const option = document.createElement('option');
          option.value = record.name;
          option.textContent = record.name;
          select.appendChild(option);
        });
        if ([...select.options].some((option) => option.value === current)) select.value = current;
      });
    }

    renderBookList() {
      const container = document.getElementById('aswBookList');
      if (!container) return;
      container.replaceChildren();
      const records = this.book.listBooks();
      if (!records.length) {
        container.appendChild(this.bookEmptyState('No Book records yet. Add the first Book above.'));
        return;
      }
      records.forEach((record) => {
        const row = document.createElement('article');
        row.className = 'asw-book-record-row asw-book-record-row--book';
        const mark = document.createElement('span');
        mark.className = 'asw-book-record-row__mark';
        mark.textContent = 'BK';
        const copy = document.createElement('span');
        copy.className = 'asw-book-record-row__copy';
        const title = document.createElement('b');
        const detail = document.createElement('small');
        title.textContent = record.title;
        detail.textContent = [this.book.title(record.status), record.author, record.category, record.genre].filter(Boolean).join(' · ') || record.slug;
        copy.append(title, detail);
        const slug = document.createElement('code');
        slug.className = 'asw-book-record-row__slug';
        slug.textContent = record.slug;
        const remove = document.createElement('button');
        remove.className = 'asw-book-row-action';
        remove.type = 'button';
        remove.textContent = 'Remove';
        remove.dataset.aswBookRemoveRecord = 'true';
        remove.dataset.aswBookRecordId = record.id;
        row.append(mark, copy, slug, remove);
        container.appendChild(row);
      });
    }

    bookEmptyState(message) {
      const empty = document.createElement('div');
      empty.className = 'asw-empty-state asw-book-empty-state';
      empty.textContent = message;
      return empty;
    }

    renderSummaries() {
      const summaries = {
        theme: this.appearance.getThemeLabel(),
        font: this.appearance.getFontLabel(),
        activity: `${this.activity.list().length} events`
      };
      Object.entries(summaries).forEach(([key, value]) => document.querySelectorAll(`[data-asw-summary="${key}"]`).forEach((element) => { element.textContent = value; }));
      const settings = {
        theme: this.appearance.getThemeLabel(),
        font: this.appearance.getFontLabel(),
        'font-scale': `${this.appearance.state.scale}%`,
        density: this.interaction.state.density.charAt(0).toUpperCase() + this.interaction.state.density.slice(1),
        zoom: `${this.interaction.state.zoom}%`,
        notifications: this.notification.state.enabled ? 'Enabled' : 'Disabled'
      };
      Object.entries(settings).forEach(([key, value]) => document.querySelectorAll(`[data-asw-setting="${key}"]`).forEach((element) => { element.textContent = value; }));
      const terminalStatus = document.querySelector('[data-asw-terminal-status]');
      if (terminalStatus) terminalStatus.textContent = `${this.appearance.getThemeLabel()} · ${this.appearance.getFontLabel()}`;
    }

    formatBytes(bytes) {
      if (bytes < 1024) return `${bytes} B`;
      if (bytes < 1024 * 1024) return `${(bytes / 1024).toFixed(1)} KB`;
      return `${(bytes / (1024 * 1024)).toFixed(1)} MB`;
    }

    dispatchReady() {
      const api = {
        version: this.config.app.version,
        openTerminal: () => this.terminal.openDock(),
        openPanel: (id) => this.terminal.openPath(id),
        navigate: (id) => this.navigation.show(id),
        notify: (title, message) => this.notification.notify(title, message),
        recordActivity: (label, detail = '', category = 'app') => this.activity.record(category, label, detail),
        storage: {
          get: (key, fallback = null) => this.repository.get(key, fallback),
          set: (key, value) => this.repository.set(key, value)
        },
        book: {
          list: () => this.book.listBooks(),
          taxonomy: (type) => this.book.listTaxonomy(type)
        },
        ebook: {
          state: () => this.ebookComponent?.getState() || null,
          addPage: () => this.ebookComponent?.addPage(),
          print: () => this.ebookComponent?.print(),
          reset: () => this.ebookComponent?.reset()
        }
      };
      global.SoftwareStarter = Object.freeze(api);
      global.dispatchEvent(new CustomEvent('asw:ready', { detail: api }));
    }
  }

  document.addEventListener('DOMContentLoaded', () => {
    if (!global.ASW_CONFIG) throw new Error('ASW_CONFIG is required before asw-app.js.');
    new AswApp(global.ASW_CONFIG);
  });
}(window, document));
