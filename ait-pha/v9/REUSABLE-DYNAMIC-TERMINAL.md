# Reusable Dynamic Terminal

All main menu items, submenus, routes, commands and breadcrumbs are defined in:

`assets/terminal/terminal-schema.js`

The generic renderer uses one delegated click handler. To reuse in another project,
copy the terminal assets and replace only the schema.

Supported action types:
- `workspace`
- `modal`
- `command`

Nested `children` can be added to any depth without adding JavaScript bindings.


## Updated hierarchy

```text
Workspace
├── Data Center
├── Report
└── Tools
    ├── Exercise
    ├── Calculator
    └── AIT – Health Planner
```

`Tools` is no longer a top-level terminal item. It is rendered dynamically as a
Workspace submenu entirely from `terminal-schema.js`; no extra event binding is
required.
