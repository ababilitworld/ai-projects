document.addEventListener('DOMContentLoaded', () => {
  window.ababilTerminal = new AbabilTerminal({
    mount: '#ababilTerminalMount',
    title: 'Reader Terminal',
    logo: 'AIT',
    subtitle: 'Local terminal ready',
    searchPlaceholder: 'Search menu or chapter...',
    menus: [
      { id: 'workspace', modal: 'workspace', icon: '▦', title: 'Workspace', description: 'Print and image output' },
      { id: 'appearance', modal: 'appearance', icon: '◐', title: 'Appearance', description: 'Theme and typography' },
      { id: 'interaction', modal: 'interaction', icon: '⌁', title: 'Interaction', description: 'Reader behaviour controls' },
      { id: 'navigation', modal: 'navigation', icon: '➜', title: 'Navigation', description: 'Chapters and reading position' },
      { id: 'notification', modal: 'notification', icon: '◉', title: 'Notification', description: 'Alerts and reminders' },
      { id: 'activity', modal: 'activity', icon: '◷', title: 'Activity', description: 'Recent terminal events' }
    ],
    quickStatus: [
      { key: 'mode', elementId: 'ababilTerminalMode', label: 'READING MODE', value: 'Standard' },
      { key: 'theme', elementId: 'ababilTerminalTheme', label: 'ACTIVE THEME', value: 'Emerald' }
    ],
    footer: [
      { modal: 'workspace', icon: '▦', title: 'Open workspace' },
      { modal: 'activity', icon: '◷', title: 'Activity' }
    ],
    closeOnSelect: true,
    labels: { terminal: 'Terminal', open: 'টার্মিনাল খুলুন', close: 'টার্মিনাল বন্ধ করুন' }
  });
});
