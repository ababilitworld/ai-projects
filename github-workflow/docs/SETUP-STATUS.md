# Setup record

Date: 2026-09-14. Repository: ababilitworld/ai-projects.

## Verified baseline

- main: 9c766a7d1a3391c8223228f6ed7aab8784c0f905.
- Existing production and development branches were one commit behind main; both were fast-forwarded to main without force pushes.
- feature/github-workflow was created from development for this implementation.
- Existing cPanel workflow and Cloudflare pml/pha Workers are retained.

## Implementation

- Interactive Release Atlas at github-workflow/index.html.
- Contribution policy in root AGENTS.md and a pull-request template.
- Workflow validation CI and an explicit static publication manifest.
- Automated logic/publication tests and syntax/reference validation.

## Provisioned configuration

- [Release workflow ruleset 23198082](https://github.com/ababilitworld/ai-projects/rules/23198082) is active for main, production and development.
- Pull requests, resolved conversations, merge commits and the GitHub Actions `Workflow validation` check are required. Deletion and force pushes are blocked. There are no bypass actors. Required independent approval count is zero for solo-maintainer operation.
- ai-projects-dev is Git-connected to development. Custom preview includes: feature/*, fix/*, docs/*. Excludes are empty. Automatic serving-branch deployments are enabled.
- ai-projects-prod is Git-connected to main. Custom preview include: production. Excludes are empty. Automatic serving-branch deployments are enabled.
- Both use repository-root build `node github-workflow/scripts/build-site.js`, output `.cloudflare-dist`, and build image v3. Root `.node-version` pins the Node major to 22 for future builds.
- No custom domains, new secrets, backend bindings or database changes were introduced. Default pages.dev domains are used. Preview and dev URLs are public.

## Bootstrap audit trail

1. [PR #1](https://github.com/ababilitworld/ai-projects/pull/1): feature/github-workflow → development. Merged after validation. Development commit: f5fdbe3d45afae9d86dc31fffc598833361b99df.
2. Successful dev deployment: https://e82d062a.ai-projects-dev.pages.dev/github-workflow/.
3. [PR #2](https://github.com/ababilitworld/ai-projects/pull/2): development → production. Candidate commit: ad5f5e58f9fe94a7b15c5074b53427290d642f11.
4. Successful, tested candidate deployment: https://8ca0d94d.ai-projects-prod.pages.dev/github-workflow/.
5. [PR #3](https://github.com/ababilitworld/ai-projects/pull/3): production → main. Merged after candidate tests. Initial live release commit: 95d8fe1dea5c6f54854042a8b69dc97c5b358b0a.
6. Successful live deployment: https://0a761ed7.ai-projects-prod.pages.dev/github-workflow/. The permanent https://ai-projects-prod.pages.dev/github-workflow/ was opened and verified after deployment. The existing pha main-branch build also passed; its failure described below concerns non-main previews.

The prod project's first bootstrap build attempted the old main commit before the new build script reached main and failed as expected. The release deployment replaces that attempt. It does not indicate a failure of the tested candidate.

## Validation evidence

- GitHub Actions ran the complete syntax/reference checks, six unit/integration tests and static export successfully.
- The exporter produced six projects and 179 static assets, with PHP, archives and temporary browser profiles excluded.
- Browser checks covered desktop and 390px mobile layout, stage selection, cross-playbook search, checkbox progress, persistence across reload, reset, and clipboard release-note export.
- The production candidate handbook was loaded from its immutable Cloudflare URL and its stage/playbook/copy controls were smoke-tested.
- These checks validate the new handbook and publication pipeline. They do not certify the behavior of every existing application.

## Retained systems and follow-up

Existing pml/pha Worker preview builds reported failures during promotion. The pha log identifies a missing Worker entry point/assets directory in its existing `npx wrangler versions upload` command. Those Worker settings and cPanel secrets/workflow were retained. See CLOUDFLARE.md for details.

The cPanel workflow still uses its legacy `develop` branch name, while the new dev Pages site uses `development`. Custom domains and independent reviewer approval can be added when the owner selects them.

The handbook's interactive checklist records local user progress only; it is not a live infrastructure status display. The URLs and commit SHAs above are historical evidence and remain valid after later releases.
