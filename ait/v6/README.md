# Software Starter

A reusable, project-neutral application shell for starting new software projects from a consistent control layer.

## Terminal structure

```text
Terminal
├── Workspace
│   ├── Module
│   │   └── Book
│   │       ├── Taxonomy
│   │       │   ├── Template
│   │       │   ├── Category
│   │       │   ├── Tag
│   │       │   ├── Author
│   │       │   └── Genre
│   │       ├── Post Type
│   │       │   └── Book
│   │       │       ├── List
│   │       │       └── eBook
│   │       ├── Data Center
│   │       │   └── Backup
│   │       │       ├── Export CSV
│   │       │       └── Import CSV
│   │       └── Report
│   │           └── Print
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

The Book module is a software-domain example, not a CMS implementation. `Taxonomy` is a neutral classification layer and `Post Type / Book` is simply the Book record type.

## Included behavior

- 9 persistent interface themes.
- 5 dependency-free system typography stacks.
- 6 combined theme + typography presets.
- Persistent typography scale, interface zoom, density, focus mode, and reduced-motion preference.
- Generic navigation with session back/forward history.
- In-app notifications plus an optional browser-notification permission flow.
- Central recent-activity history for terminal, workspace, appearance, interaction, navigation, backup, report, and notification actions.
- Book workspaces for Template, Category, Tag, Author, Genre, and Book List records.
- Empty, editable eBook workspace based on the supplied AIT-PHA v9 page system, with an A4 double-frame master page, Chapter/Title/Subtitle header, panel-and-card body, folio, and theme-aware typography.
- Reusable prefixed CSS3/ES6 eBook component in `assets/ebook/`, with add-page, add-panel, add-card, local persistence, reset, and exact-color A4 printing.
- Module-scoped UTF-8 CSV export/import covering every Book and taxonomy record.
- Book Report → Print with A0/A4/A5 portrait output, print-only terminal suppression, exact color output, and a safe print gutter adapted from the latest AIT-PHA print flow.
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

The app is static, but the Composer project wrapper gives future service- or database-backed versions a conventional repository starting point. Add PHP code using PSR-4/OOP conventions when a server layer is introduced.

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

window.addEventListener('asw:book:report:print', (event) => {
  // event.detail: { paper, orientation, books }
  // event.preventDefault() to replace the built-in Book print renderer.
});

window.addEventListener('asw:ebook:changed', (event) => {
  // event.detail: { pages, panels, cards, activePage }
});

window.addEventListener('asw:ebook:print', (event) => {
  // event.detail: { pages, panels, cards, activePage }
  // event.preventDefault() to replace the built-in eBook print renderer.
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
SoftwareStarter.book.list();
SoftwareStarter.book.taxonomy('genre');
SoftwareStarter.openPanel('workspace:module:book:posttype:book:ebook');
SoftwareStarter.ebook.state();
SoftwareStarter.ebook.addPage();
SoftwareStarter.ebook.print();
```

## Reusable eBook component

The component is intentionally empty on first launch: its visible labels are editor-only placeholders and are suppressed on paper. Its HTML is created safely from state by `ASWEbookComponent`, while `assets/ebook/asw-ebook-component.css` provides the responsive CSS3 page system. Every component-owned public class uses the `asw-ebook-` prefix and inherits the terminal's active `--asw-*` theme and font variables.

To mount it in another workspace, load the component CSS and JavaScript, then provide a prefixed root containing a toolbar and a mount point:

```js
const ebook = new ASWEbookComponent({
  root: '#myEbookWorkspace',
  mount: '#myEbookPages',
  storageKey: 'my-project:ebook'
});
```

Toolbar buttons opt in with `data-asw-ebook-action="add-page"`, `add-panel`, `add-card`, `print`, or `reset`. The rendered semantic template contains `header.asw-ebook-page-header`, `section.asw-ebook-page-body`, `section.asw-ebook-panel`, and `article.asw-ebook-card` elements.

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
