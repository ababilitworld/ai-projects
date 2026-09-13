# Cloudflare Pages deployment setup

Two Git-connected Pages projects publish the same static build from different branches.

| Setting | Dev | Prod |
| --- | --- | --- |
| Project | ai-projects-dev | ai-projects-prod |
| Repository | ababilitworld/ai-projects | ababilitworld/ai-projects |
| Production branch | development | main |
| Build command | node github-workflow/scripts/build-site.js | node github-workflow/scripts/build-site.js |
| Root directory | repository root | repository root |
| Output directory | .cloudflare-dist | .cloudflare-dist |
| Node | 22 | 22 |
| Preview includes | feature/*, fix/*, docs/* | production |

Cloudflare calls each project's permanent serving branch its production branch, including development in the dev project.

## Dashboard steps

1. Workers & Pages → Create application → Continue to Pages → Import Git repository.
2. Select the existing ababilitworld GitHub connection and ai-projects repository.
3. Configure the dev row above; save and deploy after the build script exists in development.
4. Repeat for prod after the build script exists in main.
5. In Settings → Builds & deployments / Branch control, keep automatic production deployments enabled. Set custom preview branch includes as shown; leave excludes empty.
6. Verify successful deployments and `/github-workflow/` on each site's pages.dev domain.
7. For final acceptance, select the production branch's commit-specific preview from the prod project's deployments. A moving branch alias is convenient but is not a fixed test record.

## What the static exporter does

`site.config.json` explicitly selects static project folders. The exporter builds a new top-level project directory page without modifying the repository's existing index.html. It preserves each project path. It excludes PHP, archives, database files, dotfiles, node_modules, vendor directories, temporary/browser profiles, tests and scripts. Handbook docs are deliberately included. Assets above Pages' 25 MiB limit fail the build.

The currently empty ait-mll folder is not deployed as an app. Add a working static entry and a manifest entry when it is implemented. The PHP-backed ait-psa and ecoreal apps remain on their existing server. Validate the behavior and external API dependencies of each static app separately; successful copying does not prove the app works.

## Domains and configuration

Default pages.dev domains work without DNS changes. Custom domains are not selected by this setup; add them from the specific project's Custom domains tab when the owner chooses them.

No application secrets are necessary for this static guide. Keep AI/API secrets in backend bindings and never embed them in browser bundles. Dev and preview use test resources; live uses production resources. Environment-specific Pages bindings must be configured separately when an app gains backend functionality.

Existing pml and pha Workers and the cPanel deployment are independent and retained. These new projects do not replace their routing or credentials.

## Official references

- https://developers.cloudflare.com/pages/configuration/branch-build-controls/
- https://developers.cloudflare.com/pages/configuration/preview-deployments/
- https://developers.cloudflare.com/pages/configuration/monorepos/
- https://developers.cloudflare.com/pages/configuration/custom-domains/
- https://developers.cloudflare.com/pages/platform/limits/
