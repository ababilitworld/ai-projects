V99.9 terminal opening fix

Cause:
The visual header was removed in v99.8, but script.js still required the old header control IDs. The resulting JavaScript error stopped execution before terminal event listeners were attached.

Fix:
- Added hidden compatibility controls for paper, zoom, print, image, zoom label and page count.
- Kept the visual page header removed.
- Added null-safe layout status/page count updates.
- Preserved Action, Navigation, Exercise, Interaction and Appearance modals.
