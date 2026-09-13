# Branch and release operations

## Branch roles

| Branch | Purpose | Deployment |
| --- | --- | --- |
| feature/*, fix/*, docs/* | Isolated work from development | Optional dev-project preview |
| development | Reviewed integration branch | ai-projects-dev |
| production | Release candidate | Preview in ai-projects-prod |
| main | Validated live release | ai-projects-prod |

Branches cover the entire repository, not individual app folders. A development → production promotion includes every merged development feature; do not promote until that complete set is ready.

## Feature work

1. Fetch origin, switch to development, and pull with --ff-only.
2. Create a descriptive feature/*, fix/* or docs/* branch.
3. Implement and run tests appropriate to the affected app.
4. Run the handbook checks if editing its files or the static build.
5. Stage only intended files; commit and push the short-lived branch.
6. Open a PR with base development. Include behavior and validation evidence.
7. Resolve feedback and wait for required checks. Merge after review.
8. Verify the dev deployment and interactions between changed features.

## Release promotion

1. Open development → production; review all included changes.
2. Merge using a merge commit. Never squash or rebase long-lived branch promotions.
3. Freeze further candidate promotions while final acceptance tests run.
4. Open Cloudflare ai-projects-prod → Deployments and select the production-branch preview.
5. Record its commit-specific URL, candidate commit SHA, acceptance tests, configuration/migration changes and recovery plan.
6. Open production → main. Confirm production has not advanced since testing.
7. Merge after successful checks and review. main rebuilds the live site.
8. Smoke-test the new deployment and create an annotated version tag.

No test or automatic merge in this setup substitutes for human final release acceptance. Handbook CI checks syntax, local references, checklist/search logic and the static publication boundary; it does not test every application.

## Failed candidate

Create a fix/* branch from development and promote its reviewed fix through development → production. Retest the new candidate SHA before main. Keep unrelated features out during the test window.

## Urgent hotfix

1. Create hotfix/* from the current origin/main.
2. Implement and validate the smallest fix; open hotfix/* → main.
3. Merge after review and verify the live site.
4. Open main → production, then production → development synchronization PRs. Use merge commits and resolve conflicts with tests.

## Rollback

Use a known-good Cloudflare production deployment if immediate rollback is needed. Then create a revert PR from main so subsequent deployments preserve the correction. Synchronize that correction into production and development. Never reset or force-push shared branches. Deployment rollback does not reverse database migrations; database recovery needs its own tested procedure.

## Protection policy

The Release workflow ruleset targets main, production and development: PR required, conversation resolution required, deletion and force pushes blocked, and Workflow validation required once available. The owner is a solo maintainer, so reviewer count is zero; review is a process responsibility, not independent enforced approval. Add one required approval when another maintainer is available.

No linear-history requirement: merge commits are intentional. No broad bypass is needed. This ruleset enforces PR/check gates, not source-branch routing; maintainers must verify PR base/head according to the table above.

## Existing hosting

The cPanel workflow remains unchanged and retains its existing main/develop triggers. The legacy develop trigger is separate from development. Do not rename it or migrate PHP behavior without explicit hosting work. New Cloudflare projects use development and main. A main merge can therefore update Cloudflare, existing connected Workers, and cPanel. Review these deployment effects before every release.
