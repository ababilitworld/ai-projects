# Reusable Workspace Navigation

The terminal now includes a generic `ReusableWorkspaceNavigator` in `script.js`.

## Features
- Functional breadcrumb
- Back and Forward history
- Back to Terminal
- Open Terminal
- Close workspace
- Reusable iframe workspace routing
- Theme synchronization
- Breadcrumb navigation to parent terminal modules

## Opening a workspace
Use `workspaceNavigator.open()`:

```js
workspaceNavigator.open({
  src: 'path/to/tool/index.html',
  title: 'Tool title',
  breadcrumb: ['Workspace', 'Tools', 'Tool title'],
  parentModal: 'toolsModal',
  parentLabel: 'Tools'
});
```

The component is project-independent. Change only the route, title, breadcrumb,
and parent modal values for another project.
