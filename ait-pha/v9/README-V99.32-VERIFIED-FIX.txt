AIT-PHA v99.32 — Verified Available Food Fix

Verified with headless Chromium assertions:
- Profile list initializes without JavaScript errors.
- Create Profile → Available Food opens correctly.
- 43 food cards render from the bundled catalogue.
- Search input is visible and styled with a computed width of more than 700px at desktop viewport.
- Searching “rice” filters the list to matching foods.
- Clear Search resets the query.
- Add Food posts the correct Data Center create-mode message.
- Every food Edit button posts the selected food ID.
- Standalone Data Center Food workspace opens its editor successfully.

The Available Food controls use clean, non-nested HTML controls and theme-token-only CSS.
