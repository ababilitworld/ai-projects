# Browser and Print Test Report — v100.51

Tested with headless Chromium.

## Print Workspace preview

Configuration:
- Mode: Book
- Paper: A5
- Orientation: Portrait
- Book type: Booklet
- Binding: Saddle-Stitch
- Duplex: Yes

Viewports tested:
- Desktop: 1440 × 1000
- Tablet: 900 × 900
- Mobile: 390 × 844

Results:
- Preview button opens the modal.
- No JavaScript page errors.
- No horizontal modal overflow.
- Preview sheet stays within the viewport.
- Selected configuration and suggested printer settings render correctly.

## Generated PDF

Results:
- Physical PDF size: A4 Landscape.
- PDF pages: 6 imposed sheet sides.
- Each sheet contains exactly two A5 page slots.
- Original A4-designed ebook pages are proportionally scaled into A5 slots.
- Half-pages no longer create independent PDF page breaks.
- No right-side content cropping in the rendered imposed pages.
