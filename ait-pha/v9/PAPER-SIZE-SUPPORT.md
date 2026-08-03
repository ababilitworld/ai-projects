# Supported paper sizes

The unified Print Workspace supports:

- ISO A0–A10
- ISO B0–B10
- ISO C0–C10
- Letter, Legal, Tabloid, Ledger, Executive, Statement, Folio, Quarto
- Government Letter, Government Legal, Junior Legal
- ANSI C, D, E
- ARCH A, B, C, D, E
- Photo 4×6, 5×7, 8×10, square 5×5, square 8×8
- Business card and common index-card sizes

The print engine stores explicit width, height and units for every size. It generates
dynamic CSS `@page` rules and page dimensions according to the selected orientation.

Saddle-Stitch uses the next larger ISO parent sheet where available. Unsupported
booklet sizes use a custom sheet exactly twice the final page width.
