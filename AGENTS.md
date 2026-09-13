# AI Projects contribution workflow

Read github-workflow/docs/OPERATIONS.md before repository changes.

- Start feature/*, fix/* or docs/* from the latest origin/development.
- Implement on that short-lived branch, run relevant checks, commit and push, and open a PR with base development.
- Do not directly push feature changes to development, production or main.
- Promote development → production through a PR, test the candidate preview, then promote production → main through a PR.
- Use merge commits for long-lived branch promotions and synchronization; do not squash, rebase or force-push shared branches.
- Record candidate SHA, immutable preview URL, test results and rollback notes in release PRs.
- An urgent hotfix/* starts from main and targets main. Synchronize main → production → development afterward through PRs.
- Future feature requests authorize implementation, tests, commits and opening the development PR. Merge or release only when requested or explicitly authorized.
- Run node github-workflow/scripts/check.js, node --test github-workflow/tests/*.test.js and node github-workflow/scripts/build-site.js when changing the guide or static publication configuration. Run app-specific checks too; handbook checks are not application tests.
- Cloudflare publishes only the manifest-selected static projects. Keep PHP, credentials, browser profiles, temporary files and archives out of the static output.
- Preserve the existing cPanel workflow unless the user explicitly requests its migration or removal.
