(function configureSoftwareStarter(global) {
  'use strict';

  const config = {
    app: {
      name: 'Software Starter',
      subtitle: 'Generic application foundation',
      storageNamespace: 'asw-starter',
      version: '1.0.1'
    },
    terminal: {
      title: 'Software Terminal',
      subtitle: 'Reusable control center',
      launcherLabel: 'Terminal'
    },
    menu: [
      { id: 'workspace', label: 'Workspace', description: 'Data Center, Backup and Report', icon: 'W', modal: 'workspace' },
      { id: 'settings', label: 'Settings', description: 'Appearance, interaction, navigation, notification and activity', icon: 'S', modal: 'settings' }
    ],
    workspace: {
      items: [
        { id: 'data-center', label: 'Data Center', description: 'Generic data and repository overview', icon: 'D', modal: 'data-center' },
        { id: 'backup', label: 'Backup', description: 'Export and import starter state', icon: 'B', modal: 'backup' },
        { id: 'report', label: 'Report', description: 'Print, Poster and Image output', icon: 'R', modal: 'report' }
      ],
      report: [
        { id: 'print', label: 'Print', description: 'Document and browser print output', icon: 'P', modal: 'print' },
        { id: 'poster', label: 'Poster', description: 'Large-format print output', icon: 'O', modal: 'poster' },
        { id: 'image', label: 'Image', description: 'PNG summary and export hook', icon: 'I', modal: 'image' }
      ]
    },
    settings: {
      items: [
        { id: 'appearance', label: 'Appearance', description: 'Theme, typography and combined sets', icon: 'A', modal: 'appearance' },
        { id: 'interaction', label: 'Interaction', description: 'Zoom, focus, density and full screen', icon: 'I', modal: 'interaction' },
        { id: 'navigation', label: 'Navigation', description: 'Views and navigation history', icon: 'N', modal: 'navigation' },
        { id: 'notification', label: 'Notification', description: 'In-app and browser notifications', icon: 'B', modal: 'notification' },
        { id: 'activity', label: 'Activity', description: 'Recent terminal and workspace activity', icon: 'H', modal: 'activity' }
      ]
    },
    appearance: {
      items: [
        { id: 'theme', label: 'Theme', description: 'Choose the interface color system', icon: 'T', modal: 'theme' },
        { id: 'typography', label: 'Typography', description: 'Font family and readable scale', icon: 'Y', modal: 'typography' },
        { id: 'appearance-sets', label: 'Theme + Typography Sets', description: 'Apply coordinated appearance presets', icon: 'S', modal: 'appearance-sets' }
      ],
      themes: [
        { id: 'dark-glass', label: 'Dark Glass', description: 'Deep neutral command surface', colors: ['#07111f', '#38bdf8', '#a78bfa'] },
        { id: 'classic-light', label: 'Classic Light', description: 'Bright professional workspace', colors: ['#f4f7fb', '#087f75', '#2563eb'] },
        { id: 'sapphire', label: 'Sapphire', description: 'Focused blue command center', colors: ['#061426', '#60a5fa', '#22d3ee'] },
        { id: 'emerald', label: 'Emerald', description: 'Calm green workspace', colors: ['#061914', '#34d399', '#a3e635'] },
        { id: 'royal-purple', label: 'Royal Purple', description: 'Premium violet contrast', colors: ['#12091f', '#c084fc', '#f472b6'] },
        { id: 'carbon-oled', label: 'Carbon OLED', description: 'Maximum dark contrast', colors: ['#000000', '#f8fafc', '#22c55e'] },
        { id: 'crimson', label: 'Crimson', description: 'Warm red command palette', colors: ['#19080d', '#fb7185', '#f59e0b'] },
        { id: 'coffee', label: 'Coffee', description: 'Warm reading surface', colors: ['#1a120d', '#d6a46d', '#facc15'] },
        { id: 'aurora', label: 'Aurora', description: 'Teal and violet glow', colors: ['#06151a', '#2dd4bf', '#c084fc'] }
      ],
      fonts: [
        { id: 'system', label: 'System UI', description: 'Native, fast and neutral' },
        { id: 'humanist', label: 'Humanist', description: 'Open and highly readable' },
        { id: 'serif', label: 'Editorial Serif', description: 'Document-oriented character' },
        { id: 'mono', label: 'Interface Mono', description: 'Technical command feel' },
        { id: 'rounded', label: 'Rounded UI', description: 'Friendly application tone' }
      ],
      sets: [
        { id: 'command', label: 'Command', description: 'Dark Glass · System UI · 100%', theme: 'dark-glass', font: 'system', scale: 100 },
        { id: 'clarity', label: 'Clarity', description: 'Classic Light · Humanist · 105%', theme: 'classic-light', font: 'humanist', scale: 105 },
        { id: 'studio', label: 'Studio', description: 'Aurora · System UI · 100%', theme: 'aurora', font: 'system', scale: 100 },
        { id: 'editorial', label: 'Editorial', description: 'Coffee · Serif · 105%', theme: 'coffee', font: 'serif', scale: 105 },
        { id: 'developer', label: 'Developer', description: 'Carbon OLED · Mono · 95%', theme: 'carbon-oled', font: 'mono', scale: 95 },
        { id: 'accessible', label: 'Accessible', description: 'Classic Light · System UI · 115%', theme: 'classic-light', font: 'system', scale: 115 }
      ]
    },
    navigation: [
      { id: 'home', label: 'Home', description: 'Starter overview', icon: 'H' },
      { id: 'data-center', label: 'Data Center', description: 'Generic data surface', icon: 'D' },
      { id: 'reports', label: 'Reports', description: 'Output workspace', icon: 'R' },
      { id: 'settings', label: 'Settings', description: 'Active starter preferences', icon: 'S' }
    ]
  };

  global.ASW_CONFIG = Object.freeze(config);
}(window));
