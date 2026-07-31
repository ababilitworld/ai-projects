# Reusable AIT-PSA v9 Terminal

1. Include `ababil-terminal.css` and `ababil-terminal.js`.
2. Add `<div id="ababilTerminalMount"></div>`.
3. Initialize `new AitPsaGenericTerminal({ mount, title, subtitle, menus, footer })`.
4. Listen for `ababil:terminal-select` to open your own submenu or workspace.
5. Use one of the original v9 themes on `<html data-theme="dark-glass">`.

Themes: dark-glass, classic-light, sapphire, emerald, royal-purple, carbon-oled, crimson, coffee, aurora.
