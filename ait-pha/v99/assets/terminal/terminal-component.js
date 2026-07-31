(() => {
  'use strict';
  const config = window.AITPHATerminalConfig || {};
  const mount = document.getElementById('terminalComponentMount');
  if (!mount) return;
  const groupMarkup = (config.groups || []).map(group => `
    <button class="terminal-group-card" data-open-terminal-modal="${group.id}" type="button">
      <span class="terminal-group-card__icon">${group.icon}</span><span><b>${group.title}</b><small>${group.description}</small></span><i>→</i>
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
  <div class="terminal-dock__groups">${groupMarkup}</div>
  <footer class="terminal-dock__footer"><span class="terminal-live-dot"></span><span id="terminalActiveTheme">Dark Glass active</span></footer>
</aside>
<div aria-hidden="true" class="terminal-modal-shell no-print" id="terminalModalShell">
  <button aria-label="Close modal" class="terminal-modal-backdrop" id="terminalModalBackdrop" tabindex="-1" type="button"></button>
  <section aria-labelledby="workspaceModalTitle" aria-modal="true" class="terminal-modal" hidden id="workspaceModal" role="dialog">
    <header class="terminal-modal__header"><div><span class="terminal-modal__eyebrow">TERMINAL GROUP</span><h2 id="workspaceModalTitle">⚡ Workspace</h2><p>Output and paper commands</p></div><button aria-label="Close" class="terminal-icon-button" data-close-terminal-modal type="button">×</button></header>
    <div class="terminal-modal__body">
      <section class="terminal-control-section"><h3>Output</h3><div class="terminal-command-grid">
        <button class="terminal-command terminal-command--primary" data-command="print" type="button"><span>🖨</span><b>Color Print</b><small>Print using selected paper</small></button>
        <button class="terminal-command" data-command="image" type="button"><span>📷</span><b>A0 Image</b><small>Open high-resolution JPG export</small></button>
      </div></section>
      <section class="terminal-control-section"><h3>Paper size</h3><div class="terminal-segment" id="terminalPaperSegment">
        <button data-paper-command="a0" type="button">A0</button><button data-paper-command="a4" type="button">A4</button><button data-paper-command="a5" type="button">A5</button>
      </div></section>
    </div>
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
      <button class="terminal-command" data-open-terminal-modal="plannerModal" type="button"><span>🗓</span><b>Integrated Health Progress Planner</b><small>Metrics, food-energy and lifestyle plans</small></button>
    </div></section></div>
  </section>
  <section aria-labelledby="exerciseModalTitle" aria-modal="true" class="terminal-modal" hidden id="exerciseModal" role="dialog">
    <header class="terminal-modal__header"><div><span class="terminal-modal__eyebrow">TOOLS / EXERCISE</span><h2 id="exerciseModalTitle">🏃 Exercise</h2><p>Open a guided full-screen workspace</p></div><div class="terminal-header-actions"><button class="terminal-back-button" data-open-terminal-modal="toolsModal" type="button">← Tools</button><button aria-label="Close" class="terminal-icon-button" data-close-terminal-modal type="button">×</button></div></header>
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
    <header class="terminal-modal__header"><div><span class="terminal-modal__eyebrow">TOOLS / PLANNER</span><h2 id="plannerModalTitle">🗓 Integrated Health Progress Planner</h2><p>Build coordinated weekly and monthly targets from current to desired health metrics</p></div><div class="terminal-header-actions"><button class="terminal-back-button" data-open-terminal-modal="toolsModal" type="button">← Tools</button><button aria-label="Close" class="terminal-icon-button" data-close-terminal-modal type="button">×</button></div></header>
    <div class="terminal-modal__body"><section class="terminal-control-section"><h3>Three coordinated planners</h3><div class="terminal-command-grid">
      <button class="terminal-command terminal-command--primary" data-exercise-src="planner/body-metrics/index.html" data-exercise-title="Body Metrics Roadmap" data-parent-modal="plannerModal" data-parent-label="Planner" data-workspace-kicker="TOOLS / PLANNER / BODY METRICS" type="button"><span>🎯</span><b>Body Metrics Roadmap</b><small>Current and target BMI, BMR, BSR, fat and milestone schedule</small></button>
      <button class="terminal-command" data-exercise-src="planner/nutrition-energy/index.html" data-exercise-title="Nutrition & Energy Planner" data-parent-modal="plannerModal" data-parent-label="Planner" data-workspace-kicker="TOOLS / PLANNER / NUTRITION" type="button"><span>🥗</span><b>Nutrition & Energy Planner</b><small>Food pattern, energy budget and weekly/monthly nutrition goals</small></button>
      <button class="terminal-command" data-exercise-src="planner/lifestyle-routine/index.html" data-exercise-title="Lifestyle Routine Planner" data-parent-modal="plannerModal" data-parent-label="Planner" data-workspace-kicker="TOOLS / PLANNER / LIFESTYLE" type="button"><span>🌿</span><b>Lifestyle Routine Planner</b><small>Walking, breathing and sun-bath schedule with progressive targets</small></button>
    </div></section></div>
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
  <header><button class="terminal-back-button" id="terminalExerciseBack" type="button">← Exercise</button><div><span>TOOLS / EXERCISE</span><h2 id="terminalExerciseTitle">Exercise Workspace</h2></div><button class="terminal-icon-button" id="terminalExerciseClose" type="button" aria-label="Close exercise workspace">×</button></header>
  <iframe id="terminalExerciseFrame" title="Exercise workspace" loading="eager"></iframe>
</section>`;
})();
