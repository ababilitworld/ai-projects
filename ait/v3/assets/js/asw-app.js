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
      const savedHistory = repository.get('notification-history', []);
      this.history = Array.isArray(savedHistory) ? savedHistory.slice(0, 50) : [];
      if (!['bottom-right', 'top-right'].includes(this.state.position)) this.state.position = 'bottom-right';
      this.apply(false);
      if (!this.history.length) {
        this.addHistory('Software Starter ready', 'Your reusable dashboard and notification center are ready.');
      }
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

    addHistory(title, message = '') {
      const item = {
        id: global.crypto?.randomUUID?.() || `${Date.now()}-${Math.random().toString(16).slice(2)}`,
        title: String(title || 'Notification'),
        message: String(message || ''),
        timestamp: new Date().toISOString(),
        unread: true
      };
      this.history.unshift(item);
      this.history = this.history.slice(0, 50);
      this.persistHistory();
      return item;
    }

    persistHistory() {
      this.repository.set('notification-history', this.history);
      this.eventBus.emit('notification:history', { items: this.list(), unread: this.unreadCount() });
    }

    list() {
      return this.history.map((item) => ({ ...item }));
    }

    unreadCount() {
      return this.history.reduce((count, item) => count + (item.unread ? 1 : 0), 0);
    }

    markAllRead() {
      if (!this.history.some((item) => item.unread)) return;
      this.history = this.history.map((item) => ({ ...item, unread: false }));
      this.persistHistory();
      this.activity.record('notification', 'Notifications marked as read', `${this.history.length} retained`);
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
      this.addHistory(title, message);
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
      const labels = { workspace: 'Workspace', 'data-center': 'Data Center', report: 'Report', settings: 'Settings', appearance: 'Appearance', theme: 'Theme', typography: 'Typography', 'appearance-sets': 'Appearance' };
      return labels[id] || 'Back';
    }

    section(title, description, body) {
      return `<section class="asw-control-section"><div class="asw-control-section__head"><h3>${this.escape(title)}</h3><p>${this.escape(description)}</p></div>${body}</section>`;
    }

    render() {
      const themes = this.config.appearance.themes.map((theme) => `<button class="asw-theme-card" type="button" data-asw-theme-choice="${this.escape(theme.id)}"><span class="asw-theme-swatch" aria-hidden="true">${theme.colors.map((color) => `<i style="--asw-swatch:${this.escape(color)}"></i>`).join('')}</span><b>${this.escape(theme.label)}</b><small>${this.escape(theme.description)}</small></button>`).join('');
      const fonts = this.config.appearance.fonts.map((font) => `<button class="asw-font-card" type="button" data-asw-font-choice="${this.escape(font.id)}"><span class="asw-font-sample">Aa 123</span><b>${this.escape(font.label)}</b><small>${this.escape(font.description)}</small></button>`).join('');
      const sets = this.config.appearance.sets.map((set) => `<button class="asw-preset-card" type="button" data-asw-set-choice="${this.escape(set.id)}"><span class="asw-preset-card__mark">SET</span><b>${this.escape(set.label)}</b><small>${this.escape(set.description)}</small></button>`).join('');
      const nav = this.config.navigation.map((item) => `<button class="asw-nav-card" type="button" data-asw-nav-target="${this.escape(item.id)}"><span class="asw-menu-icon" aria-hidden="true">${this.escape(item.icon)}</span><span class="asw-command-card__copy"><b>${this.escape(item.label)}</b><small>${this.escape(item.description)}</small></span></button>`).join('');

      const workspaceBody = this.section('Workspace modules', 'A stable structure for project-specific data and output modules.', `<div class="asw-command-grid">${this.commandCards(this.config.workspace.items)}</div>`);
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
        this.modal('workspace', 'TERMINAL / WORKSPACE', 'Workspace', 'Data Center, Backup and Report', workspaceBody),
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
      this.report = new AswReportService(config, this.appearance, this.navigation, this.activity, this.notification);
      this.terminalView = new AswTerminalView(config, document.getElementById('aswTerminalMount'));
      this.terminalView.render();
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
      this.eventBus.on('appearance:changed', () => this.renderState());
      this.eventBus.on('interaction:changed', () => this.renderState());
      this.eventBus.on('navigation:changed', () => this.renderState());
      this.eventBus.on('notification:changed', () => this.renderState());
      this.eventBus.on('notification:history', () => this.renderDashboard());
      this.eventBus.on('activity:changed', () => this.renderState());
      this.eventBus.on('terminal:modal', ({ id }) => {
        if (id === 'data-center' || id === 'activity') this.renderState();
      });
      global.addEventListener('hashchange', () => {
        const target = global.location.hash.replace(/^#/, '');
        if (this.navigation.isValid(target) && target !== this.navigation.current) this.navigation.show(target);
      });
      this.dashboardClockTimer = global.setInterval(() => this.renderDashboardClock(), 30000);
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
        'mark-notifications-read': () => this.notification.markAllRead(),
        'clear-activity': () => {
          if (!global.confirm('Clear the local activity history for this starter?')) return;
          this.activity.clear();
          this.activity.record('activity', 'Activity history cleared');
          this.notification.notify('Activity cleared', 'A fresh activity history has started.');
        }
      };
      actions[action]?.();
    }

    renderState() {
      this.renderBrand();
      this.renderAppearance();
      this.renderInteraction();
      this.renderNavigation();
      this.renderNotification();
      this.renderActivity();
      this.renderDataStats();
      this.renderSummaries();
      this.renderDashboard();
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

    renderDashboard() {
      this.renderDashboardClock();
      const activities = this.activity.list();
      const notifications = this.notification.list();
      const unread = this.notification.unreadCount();
      const storage = this.repository.stats();
      const stats = {
        activity: String(activities.length),
        notifications: String(unread),
        theme: this.appearance.getThemeLabel(),
        storage: this.formatBytes(storage.bytes)
      };
      Object.entries(stats).forEach(([key, value]) => {
        document.querySelectorAll(`[data-asw-dashboard-stat="${key}"]`).forEach((element) => { element.textContent = value; });
      });

      const activityDetail = document.querySelector('[data-asw-dashboard-detail="activity"]');
      const notificationDetail = document.querySelector('[data-asw-dashboard-detail="notifications"]');
      if (activityDetail) activityDetail.textContent = activities.length === 1 ? 'Starter event' : 'Starter events';
      if (notificationDetail) notificationDetail.textContent = this.notification.state.enabled ? 'Unread · alerts on' : 'Unread · alerts muted';
      document.querySelectorAll('[data-asw-dashboard-unread]').forEach((element) => {
        element.textContent = `${unread} unread`;
      });

      const appearance = {
        theme: this.appearance.getThemeLabel(),
        font: this.appearance.getFontLabel(),
        scale: `${this.appearance.state.scale}%`,
        density: this.interaction.state.density.charAt(0).toUpperCase() + this.interaction.state.density.slice(1)
      };
      Object.entries(appearance).forEach(([key, value]) => {
        document.querySelectorAll(`[data-asw-dashboard-appearance="${key}"]`).forEach((element) => { element.textContent = value; });
      });

      this.renderDashboardActivities(activities.slice(0, 6));
      this.renderDashboardNotifications(notifications.slice(0, 5));
    }

    renderDashboardClock() {
      const now = new Date();
      const time = new Intl.DateTimeFormat(undefined, { hour: '2-digit', minute: '2-digit' }).format(now);
      const date = new Intl.DateTimeFormat(undefined, { weekday: 'long', month: 'short', day: 'numeric', year: 'numeric' }).format(now);
      document.querySelectorAll('[data-asw-dashboard-time]').forEach((element) => { element.textContent = time; });
      document.querySelectorAll('[data-asw-dashboard-date]').forEach((element) => { element.textContent = date; });
    }

    renderDashboardActivities(items) {
      const list = document.getElementById('aswDashboardActivityList');
      if (!list) return;
      list.replaceChildren();
      if (!items.length) {
        const empty = document.createElement('li');
        empty.className = 'asw-dashboard-empty';
        empty.textContent = 'Your latest application activity will appear here.';
        list.appendChild(empty);
        return;
      }
      items.forEach((item) => {
        const row = document.createElement('li');
        row.className = 'asw-dashboard-feed__item';
        const mark = document.createElement('span');
        mark.className = 'asw-dashboard-feed__mark';
        mark.textContent = item.category.slice(0, 2);
        const copy = document.createElement('span');
        copy.className = 'asw-dashboard-feed__copy';
        const label = document.createElement('b');
        label.textContent = item.label;
        const detail = document.createElement('small');
        detail.textContent = item.detail || item.category;
        const time = document.createElement('time');
        time.dateTime = item.timestamp;
        time.textContent = this.formatRelativeTime(item.timestamp);
        copy.append(label, detail);
        row.append(mark, copy, time);
        list.appendChild(row);
      });
    }

    renderDashboardNotifications(items) {
      const list = document.getElementById('aswDashboardNotificationList');
      if (!list) return;
      list.replaceChildren();
      if (!items.length) {
        const empty = document.createElement('li');
        empty.className = 'asw-dashboard-empty';
        empty.textContent = 'No notifications yet. New notices will stay available here.';
        list.appendChild(empty);
        return;
      }
      items.forEach((item) => {
        const row = document.createElement('li');
        row.className = 'asw-dashboard-notification';
        row.classList.toggle('asw-is-unread', Boolean(item.unread));
        const dot = document.createElement('span');
        dot.className = 'asw-dashboard-notification__dot';
        dot.setAttribute('aria-hidden', 'true');
        const copy = document.createElement('span');
        copy.className = 'asw-dashboard-notification__copy';
        const title = document.createElement('b');
        title.textContent = item.title;
        const message = document.createElement('small');
        message.textContent = item.message || 'Application notification';
        const time = document.createElement('time');
        time.dateTime = item.timestamp;
        time.textContent = this.formatRelativeTime(item.timestamp);
        copy.append(title, message);
        row.append(dot, copy, time);
        list.appendChild(row);
      });
    }

    formatRelativeTime(timestamp) {
      const date = new Date(timestamp);
      const elapsed = Math.max(0, Date.now() - date.getTime());
      const minute = 60000;
      const hour = minute * 60;
      const day = hour * 24;
      if (!Number.isFinite(elapsed) || Number.isNaN(date.getTime())) return '';
      if (elapsed < minute) return 'Now';
      if (elapsed < hour) return `${Math.floor(elapsed / minute)}m ago`;
      if (elapsed < day) return `${Math.floor(elapsed / hour)}h ago`;
      if (elapsed < day * 7) return `${Math.floor(elapsed / day)}d ago`;
      return new Intl.DateTimeFormat(undefined, { month: 'short', day: 'numeric' }).format(date);
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
