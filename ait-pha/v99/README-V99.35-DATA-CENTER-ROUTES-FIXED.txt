AIT-PHA v99.35 — Data Center route fix

Root cause:
- Food/Profile buttons called openPlannerDataModule(), but the function definition
  was missing in v99.34, causing a JavaScript ReferenceError.

Fixed routes:
Workspace → Data Center → Data → Food
- Opens data-center/food/index.html in the full-screen workspace.

Workspace → Data Center → Data → Profile
- Opens planner/health-planner/index.html?module=profilesModule.

Also fixed:
- Explicit event propagation handling.
- Shared Back, Terminal and Close controls remain active.
- Food create/edit routes remain supported.
