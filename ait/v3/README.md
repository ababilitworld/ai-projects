# Software Starter

A reusable, project-neutral application shell for starting new software projects from a consistent control layer.

## Terminal structure

```text
Terminal
├── Workspace
│   ├── Data Center
│   ├── Backup
│   └── Report
│       ├── Print
│       ├── Poster
│       └── Image
└── Settings
    ├── Appearance
    │   ├── Theme
    │   ├── Typography
    │   └── Theme + Typography Sets
    ├── Interaction
    ├── Navigation
    ├── Notification
    └── Activity
```

All terminal submenu panels are full-screen/full-width responsive surfaces and inherit the active theme.

## Included behavior

- Theme-aware Home dashboard with live activity, persistent latest notifications, current appearance, local-state metrics, and quick workspace access.
- 9 persistent interface themes.
- 5 dependency-free system typography stacks.
- 6 combined theme + typography presets.
- Persistent typography scale, interface zoom, density, focus mode, and reduced-motion preference.
- Generic navigation with session back/forward history.
- In-app notifications with a retained recent-notification feed plus an optional browser-notification permission flow.
- Central recent-activity history for terminal, workspace, appearance, interaction, navigation, backup, report, and notification actions.
- Namespaced JSON backup export/import.
- Print setup for A4, A5, and Letter.
- Poster setup for A3, A2, A1, and A0.
- Dependency-free PNG summary output and a replaceable image-export hook.
- Responsive HTML5/CSS3 interface with all application classes and CSS variables prefixed `asw-` / `--asw-`.
- ES6 class-based JavaScript with no jQuery or external runtime dependency.

## Start locally with Composer

```bash
composer install
composer serve
```

Then open `http://127.0.0.1:8080`.

The app is static, but the Composer project wrapper gives future PHP/WordPress/Laravel-backed versions a conventional repository starting point. Add PHP code using PSR-4/OOP conventions when a server layer is introduced.

## Customize a new project

1. Edit `assets/js/asw-config.js` first. Change the app name, terminal labels, menu metadata, themes, presets, and generic navigation destinations there.
2. Replace the sample `<section data-asw-view="...">` blocks in `index.html` with the new project's domain views.
3. Keep project CSS classes under a unique prefix. The starter itself uses only the `asw-` prefix.
4. Subscribe to or override the integration events below instead of modifying the terminal for project-specific output code.

## Integration events

The default report actions dispatch cancellable browser events:

```js
window.addEventListener('asw:report:print', (event) => {
  // event.detail: { paper, orientation, view }
  // event.preventDefault() to replace the built-in browser print action.
});

window.addEventListener('asw:report:poster', (event) => {
  // event.detail: { paper, orientation, view }
});

window.addEventListener('asw:report:image', (event) => {
  // event.detail: { width, height, view }
  // preventDefault() and run the project's own image renderer if required.
});

window.addEventListener('asw:data:refresh', () => {
  // Refresh a future repository/API adapter.
});
```

When initialization completes, the starter exposes a small integration API:

```js
SoftwareStarter.openTerminal();
SoftwareStarter.openPanel('workspace:report');
SoftwareStarter.navigate('reports');
SoftwareStarter.notify('Saved', 'Your project data was saved.');
SoftwareStarter.recordActivity('Record saved', 'ID 42', 'data');
SoftwareStarter.storage.set('my-module', { enabled: true });
```

## GitHub repository baseline

```bash
git init
git add .
git commit -m "chore: initialize reusable software starter"
git branch -M main
git remote add origin https://github.com/OWNER/REPOSITORY.git
git push -u origin main
```

Commit `composer.lock` after the first `composer install` so application builds stay reproducible.
