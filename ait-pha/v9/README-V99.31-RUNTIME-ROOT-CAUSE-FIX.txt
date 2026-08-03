AIT-PHA v99.31 — Runtime Root-Cause Fix

Root cause:
AIT Planner Food module was removed from the HTML, but its old JavaScript bindings
still called addEventListener() on missing elements. That exception stopped the
entire planner during initialization, so Available Food search and Add Food did not work.

Fixed:
- Removed/guarded every binding to deleted Food-module controls.
- Initial render no longer invokes removed Food-module renderers.
- Added null guards to renderFoodFilters(), renderFoods(), Escape handling,
  profile rendering and report rendering.
- Verified no unguarded JavaScript references remain for missing DOM IDs.
- Add Food continues to open standalone Data Center Food create workspace.
- Food Edit icons continue to open the exact record in Data Center Food.
- Available Food search and filters now initialize after planner load.
