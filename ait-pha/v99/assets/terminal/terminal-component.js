(() => {
  'use strict';
  const config = window.AITPHATerminalConfig || {};
  const mount = document.getElementById('terminalComponentMount');
  if (!mount) return;
  const schema=window.AIT_TERMINAL_SCHEMA||{};
  const rootItems=schema.menu||[];
  const groupMarkup=rootItems.map(item=>`
    <button class="terminal-group-card" data-dynamic-terminal-item="${item.id}" type="button">
      <span class="terminal-group-card__icon">${item.icon||'•'}</span><span><b>${item.label}</b><small>${item.description||''}</small></span><i>→</i>
    </button>`).join('');
  mount.innerHTML = `
<button aria-controls="terminalDock" aria-expanded="false" class="terminal-launcher no-print" id="terminalLauncher" type="button">
  <span aria-hidden="true" class="terminal-launcher__icon terminal-launcher__icon--prompt"><span>${config.launcher?.icon || '&gt;_'}</span></span>
  <span class="terminal-launcher__copy"><b>${config.launcher?.title || 'Terminal'}</b></span>
</button>
<button aria-label="Close terminal menu" class="terminal-dock-backdrop no-print" id="terminalDockBackdrop" tabindex="-1" type="button"></button>
<aside aria-hidden="true" aria-label="${config.brand?.title || 'Terminal'}" class="terminal-dock no-print" id="terminalDock">
  <header class="terminal-dock__header">
    <div class="terminal-dock__title"><span aria-hidden="true">${config.brand?.icon || '⌘'}</span><div><strong>${config.brand?.title || 'Terminal'}</strong><small>${config.brand?.subtitle || ''}</small></div></div>
    <button aria-label="Close terminal menu" class="terminal-icon-button" id="terminalDockClose" type="button">×</button>
  </header>
  <div class="terminal-dock__groups" id="dynamicTerminalMenuMount">${groupMarkup}</div>
  <footer class="terminal-dock__footer"><span class="terminal-live-dot"></span><span id="terminalActiveTheme">Dark Glass active</span></footer>
</aside>
<div aria-hidden="true" class="terminal-modal-shell no-print" id="terminalModalShell">
  <button aria-label="Close modal" class="terminal-modal-backdrop" id="terminalModalBackdrop" tabindex="-1" type="button"></button>
  <section aria-labelledby="workspaceModalTitle" aria-modal="true" class="terminal-modal" hidden id="workspaceModal" role="dialog">
    <header class="terminal-modal__header"><div><span class="terminal-modal__eyebrow">WORKSPACE</span><h2 id="workspaceModalTitle">⚡ Workspace Center</h2><p>Manage planner data and report outputs</p></div><button aria-label="Close" class="terminal-icon-button" data-close-terminal-modal type="button">×</button></header>
    <div class="terminal-modal__body"><section class="terminal-control-section"><h3>Workspace modules</h3><div class="terminal-command-grid">
      <button class="terminal-command terminal-command--primary" data-open-terminal-modal="dataCenterModal" type="button"><span>🗄</span><b>Data Center</b><small>Data, backup, sync and import</small></button>
      <button class="terminal-command" data-open-terminal-modal="reportCenterModal" type="button"><span>🖨</span><b>Report</b><small>Print, poster and image outputs</small></button>
    </div></section></div>
  </section>

  <section aria-labelledby="dataCenterModalTitle" aria-modal="true" class="terminal-modal" hidden id="dataCenterModal" role="dialog">
    <header class="terminal-modal__header"><div><span class="terminal-modal__eyebrow">WORKSPACE / DATA CENTER</span><h2 id="dataCenterModalTitle">🗄 Data Center</h2><p>Manage AIT Health Planner records</p></div><div class="terminal-header-actions"><button class="terminal-back-button" data-open-terminal-modal="workspaceModal" type="button">← Workspace</button><button aria-label="Close" class="terminal-icon-button" data-close-terminal-modal type="button">×</button></div></header>
    <div class="terminal-modal__body"><section class="terminal-control-section"><h3>Data Center tools</h3><div class="terminal-command-grid">
      <button class="terminal-command terminal-command--primary" data-open-terminal-modal="dataManagerModal" type="button"><span>🧾</span><b>Data</b><small>Food and profile records</small></button>
      <button class="terminal-command" data-workspace-action="backup" type="button"><span>💾</span><b>Backup</b><small>Download all planner data as JSON</small></button>
      <button class="terminal-command" data-workspace-action="sync" type="button"><span>🔄</span><b>Sync</b><small>Save a local synchronization checkpoint</small></button>
      <button class="terminal-command" data-workspace-action="import" type="button"><span>📥</span><b>Import</b><small>Restore planner data from JSON</small></button>
    </div><input accept=".json,application/json" hidden id="terminalDataImportFile" type="file"></section></div>
  </section>

  <section aria-labelledby="dataManagerModalTitle" aria-modal="true" class="terminal-modal" hidden id="dataManagerModal" role="dialog">
    <header class="terminal-modal__header"><div><span class="terminal-modal__eyebrow">WORKSPACE / DATA CENTER / DATA</span><h2 id="dataManagerModalTitle">🧾 Planner Data</h2><p>Open Food or Profile data management</p></div><div class="terminal-header-actions"><button class="terminal-back-button" data-open-terminal-modal="dataCenterModal" type="button">← Data Center</button><button aria-label="Close" class="terminal-icon-button" data-close-terminal-modal type="button">×</button></div></header>
    <div class="terminal-modal__body"><section class="terminal-control-section"><h3>Data type</h3><div class="terminal-command-grid">
      <button class="terminal-command terminal-command--primary" data-planner-module="foodsModule" type="button"><span>🥗</span><b>Food</b><small>Open standalone full-screen Food Data workspace</small></button>
      <button class="terminal-command" data-planner-module="profilesModule" type="button"><span>👤</span><b>Profile</b><small>Health-planner profiles</small></button>
    </div></section></div>
  </section>

  <section aria-labelledby="reportCenterModalTitle" aria-modal="true" class="terminal-modal" hidden id="reportCenterModal" role="dialog">
    <header class="terminal-modal__header"><div><span class="terminal-modal__eyebrow">WORKSPACE / REPORT</span><h2 id="reportCenterModalTitle">🖨 Report</h2><p>Create print, poster and image outputs</p></div><div class="terminal-header-actions"><button class="terminal-back-button" data-open-terminal-modal="workspaceModal" type="button">← Workspace</button><button aria-label="Close" class="terminal-icon-button" data-close-terminal-modal type="button">×</button></div></header>
    <div class="terminal-modal__body"><section class="terminal-control-section"><h3>Report tools</h3><div class="terminal-command-grid">
      <button class="terminal-command terminal-command--primary" data-command="print" type="button"><span>🖨</span><b>Print</b><small>Use the existing color-print workflow</small></button>
      <button class="terminal-command" data-workspace-action="poster" type="button"><span>🪧</span><b>Poster</b><small>A3 landscape poster output</small></button>
      <button class="terminal-command" data-command="image" type="button"><span>🖼</span><b>Image</b><small>Use the existing high-resolution image export</small></button>
    </div></section>
    <section class="terminal-control-section"><h3>Paper size</h3><div class="terminal-segment" id="terminalPaperSegment">
      <button data-paper-command="a0" type="button">A0</button><button data-paper-command="a4" type="button">A4</button><button data-paper-command="a5" type="button">A5</button>
    </div></section></div>
  </section>
  <section aria-labelledby="navigationModalTitle" aria-modal="true" class="terminal-modal terminal-modal--wide" hidden id="navigationModal" role="dialog">
    <header class="terminal-modal__header"><div><span class="terminal-modal__eyebrow">TERMINAL GROUP</span><h2 id="navigationModalTitle">🧭 Navigation</h2><p>Jump directly to an ebook page</p></div><button aria-label="Close" class="terminal-icon-button" data-close-terminal-modal type="button">×</button></header>
    <div class="terminal-modal__body"><section class="terminal-control-section"><h3>Ebook pages</h3><div class="terminal-command-grid terminal-command-grid--compact">
      <button class="terminal-command" data-page-index="0" type="button"><span>01</span><b>Cover</b><small>Book introduction</small></button>
      <button class="terminal-command" data-page-index="1" type="button"><span>02</span><b>Goals</b><small>Goals and principles</small></button>
      <button class="terminal-command" data-page-index="2" type="button"><span>03</span><b>Morning</b><small>Morning routine</small></button>
      <button class="terminal-command" data-page-index="3" type="button"><span>04</span><b>Evening</b><small>Afternoon and night</small></button>
      <button class="terminal-command" data-page-index="4" type="button"><span>05</span><b>Food I</b><small>Protein and whole grains</small></button>
      <button class="terminal-command" data-page-index="5" type="button"><span>06</span><b>Food II</b><small>Vegetables and limits</small></button>
      <button class="terminal-command" data-page-index="6" type="button"><span>07</span><b>Weekly</b><small>Weekly meal plan</small></button>
      <button class="terminal-command" data-page-index="7" type="button"><span>08</span><b>Tracking</b><small>Measurement and safety</small></button>
      <button class="terminal-command" data-page-index="8" type="button"><span>09</span><b>Checklist</b><small>Daily checklist</small></button>
    </div></section></div>
  </section>
  <section aria-labelledby="toolsModalTitle" aria-modal="true" class="terminal-modal" hidden id="toolsModal" role="dialog">
    <header class="terminal-modal__header"><div><span class="terminal-modal__eyebrow">TERMINAL GROUP</span><h2 id="toolsModalTitle">🧰 Tools</h2><p>Choose a terminal utility</p></div><button aria-label="Close" class="terminal-icon-button" data-close-terminal-modal type="button">×</button></header>
    <div class="terminal-modal__body"><section class="terminal-control-section"><h3>Available tools</h3><div class="terminal-command-grid">
      <button class="terminal-command terminal-command--primary" data-open-terminal-modal="exerciseModal" type="button"><span>🏃</span><b>Exercise</b><small>Walking and breathing workspaces</small></button>
      <button class="terminal-command" data-open-terminal-modal="calculatorModal" type="button"><span>🧮</span><b>Calculator</b><small>BMI, BMR, BSR, body fat and live weight</small></button>
      <button class="terminal-command" data-open-terminal-modal="plannerModal" type="button"><span>🗓</span><b>AIT – Health Planner</b><small>Profile-based target, food, fasting and lifestyle planning</small></button>
    </div></section></div>
  </section>
  <section aria-labelledby="exerciseModalTitle" aria-modal="true" class="terminal-modal" hidden id="exerciseModal" role="dialog">
    <header class="terminal-modal__header"><div><span class="terminal-modal__eyebrow">TOOLS / EXERCISE</span><h2 id="exerciseModalTitle">🏃 Exercise</h2><p>Open a guided full-screen workspace</p></div><div class="terminal-header-actions"><button id="terminalToolsTrigger" class="terminal-back-button" data-open-terminal-modal="toolsModal" type="button">← Tools</button><button aria-label="Close" class="terminal-icon-button" data-close-terminal-modal type="button">×</button></div></header>
    <div class="terminal-modal__body"><section class="terminal-control-section"><h3>Exercise tools</h3><div class="terminal-command-grid">
      <button class="terminal-command terminal-command--primary" data-exercise-src="exercise/walking/index.html" data-exercise-title="Walking Exercise" type="button"><span>🚶</span><b>Walking</b><small>Warm-up, power walk and cool-down timer</small></button>
      <button class="terminal-command" data-exercise-src="exercise/breathing/index.html" data-exercise-title="Breathing Exercise" type="button"><span>🫁</span><b>Breathing</b><small>Guided breathing timer and relaxation cycles</small></button>
    </div></section></div>
  </section>
  <section aria-labelledby="calculatorModalTitle" aria-modal="true" class="terminal-modal" hidden id="calculatorModal" role="dialog">
    <header class="terminal-modal__header"><div><span class="terminal-modal__eyebrow">TOOLS / CALCULATOR</span><h2 id="calculatorModalTitle">🧮 Calculator</h2><p>Open a full-screen health calculation workspace</p></div><div class="terminal-header-actions"><button class="terminal-back-button" data-open-terminal-modal="toolsModal" type="button">← Tools</button><button aria-label="Close" class="terminal-icon-button" data-close-terminal-modal type="button">×</button></div></header>
    <div class="terminal-modal__body"><section class="terminal-control-section"><h3>Health calculators</h3><div class="terminal-command-grid">
      <button class="terminal-command terminal-command--primary" data-exercise-src="calculator/bmi/index.html" data-exercise-title="BMI Calculator" type="button"><span>⚖</span><b>BMI</b><small>Age-aware body mass index screening</small></button>
      <button class="terminal-command" data-exercise-src="calculator/bmr/index.html" data-exercise-title="BMR Calculator" type="button"><span>🔥</span><b>BMR</b><small>Basal energy and daily calorie estimate</small></button>
      <button class="terminal-command" data-exercise-src="calculator/bsr/index.html" data-exercise-title="Body Shape Ratio Calculator" type="button"><span>📐</span><b>BSR</b><small>Waist-to-height and waist-to-hip screening</small></button>
      <button class="terminal-command" data-exercise-src="calculator/fat/index.html" data-exercise-title="Body Fat Calculator" type="button"><span>◒</span><b>Fat</b><small>Estimated body-fat percentage and fat mass</small></button>
      <button class="terminal-command" data-exercise-src="calculator/live-weight/index.html" data-exercise-title="Live Weight Calculator" type="button"><span>◎</span><b>Live Weight</b><small>Dynamic healthy and target-weight planning</small></button>
    </div></section></div>
  </section>
  <section aria-labelledby="plannerModalTitle" aria-modal="true" class="terminal-modal" hidden id="plannerModal" role="dialog">
    <header class="terminal-modal__header">
      <div>
        <span class="terminal-modal__eyebrow">TOOLS / PLANNER</span>
        <h2 id="plannerModalTitle">🗓 AIT – Health Planner</h2>
        <p>Manage profiles and generated health-plan reports</p>
      </div>
      <div class="terminal-header-actions">
        <button class="terminal-back-button" data-open-terminal-modal="toolsModal" type="button">← Tools</button>
        <button aria-label="Close" class="terminal-icon-button" data-close-terminal-modal type="button">×</button>
      </div>
    </header>
    <div class="terminal-modal__body">
      <section class="terminal-control-section">
        <h3>Planner modules</h3>
        <div class="terminal-command-grid">
          <button
            class="terminal-command terminal-command--primary"
            data-exercise-src="planner/health-planner/index.html?module=profilesModule"
            data-exercise-title="AIT – Health Planner / Profile"
            data-parent-modal="plannerModal"
            data-parent-label="AIT Planner"
            data-workspace-kicker="TOOLS / AIT HEALTH PLANNER / PROFILE"
            type="button">
            <span>👤</span>
            <b>Profile</b>
            <small>Profile list, create/edit workspace and plan generation</small>
          </button>
          <button
            class="terminal-command"
            data-exercise-src="planner/health-planner/index.html?module=reportsModule"
            data-exercise-title="AIT – Health Planner / Report"
            data-parent-modal="plannerModal"
            data-parent-label="AIT Planner"
            data-workspace-kicker="TOOLS / AIT HEALTH PLANNER / REPORT"
            type="button">
            <span>📊</span>
            <b>Report</b>
            <small>Open generated plan history and reports</small>
          </button>
        </div>
      </section>
    </div>
  </section>
  <section aria-labelledby="interactionModalTitle" aria-modal="true" class="terminal-modal" hidden id="interactionModal" role="dialog">
    <header class="terminal-modal__header"><div><span class="terminal-modal__eyebrow">TERMINAL GROUP</span><h2 id="interactionModalTitle">✥ Interaction</h2><p>Reading and viewport controls</p></div><button aria-label="Close" class="terminal-icon-button" data-close-terminal-modal type="button">×</button></header>
    <div class="terminal-modal__body">
      <section class="terminal-control-section"><h3>Zoom</h3><div class="terminal-zoom-console"><button data-command="zoom-out" type="button">−</button><output id="terminalZoomLabel">100%</output><button data-command="zoom-in" type="button">+</button><button data-command="zoom-reset" type="button">Reset</button></div></section>
      <section class="terminal-control-section"><h3>Page movement</h3><div class="terminal-command-grid terminal-command-grid--compact">
        <button class="terminal-command" data-command="previous" type="button"><span>←</span><b>Previous</b><small>Previous ebook page</small></button><button class="terminal-command" data-command="next" type="button"><span>→</span><b>Next</b><small>Next ebook page</small></button><button class="terminal-command" data-command="top" type="button"><span>↑</span><b>Up</b><small>Go to first page</small></button><button class="terminal-command" data-command="bottom" type="button"><span>↓</span><b>Down</b><small>Go to last page</small></button>
      </div></section>
      <section class="terminal-control-section"><h3>Reading modes</h3><div class="terminal-toggle-list"><label><span><b>Focus mode</b><small>Hide screen-only helper panels</small></span><input id="terminalFocusMode" type="checkbox"><i></i></label><label><span><b>Full screen</b><small>Use the full browser display</small></span><input id="terminalFullscreen" type="checkbox"><i></i></label></div></section>
    </div>
  </section>
  <section aria-labelledby="appearanceModalTitle" aria-modal="true" class="terminal-modal terminal-modal--wide" hidden id="appearanceModal" role="dialog">
    <header class="terminal-modal__header"><div><span class="terminal-modal__eyebrow">TERMINAL GROUP</span><h2 id="appearanceModalTitle">◉ Appearance</h2><p>Select a terminal theme; your choice is remembered</p></div><button aria-label="Close" class="terminal-icon-button" data-close-terminal-modal type="button">×</button></header>
    <div class="terminal-modal__body"><div class="terminal-theme-grid" id="terminalThemeGrid">
      ${[['dark-glass','Dark Glass','Deep glass terminal'],['classic-light','Classic Light','Bright and clean'],['sapphire','Sapphire','Blue command center'],['emerald','Emerald','Green market terminal'],['royal-purple','Royal Purple','Premium violet glow'],['carbon-oled','Carbon OLED','Maximum contrast'],['crimson','Crimson','Warm red terminal'],['coffee','Coffee','Warm reading palette'],['aurora','Aurora','Teal violet glow']].map(([v,n,d])=>`<button data-theme-value="${v}" type="button"><span class="terminal-theme-swatch" data-swatch="${v}"><i></i><i></i><i></i></span><b>${n}</b><small>${d}</small></button>`).join('')}
    </div></div>
  </section>
</div>
<section class="terminal-exercise-shell no-print" id="terminalExerciseShell" aria-hidden="true">
  <header class="terminal-workspace-nav">
    <div class="terminal-workspace-nav__history">
      <button class="terminal-nav-icon" id="terminalWorkspaceBack" type="button" aria-label="Back" title="Back">←</button>
      <button class="terminal-nav-icon" id="terminalWorkspaceForward" type="button" aria-label="Forward" title="Forward">→</button>
    </div>
    <nav class="terminal-workspace-breadcrumb" id="terminalWorkspaceBreadcrumb" aria-label="Workspace breadcrumb"></nav>
    <div class="terminal-workspace-nav__actions">
      <button class="terminal-nav-button" id="terminalWorkspaceHome" type="button">⌂ Back to Terminal</button>
      <button class="terminal-nav-icon" id="terminalWorkspaceTerminal" type="button" aria-label="Open terminal" title="Open terminal">☰</button>
      <button class="terminal-nav-icon" id="terminalExerciseClose" type="button" aria-label="Close workspace" title="Close">×</button>
    </div>
  </header>
  <iframe id="terminalExerciseFrame" title="Exercise workspace" loading="eager"></iframe>
</section>`;
})();
