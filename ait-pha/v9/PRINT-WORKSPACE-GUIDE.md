# Print Workspace

Terminal path:

```text
Workspace → Report → Print
├── Normal
│   ├── A4
│   └── A5
└── Book
    ├── Saddle-Stitch
    ├── Perfect Binding
    └── Wire-O
```

## Normal
Prints sequential pages at A4 or A5 portrait size.

## Saddle-Stitch
Creates booklet imposition on A4 landscape sheets with two A5 pages per side.
The page count is padded to a multiple of four. Print double-sided and flip on
the short edge.

## Perfect Binding
Prints sequential A5 pages with mirrored inner/outer gutters.

## Wire-O
Prints sequential A5 pages with a larger punch/binding margin.

All options are schema-driven terminal workspaces and communicate with the main
print engine through `postMessage`.
