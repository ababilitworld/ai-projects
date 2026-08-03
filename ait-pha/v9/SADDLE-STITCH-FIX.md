# Saddle-Stitch output correction

For the configuration:

- Mode: Book
- Final page: A5
- Orientation: Portrait
- Book type: Booklet
- Binding: Saddle-Stitch
- Duplex: Yes

the generated PDF now uses **A4 landscape physical sheets**. Each PDF page is one
sheet side containing two imposed A5 pages.

The previous build inherited `page-break-after: always` from each cloned `.paper-page`.
That caused each A5 half-page to become a separate PDF page and produced alternating
blank pages. The cloned half-pages now explicitly disable their own page breaks;
only `.booklet-sheet` creates the PDF page break.
