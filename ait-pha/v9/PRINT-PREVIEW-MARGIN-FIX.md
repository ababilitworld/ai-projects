# Print Preview Margin Fix

The preview now distinguishes:

- physical sheet edge,
- safe printable margin,
- final page boundary,
- safe content area.

Actual print CSS also reserves safe margins:

- Normal: 10 mm
- Saddle-Stitch: 4 mm sheet padding + 6 mm page padding
- Perfect Binding: 14 mm inner / 8 mm outer
- Wire-O: 16 mm binding / 8 mm outer

Images, SVGs and tables are constrained to the available page width to prevent cropping.
