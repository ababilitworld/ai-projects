(() => {
  'use strict';

  class AbabilBookTerminal {
    constructor() {
      this.root = document.documentElement;
      this.body = document.body;
      this.terminal = document.getElementById('ababilTerminal');
      this.backdrop = document.getElementById('ababilTerminalBackdrop');
      this.activityDrawer = document.getElementById('ababilActivityDrawer');
      this.activityList = document.getElementById('ababilActivityList');
      this.toastRegion = document.getElementById('ababilToastRegion');
      this.activities = JSON.parse(localStorage.getItem('ababilBookActivities') || '[]');
      this.notificationsEnabled = true;
      this.bindEvents();
      this.renderActivities();
      this.logActivity('eBook terminal initialized');
    }

    bindEvents() {
      document.getElementById('ababilTerminalToggle').addEventListener('click', () => this.openTerminal());
      document.getElementById('ababilTerminalClose').addEventListener('click', () => this.closeTerminal());
      this.backdrop.addEventListener('click', () => this.closeTerminal());
      document.getElementById('ababilActivityClose').addEventListener('click', () => this.closeActivity());
      document.getElementById('ababilSearchButton').addEventListener('click', () => this.searchTerminal());
      document.getElementById('ababilTerminalSearch').addEventListener('keydown', e => {
        if (e.key === 'Enter') this.searchTerminal();
      });

      document.querySelectorAll('.ababil-group-toggle').forEach(button => {
        button.addEventListener('click', () => {
          const panel = button.nextElementSibling;
          const open = !panel.classList.contains('is-open');
          document.querySelectorAll('.ababil-group-panel').forEach(item => item.classList.remove('is-open'));
          document.querySelectorAll('.ababil-group-toggle').forEach(item => item.setAttribute('aria-expanded', 'false'));
          panel.classList.toggle('is-open', open);
          button.setAttribute('aria-expanded', String(open));
        });
      });

      document.querySelectorAll('[data-target]').forEach(button => {
        button.addEventListener('click', () => this.navigate(button.dataset.target));
      });

      document.querySelectorAll('[data-action]').forEach(button => {
        button.addEventListener('click', () => this.handleAction(button.dataset.action));
      });

      document.querySelectorAll('.ababil-section-toggle').forEach(button => {
        button.addEventListener('click', () => this.toggleSection(button));
      });

      document.querySelectorAll('.ababil-checklist-grid input').forEach(input => {
        input.addEventListener('change', () => {
          this.logActivity(`Checklist updated: ${input.parentElement.textContent.trim()}`);
        });
      });
    }

    openTerminal() {
      this.terminal.classList.add('is-open');
      this.backdrop.classList.add('is-open');
      document.getElementById('ababilTerminalToggle').setAttribute('aria-expanded', 'true');
    }

    closeTerminal() {
      this.terminal.classList.remove('is-open');
      this.backdrop.classList.remove('is-open');
      document.getElementById('ababilTerminalToggle').setAttribute('aria-expanded', 'false');
    }

    navigate(id) {
      const target = document.getElementById(id);
      if (!target) return;
      this.closeTerminal();
      target.scrollIntoView({ behavior: 'smooth', block: 'start' });
      this.logActivity(`Navigated to: ${target.querySelector('h2, .ababil-section-toggle span')?.textContent.trim() || id}`);
    }

    toggleSection(button) {
      const body = button.nextElementSibling;
      const expanded = button.getAttribute('aria-expanded') === 'true';
      button.setAttribute('aria-expanded', String(!expanded));
      button.querySelector('b').textContent = expanded ? '+' : '−';
      body.hidden = expanded;
      this.logActivity(`${expanded ? 'Collapsed' : 'Expanded'} section`);
    }

    handleAction(action) {
      const actions = {
        'reading-mode': () => this.setWorkspace('reading'),
        'focus-mode': () => this.setWorkspace('focus'),
        'presentation-mode': () => this.setWorkspace('presentation'),
        'reset-workspace': () => this.setWorkspace('reset'),
        'theme-emerald': () => this.setTheme('emerald'),
        'theme-midnight': () => this.setTheme('midnight'),
        'theme-parchment': () => this.setTheme('parchment'),
        'font-increase': () => this.changeFont(1),
        'font-decrease': () => this.changeFont(-1),
        'font-reset': () => this.resetFont(),
        'toggle-cards': () => this.toggleCards(),
        'expand-all': () => this.setAllSections(true),
        'collapse-all': () => this.setAllSections(false),
        'clear-highlights': () => this.toast('Highlights cleared'),
        'notifications-toggle': () => this.toggleNotifications(),
        'progress-alert': () => this.toast('Reading progress reminder enabled'),
        'show-tip': () => this.toast('শেখা বিষয়কে দৈনন্দিন ছোট কাজে প্রয়োগ করুন।'),
        'show-activity': () => this.openActivity(),
        'clear-activity': () => this.clearActivity(),
        'print-a4': () => this.printBook('a4'),
        'print-a5': () => this.printBook('a5')
      };
      actions[action]?.();
    }

    setWorkspace(mode) {
      this.body.classList.remove('is-focus', 'is-presentation');
      if (mode === 'focus') this.body.classList.add('is-focus');
      if (mode === 'presentation') this.body.classList.add('is-presentation');
      this.closeTerminal();
      this.logActivity(`Workspace changed: ${mode}`);
      this.toast(`Workspace: ${mode}`);
    }

    setTheme(theme) {
      this.root.dataset.theme = theme;
      localStorage.setItem('ababilBookTheme', theme);
      this.logActivity(`Theme changed: ${theme}`);
      this.toast(`Theme changed to ${theme}`);
    }

    changeFont(delta) {
      const current = parseInt(getComputedStyle(this.root).getPropertyValue('--ababil-font-size')) || 16;
      const next = Math.min(21, Math.max(13, current + delta));
      this.root.style.setProperty('--ababil-font-size', `${next}px`);
      this.logActivity(`Font size changed: ${next}px`);
    }

    resetFont() {
      this.root.style.setProperty('--ababil-font-size', '16px');
      this.logActivity('Font size reset');
    }

    toggleCards() {
      this.body.classList.toggle('is-hidden-cards');
      this.logActivity('Insight cards toggled');
    }

    setAllSections(expand) {
      document.querySelectorAll('.ababil-section-toggle').forEach(button => {
        button.setAttribute('aria-expanded', String(expand));
        button.querySelector('b').textContent = expand ? '−' : '+';
        button.nextElementSibling.hidden = !expand;
      });
      this.logActivity(`${expand ? 'Expanded' : 'Collapsed'} all sections`);
    }

    toggleNotifications() {
      this.notificationsEnabled = !this.notificationsEnabled;
      this.logActivity(`Notifications ${this.notificationsEnabled ? 'enabled' : 'disabled'}`);
      this.toast(`Notifications ${this.notificationsEnabled ? 'enabled' : 'disabled'}`);
    }

    searchTerminal() {
      const query = document.getElementById('ababilTerminalSearch').value.trim().toLowerCase();
      if (!query) return;
      const candidates = [...document.querySelectorAll('[data-target], [data-action]')];
      const match = candidates.find(item => item.textContent.toLowerCase().includes(query));
      if (match?.dataset.target) return this.navigate(match.dataset.target);
      this.toast(match ? `Found: ${match.textContent.trim()}` : 'কোনো মিল পাওয়া যায়নি');
      this.logActivity(`Search: ${query}`);
    }

    printBook(size) {
      this.root.dataset.printSize = size;
      this.closeTerminal();
      this.logActivity(`Print requested: ${size.toUpperCase()}`);
      window.print();
    }

    openActivity() {
      this.closeTerminal();
      this.activityDrawer.classList.add('is-open');
      this.activityDrawer.setAttribute('aria-hidden', 'false');
      this.renderActivities();
    }

    closeActivity() {
      this.activityDrawer.classList.remove('is-open');
      this.activityDrawer.setAttribute('aria-hidden', 'true');
    }

    clearActivity() {
      this.activities = [];
      this.saveActivities();
      this.renderActivities();
      this.toast('Activity cleared');
    }

    logActivity(message) {
      this.activities.unshift({ message, time: new Date().toLocaleString('bn-BD') });
      this.activities = this.activities.slice(0, 40);
      this.saveActivities();
      this.renderActivities();
    }

    saveActivities() {
      localStorage.setItem('ababilBookActivities', JSON.stringify(this.activities));
    }

    renderActivities() {
      if (!this.activityList) return;
      this.activityList.innerHTML = this.activities.length
        ? this.activities.map(item => `<li><strong>${this.escapeHtml(item.message)}</strong><br><small>${this.escapeHtml(item.time)}</small></li>`).join('')
        : '<li>এখনও কোনো activity নেই।</li>';
    }

    toast(message) {
      if (!this.notificationsEnabled) return;
      const node = document.createElement('div');
      node.className = 'ababil-toast';
      node.textContent = message;
      this.toastRegion.appendChild(node);
      setTimeout(() => node.remove(), 2600);
    }

    escapeHtml(value) {
      const div = document.createElement('div');
      div.textContent = value;
      return div.innerHTML;
    }
  }

  document.addEventListener('DOMContentLoaded', () => {
    const savedTheme = localStorage.getItem('ababilBookTheme');
    if (savedTheme) document.documentElement.dataset.theme = savedTheme;
    new AbabilBookTerminal();
  });
})();
