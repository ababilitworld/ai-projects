# Release Atlas

A responsive, dependency-free HTML/CSS/ES-module handbook for ababilitworld/ai-projects.

## Open locally

Serve the repository using any static HTTP server and open `/github-workflow/`. ES modules require HTTP; opening index.html with file:// is not supported. For example, with Python installed: `python -m http.server 8080`, then visit http://localhost:8080/github-workflow/.

## Validate and build

From the repository root, using Node 22 or later:

```sh
node github-workflow/scripts/check.js
node --test github-workflow/tests/*.test.js
node github-workflow/scripts/build-site.js
```

The build writes only `.cloudflare-dist/`. It generates a project directory page and preserves each included project path, including `/github-workflow/`.

## Components and SOLID boundaries

- `index.html`: semantic document shell, navigation, section landmarks and no-JS links.
- `assets/styles.css`: tokens, layouts, components, responsive rules and print styles. Optional Google Fonts have local system fallbacks.
- `src/data.js`: structured stages, instructions, environments and checks; extend content here.
- `src/core.js`: small DOM factory, base Component, storage and clipboard adapters, search function, release state model. DOM content is inserted as text, not interpolated HTML.
- `src/components.js`: Pipeline, Playbook, Environments, ReleaseChecklist and Navigation classes. Each class owns one UI concern. Pipeline includes keyboard tab navigation.
- `src/app.js`: composition root; inject storage, clipboard and component constructors to replace behavior. A replacement UI component needs a `mount()` method and the corresponding constructor dependencies. There is no inheritance requirement beyond compatible behavior.
- `site.config.json`: explicit public static project manifest; adding an entry does not add PHP execution.

Single responsibility is enforced through separate state, services, data, components and orchestration. Components depend on small injected service contracts (`read/write`, `copy`) rather than concrete browser storage. The component constructor map supports replacement. Content changes do not require modifying rendering logic.

The checklist persists locally under `ai-projects.release-atlas.v1`; it does not read GitHub status or approve releases. Copy actions report clipboard failures. Storage failures retain in-memory state. Search matches all playbooks. Print prints the current selected playbook; use the Markdown operations guide for the full runbook.

## Documentation

- [Setup record](docs/SETUP-STATUS.md)
- [Operations and recovery](docs/OPERATIONS.md)
- [Cloudflare setup](docs/CLOUDFLARE.md)

Changing this guide follows the same feature → development PR workflow as application work.
