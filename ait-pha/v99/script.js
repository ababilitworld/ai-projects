(() => {
  'use strict';
  const body = document.body;
  const book = document.getElementById('book');
  const select = document.getElementById('paperSize');
  const pages = [...document.querySelectorAll('.paper-page')];
  const zoomLabel = document.getElementById('zoomLabel');
  const status = document.getElementById('layoutStatus');
  const pageCount = document.getElementById('pageCount');
  let userZoom = 1;
  let resizeTimer = 0;

  const pageRules = {
    a0: '@page{size:A0 portrait;margin:0}',
    a4: '@page{size:A4 portrait;margin:0}',
    a5: '@page{size:A5 portrait;margin:0}'
  };
  const dynamic = document.createElement('style');
  dynamic.id = 'dynamic-page-rule';
  document.head.appendChild(dynamic);

  pages.forEach((page, i) => {
    const n = page.querySelector('.folio-number');
    if (n) n.textContent = `পৃষ্ঠা ${i + 1} / ${pages.length}`;
  });
  if (pageCount) pageCount.textContent = `${pages.length} পৃষ্ঠা`;

  function updateResponsivePreview() {
    if (window.matchMedia('print').matches) return;

    const isPhoneOrTablet = window.innerWidth <= 900;
    if (!isPhoneOrTablet) {
      body.style.removeProperty('--preview-scale');
      return;
    }

    const paperWidthsMm = { a0: 841, a4: 210, a5: 148 };
    const selected = body.dataset.paper || 'a4';
    const paperWidthMm = paperWidthsMm[selected] || 210;
    const availableWidth = Math.max(240, window.innerWidth - 16);
    const cssPixelsPerMm = 96 / 25.4;
    const previewScale = availableWidth / (paperWidthMm * cssPixelsPerMm);
    body.style.setProperty('--preview-scale', String(previewScale));
  }

  function applyZoom() {
    updateResponsivePreview();
    book.style.transform = `scale(${userZoom})`;
    book.style.marginBottom = `${Math.max(34, (userZoom - 1) * book.offsetHeight + 34)}px`;
    zoomLabel.textContent = `${Math.round(userZoom * 100)}%`;
  }

  function validateLayout() {
    const overflowing = [];
    document.querySelectorAll('.page-body').forEach((el, i) => {
      if (el.scrollHeight > el.clientHeight + 2 || el.scrollWidth > el.clientWidth + 2) overflowing.push(i + 1);
    });
    if (overflowing.length) {
      if (status) { status.textContent = `⚠ Content overflow: page ${overflowing.join(', ')}`; status.className = 'layout-bad'; }
    } else {
      if (status) { status.textContent = '✓ সব পৃষ্ঠার content সম্পূর্ণ দৃশ্যমান'; status.className = 'layout-ok'; }
    }
  }

  function setPaper(size) {
    if (!pageRules[size]) size = 'a4';
    body.dataset.paper = size;
    select.value = size;
    dynamic.textContent = pageRules[size];
    localStorage.setItem('heart-routine-paper', size);
    userZoom = 1;
    updateResponsivePreview();
    applyZoom();
    requestAnimationFrame(validateLayout);
  }

  select.addEventListener('change', e => setPaper(e.target.value));
  document.getElementById('zoomIn').addEventListener('click', () => { userZoom = Math.min(2.2, userZoom + .1); applyZoom(); });
  document.getElementById('zoomOut').addEventListener('click', () => { userZoom = Math.max(.35, userZoom - .1); applyZoom(); });
  document.getElementById('resetZoom').addEventListener('click', () => { userZoom = 1; applyZoom(); });
  document.getElementById('printBtn').addEventListener('click', () => {
    dynamic.textContent = pageRules[body.dataset.paper] || pageRules.a4;
    document.documentElement.classList.add('print-preparing');
    document.getElementById('appHeader')?.classList.remove('controls-open');
    document.getElementById('exerciseMenu')?.classList.remove('is-open');
    book.style.transform = 'none';
    book.style.marginBottom = '0';
    window.print();
  });

  const terminalPrintSelectors = '#terminalLauncher,#terminalDock,#terminalDockBackdrop,#terminalModalShell,#jpgPanel';
  function suppressTerminalForOutput() {
    document.querySelectorAll(terminalPrintSelectors).forEach(element => {
      element.dataset.outputDisplay = element.style.display || '';
      element.style.setProperty('display', 'none', 'important');
      element.style.setProperty('visibility', 'hidden', 'important');
      element.style.setProperty('opacity', '0', 'important');
    });
  }
  function restoreTerminalAfterOutput() {
    document.querySelectorAll(terminalPrintSelectors).forEach(element => {
      element.style.removeProperty('display');
      element.style.removeProperty('visibility');
      element.style.removeProperty('opacity');
      delete element.dataset.outputDisplay;
    });
  }

  window.addEventListener('beforeprint', () => {
    dynamic.textContent = pageRules[body.dataset.paper] || pageRules.a4;
    document.documentElement.classList.add('print-preparing');
    suppressTerminalForOutput();
    book.style.transform = 'none';
    book.style.marginBottom = '0';
  });

  window.addEventListener('afterprint', () => {
    document.documentElement.classList.remove('print-preparing');
    restoreTerminalAfterOutput();
    applyZoom();
  });

  window.addEventListener('load', () => {
    updateResponsivePreview();
    applyZoom();
    validateLayout();
  });

  window.addEventListener('resize', () => {
    clearTimeout(resizeTimer);
    resizeTimer = window.setTimeout(() => {
      if (window.innerWidth <= 900 && userZoom < 1) userZoom = 1;
      updateResponsivePreview();
      applyZoom();
      validateLayout();
    }, 80);
  });


  // ---------------- SINGLE A0 COMPOSITE DSLR JPG EXPORT ----------------
  const jpgBtn = document.getElementById('jpgBtn');
  const jpgPanel = document.getElementById('jpgPanel');
  const jpgDpi = document.getElementById('jpgDpi');
  const jpgQuality = document.getElementById('jpgQuality');
  const downloadJpg = document.getElementById('downloadJpg');
  const exportProgress = document.getElementById('exportProgress');
  const exportBar = document.getElementById('exportBar');

  function openJpgPanel() {
    jpgPanel.hidden = false;
    exportProgress.textContent = 'সব ৯টি পৃষ্ঠা নিয়ে A0 poster তৈরির জন্য প্রস্তুত';
    exportBar.style.width = '0%';
  }
  function closeJpgPanel() {
    if (!downloadJpg.disabled) jpgPanel.hidden = true;
  }
  jpgBtn.addEventListener('click', openJpgPanel);
  document.getElementById('closeJpgPanel').addEventListener('click', closeJpgPanel);
  document.getElementById('cancelJpg').addEventListener('click', closeJpgPanel);
  jpgPanel.addEventListener('click', e => { if (e.target === jpgPanel) closeJpgPanel(); });

  function downloadBlob(blob, filename) {
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = filename;
    document.body.appendChild(a);
    a.click();
    a.remove();
    setTimeout(() => URL.revokeObjectURL(url), 30000);
  }

  function canvasToBlob(canvas, quality) {
    return new Promise((resolve, reject) => {
      canvas.toBlob(blob => blob ? resolve(blob) : reject(new Error('JPG encoding failed')), 'image/jpeg', quality);
    });
  }

  async function ensureExporter() {
    if (window.html2canvas) return;
    throw new Error('JPG exporter library load হয়নি। Internet connection চালু রেখে page reload করুন।');
  }

  function buildA0Poster() {
    const old = document.getElementById('a0CompositeStage');
    if (old) old.remove();

    const stage = document.createElement('section');
    stage.id = 'a0CompositeStage';
    stage.className = 'a0-composite-stage';
    stage.setAttribute('aria-hidden', 'true');

    const heading = document.createElement('header');
    heading.className = 'a0-composite-heading';
    heading.innerHTML = '<b>হৃদ্‌স্বাস্থ্য উন্নয়নের দৈনিক রুটিন ও খাদ্য পরিকল্পনা</b><span>সম্পূর্ণ ৯-পৃষ্ঠার A0 রেফারেন্স পোস্টার</span>';
    stage.appendChild(heading);

    const grid = document.createElement('div');
    grid.className = 'a0-composite-grid';
    stage.appendChild(grid);

    pages.forEach((page, index) => {
      const sourceArt = page.querySelector('.page-art');
      const cell = document.createElement('article');
      cell.className = 'a0-composite-cell';
      cell.dataset.page = String(index + 1);

      const clone = sourceArt.cloneNode(true);
      clone.classList.add('a0-composite-page-art');
      clone.style.transform = 'none';
      clone.style.left = '0';
      clone.style.top = '0';
      clone.style.boxShadow = 'none';
      cell.appendChild(clone);
      grid.appendChild(cell);
    });

    document.body.appendChild(stage);

    // Scale every complete 210×297 mm ebook page into its A0 grid cell.
    [...stage.querySelectorAll('.a0-composite-cell')].forEach(cell => {
      const art = cell.querySelector('.a0-composite-page-art');
      const naturalWidth = art.offsetWidth;
      const naturalHeight = art.offsetHeight;
      const availableWidth = cell.clientWidth;
      const availableHeight = cell.clientHeight;
      const scale = Math.min(availableWidth / naturalWidth, availableHeight / naturalHeight);
      art.style.transformOrigin = 'top left';
      art.style.transform = `scale(${scale})`;
      art.style.left = `${(availableWidth - naturalWidth * scale) / 2}px`;
      art.style.top = `${(availableHeight - naturalHeight * scale) / 2}px`;
    });

    return stage;
  }

  async function exportCompositeA0(dpi, quality) {
    await ensureExporter();
    await document.fonts.ready;

    exportProgress.textContent = 'সব ৯টি পূর্ণ পৃষ্ঠা A0 layout-এ সাজানো হচ্ছে…';
    exportBar.style.width = '12%';
    const stage = buildA0Poster();
    await new Promise(resolve => requestAnimationFrame(() => requestAnimationFrame(resolve)));

    const targetWidth = Math.round(841 / 25.4 * dpi);
    const targetHeight = Math.round(1189 / 25.4 * dpi);
    const scale = targetWidth / stage.offsetWidth;

    exportProgress.textContent = `সম্পূর্ণ A0 poster ${targetWidth.toLocaleString()} × ${targetHeight.toLocaleString()} px render হচ্ছে…`;
    exportBar.style.width = '28%';

    const canvas = await window.html2canvas(stage, {
      backgroundColor: '#fffdf7',
      scale,
      width: stage.offsetWidth,
      height: stage.offsetHeight,
      windowWidth: stage.offsetWidth,
      windowHeight: stage.offsetHeight,
      scrollX: 0,
      scrollY: 0,
      useCORS: true,
      allowTaint: false,
      logging: false,
      imageTimeout: 30000,
      removeContainer: true,
      onclone: clonedDoc => {
        clonedDoc.querySelectorAll(
          '#terminalLauncher,#terminalDock,#terminalDockBackdrop,#terminalModalShell,#jpgPanel,#legacyControlBridge,' +
          '.terminal-launcher,.terminal-dock,.terminal-dock-backdrop,.terminal-modal-shell,.terminal-modal,.terminal-modal-backdrop,.no-print'
        ).forEach(element => element.remove());

        const clonedStage = clonedDoc.getElementById('a0CompositeStage');
        if (clonedStage) {
          clonedStage.querySelectorAll('.no-print,.terminal-launcher,.terminal-dock,.terminal-modal').forEach(element => element.remove());
          clonedStage.style.position = 'absolute';
          clonedStage.style.left = '0';
          clonedStage.style.top = '0';
          clonedStage.style.visibility = 'visible';
          clonedStage.style.zIndex = '1';
        }
      }
    });
    exportBar.style.width = '82%';

    let output = canvas;
    if (canvas.width !== targetWidth || canvas.height !== targetHeight) {
      output = document.createElement('canvas');
      output.width = targetWidth;
      output.height = targetHeight;
      const ctx = output.getContext('2d', { alpha: false });
      ctx.fillStyle = '#fffdf7';
      ctx.fillRect(0, 0, targetWidth, targetHeight);
      ctx.drawImage(canvas, 0, 0, targetWidth, targetHeight);
    }

    exportProgress.textContent = 'JPG encode ও download প্রস্তুত হচ্ছে…';
    exportBar.style.width = '92%';
    const blob = await canvasToBlob(output, quality);
    downloadBlob(blob, `heart-routine-complete-9-page-A0-${dpi}dpi-${targetWidth}x${targetHeight}.jpg`);

    stage.remove();
    output.width = 1; output.height = 1;
    if (canvas !== output) { canvas.width = 1; canvas.height = 1; }
    exportBar.style.width = '100%';
  }

  downloadJpg.addEventListener('click', async () => {
    const dpi = Number(jpgDpi.value || 300);
    const quality = Number(jpgQuality.value || .98);
    downloadJpg.disabled = true;
    document.body.classList.add('is-exporting');
    suppressTerminalForOutput();
    exportBar.style.width = '2%';

    try {
      await exportCompositeA0(dpi, quality);
      exportProgress.textContent = '✓ সব ৯টি page নিয়ে একটি সম্পূর্ণ A0 JPG download হয়েছে';
    } catch (error) {
      console.error(error);
      const stage = document.getElementById('a0CompositeStage');
      if (stage) stage.remove();
      exportProgress.textContent = `⚠ ${error.message || 'Export ব্যর্থ হয়েছে'} — 240 বা 180 DPI দিয়ে আবার চেষ্টা করুন।`;
    } finally {
      downloadJpg.disabled = false;
      document.body.classList.remove('is-exporting');
      restoreTerminalAfterOutput();
    }
  });


  setPaper(localStorage.getItem('heart-routine-paper') || 'a4');
})();


// V9 responsive sticky header interactions.
(() => {
  const appHeader = document.getElementById('appHeader');
  const menuToggle = document.getElementById('headerMenuToggle');
  const controls = document.getElementById('headerControls');
  const exerciseMenu = document.getElementById('exerciseMenu');
  const exerciseToggle = document.getElementById('exerciseMenuToggle');
  const progressBar = document.getElementById('headerProgressBar');
  const menuBackdrop = document.getElementById('headerMenuBackdrop');

  if (!appHeader) return;

  const setControlsOpen = (open) => {
    appHeader.classList.toggle('controls-open', open);
    menuToggle?.setAttribute('aria-expanded', String(open));
    document.body.classList.toggle('mobile-tools-open', open && window.innerWidth <= 720);
  };

  const setExerciseOpen = (open) => {
    exerciseMenu?.classList.toggle('is-open', open);
    exerciseToggle?.setAttribute('aria-expanded', String(open));
  };

  menuToggle?.addEventListener('click', (event) => {
    event.stopPropagation();
    setControlsOpen(!appHeader.classList.contains('controls-open'));
  });

  menuBackdrop?.addEventListener('click', () => {
    setExerciseOpen(false);
    setControlsOpen(false);
  });

  exerciseToggle?.addEventListener('click', (event) => {
    event.stopPropagation();
    setExerciseOpen(!exerciseMenu.classList.contains('is-open'));
  });

  document.addEventListener('click', (event) => {
    if (controls && !appHeader.contains(event.target)) setControlsOpen(false);
    if (exerciseMenu && !exerciseMenu.contains(event.target)) setExerciseOpen(false);
  });

  document.addEventListener('keydown', (event) => {
    if (event.key !== 'Escape') return;
    setExerciseOpen(false);
    setControlsOpen(false);
    menuToggle?.focus();
  });

  const updateHeaderState = () => {
    document.body.classList.toggle('header-scrolled', window.scrollY > 24);
    const scrollable = document.documentElement.scrollHeight - window.innerHeight;
    const progress = scrollable > 0 ? Math.min(100, (window.scrollY / scrollable) * 100) : 0;
    if (progressBar) progressBar.style.width = `${progress}%`;
  };

  window.addEventListener('scroll', updateHeaderState, { passive: true });
  window.addEventListener('resize', () => {
    if (window.innerWidth > 1180) setControlsOpen(false);
    if (window.innerWidth > 720) document.body.classList.remove('mobile-tools-open');
  });
  updateHeaderState();
})();



// V99.5 rebuilt floating terminal, grouped command modals and appearance themes.
(() => {
  const root = document.documentElement;
  const launcher = document.getElementById('terminalLauncher');
  const dock = document.getElementById('terminalDock');
  const dockBackdrop = document.getElementById('terminalDockBackdrop');
  const dockClose = document.getElementById('terminalDockClose');
  const shell = document.getElementById('terminalModalShell');
  const modalBackdrop = document.getElementById('terminalModalBackdrop');
  const activeThemeLabel = document.getElementById('terminalActiveTheme');
  if (!launcher || !dock || !shell) return;

  const themes = {'dark-glass':'Dark Glass','classic-light':'Classic Light',sapphire:'Sapphire',emerald:'Emerald','royal-purple':'Royal Purple','carbon-oled':'Carbon OLED',crimson:'Crimson',coffee:'Coffee',aurora:'Aurora'};
  let lastFocus = launcher;
  const pages = () => [...document.querySelectorAll('.paper-page')];

  function setDock(open){ dock.classList.toggle('open',open); dockBackdrop?.classList.toggle('open',open); launcher.setAttribute('aria-expanded',String(open)); dock.setAttribute('aria-hidden',String(!open)); document.body.classList.toggle('terminal-ui-open',open || shell.classList.contains('open')); if(open) dockClose?.focus(); }
  function closeModal(){ const open=shell.querySelector('.terminal-modal:not([hidden])'); if(open) open.hidden=true; shell.classList.remove('open'); shell.setAttribute('aria-hidden','true'); document.body.classList.toggle('terminal-ui-open',dock.classList.contains('open')); lastFocus?.focus?.(); }
  function openModal(id){ const modal=document.getElementById(id); if(!modal)return; lastFocus=document.activeElement; shell.querySelectorAll('.terminal-modal').forEach(m=>m.hidden=true); modal.hidden=false; shell.classList.add('open'); shell.setAttribute('aria-hidden','false'); setDock(false); requestAnimationFrame(()=>modal.querySelector('button,[href],input,select')?.focus()); }
  function clickId(id){ document.getElementById(id)?.click(); }
  function syncZoom(){ const value=document.getElementById('zoomLabel')?.textContent || '100%'; const out=document.getElementById('terminalZoomLabel'); if(out)out.textContent=value; }
  function syncPaper(){ const value=document.getElementById('paperSize')?.value || document.body.dataset.paper || 'a4'; document.querySelectorAll('[data-paper-command]').forEach(b=>b.classList.toggle('active',b.dataset.paperCommand===value)); }
  function applyTheme(value,persist=true){ const selected=themes[value]?value:'dark-glass'; root.dataset.theme=selected; root.style.colorScheme=selected==='classic-light'?'light':'dark'; document.querySelectorAll('[data-theme-value]').forEach(b=>{const on=b.dataset.themeValue===selected;b.classList.toggle('active',on);b.setAttribute('aria-pressed',String(on));}); if(activeThemeLabel)activeThemeLabel.textContent=`${themes[selected]} active`; if(persist)localStorage.setItem('heart-routine-theme',selected); syncExerciseTheme(selected); }
  function nearestPageIndex(){ const y=window.scrollY+window.innerHeight*.35; let best=0,dist=Infinity; pages().forEach((p,i)=>{const d=Math.abs(p.offsetTop-y);if(d<dist){dist=d;best=i;}});return best; }
  function goPage(delta){ const list=pages(); if(!list.length)return; const i=Math.max(0,Math.min(list.length-1,nearestPageIndex()+delta)); list[i].scrollIntoView({behavior:'smooth',block:'start'}); }


  const exerciseShell=document.getElementById('terminalExerciseShell');
  const exerciseFrame=document.getElementById('terminalExerciseFrame');
  const exerciseTitle=document.getElementById('terminalExerciseTitle');
  class ReusableWorkspaceNavigator {
    constructor({shell,frame,breadcrumb,backButton,forwardButton,homeButton,terminalButton,closeButton,onHome,onTerminal,onClose,onThemeSync}) {
      this.shell=shell;
      this.frame=frame;
      this.breadcrumb=breadcrumb;
      this.backButton=backButton;
      this.forwardButton=forwardButton;
      this.homeButton=homeButton;
      this.terminalButton=terminalButton;
      this.closeButton=closeButton;
      this.onHome=onHome;
      this.onTerminal=onTerminal;
      this.onClose=onClose;
      this.onThemeSync=onThemeSync;
      this.history=[];
      this.index=-1;
      this.bind();
      this.update();
    }

    bind(){
      this.backButton?.addEventListener('click',()=>this.back());
      this.forwardButton?.addEventListener('click',()=>this.forward());
      this.homeButton?.addEventListener('click',()=>this.home());
      this.terminalButton?.addEventListener('click',()=>this.onTerminal?.());
      this.closeButton?.addEventListener('click',()=>this.close());
      this.breadcrumb?.addEventListener('click',event=>{
        const button=event.target.closest('[data-workspace-history-index]');
        if(!button)return;
        this.go(Number(button.dataset.workspaceHistoryIndex));
      });
    }

    open(state,{replace=false}={}){
      const normalized=this.normalize(state);
      if(replace&&this.index>=0){
        this.history[this.index]=normalized;
      }else{
        this.history=this.history.slice(0,this.index+1);
        this.history.push(normalized);
        this.index=this.history.length-1;
      }
      this.render();
    }

    normalize(state){
      return {
        src:String(state.src||'about:blank'),
        title:String(state.title||'Workspace'),
        breadcrumb:Array.isArray(state.breadcrumb)&&state.breadcrumb.length
          ? state.breadcrumb.map(item=>String(item))
          : ['Workspace',String(state.title||'Workspace')],
        parentModal:String(state.parentModal||'toolsModal'),
        parentLabel:String(state.parentLabel||'Tools')
      };
    }

    render(){
      const state=this.history[this.index];
      if(!state)return;
      this.frame.dataset.parentModal=state.parentModal;
      this.frame.dataset.parentLabel=state.parentLabel;
      this.frame.src=state.src;
      this.shell.classList.add('open');
      this.shell.setAttribute('aria-hidden','false');
      document.body.classList.add('terminal-ui-open');
      this.renderBreadcrumb();
      this.update();
      this.frame.addEventListener('load',()=>this.onThemeSync?.(),{once:true});
    }

    renderBreadcrumb(){
      const state=this.history[this.index];
      if(!this.breadcrumb||!state)return;
      this.breadcrumb.innerHTML=state.breadcrumb.map((label,index)=>{
        const isLast=index===state.breadcrumb.length-1;
        const historyIndex=this.findHistoryIndexForCrumb(state.breadcrumb,index);
        return `<span class="terminal-workspace-breadcrumb__item ${isLast?'is-current':''}">
          ${index?'<i aria-hidden="true">›</i>':''}
          <button type="button" ${isLast||historyIndex<0?'disabled':''} data-workspace-history-index="${historyIndex}">${this.escape(label)}</button>
        </span>`;
      }).join('');
    }

    findHistoryIndexForCrumb(crumbs,crumbIndex){
      const target=crumbs.slice(0,crumbIndex+1).join(' / ');
      for(let i=this.index;i>=0;i--){
        if(this.history[i].breadcrumb.join(' / ')===target)return i;
      }
      return -1;
    }

    back(){
      if(this.index<=0)return;
      this.index--;
      this.render();
    }

    forward(){
      if(this.index>=this.history.length-1)return;
      this.index++;
      this.render();
    }

    go(index){
      if(!Number.isInteger(index)||index<0||index>=this.history.length)return;
      this.index=index;
      this.render();
    }

    home(){
      this.clear();
      this.onHome?.();
    }

    close(){
      this.clear();
      this.onClose?.();
    }

    clear(){
      this.history=[];
      this.index=-1;
      this.frame.src='about:blank';
      this.shell.classList.remove('open');
      this.shell.setAttribute('aria-hidden','true');
      document.body.classList.remove('terminal-ui-open');
      this.renderBreadcrumb();
      this.update();
    }

    update(){
      if(this.backButton)this.backButton.disabled=this.index<=0;
      if(this.forwardButton)this.forwardButton.disabled=this.index<0||this.index>=this.history.length-1;
    }

    escape(value){
      const div=document.createElement('div');
      div.textContent=value;
      return div.innerHTML;
    }
  }

  function syncExerciseTheme(theme=root.dataset.theme||'dark-glass'){ if(exerciseFrame?.contentWindow) exerciseFrame.contentWindow.postMessage({type:'ait-pha-theme',theme},'*'); }
  const workspaceNavigator=new ReusableWorkspaceNavigator({
    shell:exerciseShell,
    frame:exerciseFrame,
    breadcrumb:document.getElementById('terminalWorkspaceBreadcrumb'),
    backButton:document.getElementById('terminalWorkspaceBack'),
    forwardButton:document.getElementById('terminalWorkspaceForward'),
    homeButton:document.getElementById('terminalWorkspaceHome'),
    terminalButton:document.getElementById('terminalWorkspaceTerminal'),
    closeButton:document.getElementById('terminalExerciseClose'),
    onHome:()=>{setDock(true);},
    onTerminal:()=>{setDock(true);},
    onClose:()=>{},
    onThemeSync:()=>syncExerciseTheme()
  });

  function openExercise(button){
    if(!exerciseShell||!exerciseFrame)return;
    closeModal();
    const title=button.dataset.exerciseTitle||'Tool Workspace';
    const kicker=button.dataset.workspaceKicker||'Tools / Workspace';
    const breadcrumb=kicker.split('/').map(part=>part.trim()).filter(Boolean);
    workspaceNavigator.open({
      src:button.dataset.exerciseSrc,
      title,
      breadcrumb:[...breadcrumb,title],
      parentModal:button.dataset.parentModal||(button.closest('#plannerModal')?'plannerModal':button.closest('#calculatorModal')?'calculatorModal':'exerciseModal'),
      parentLabel:button.dataset.parentLabel||(button.closest('#plannerModal')?'AIT Planner':button.closest('#calculatorModal')?'Calculator':'Exercise')
    });
  }

  function closeExercise(){
    workspaceNavigator.back();
  }

  function exitExercise(){
    workspaceNavigator.close();
  }

  function openPlannerDataModule(moduleId,foodId='',foodMode=''){
    const isFood=moduleId==='foodsModule';
    const isProfile=moduleId==='profilesModule';
    if(!isFood&&!isProfile)return;

    closeModal();

    let src='';
    let title='';
    let breadcrumb=[];

    if(isFood){
      const query=foodId
        ? `?edit=${encodeURIComponent(foodId)}`
        : foodMode==='create'
          ? '?create=1'
          : '';
      src=`data-center/food/index.html${query}`;
      title=foodId?'Edit Food':'Food Data Workspace';
      breadcrumb=['Workspace','Data Center','Data','Food',...(foodId?['Edit']:foodMode==='create'?['Create']:[])];
    }else{
      src='planner/health-planner/index.html?module=profilesModule';
      title='Profile List';
      breadcrumb=['Workspace','Data Center','Data','Profile'];
    }

    workspaceNavigator.open({
      src,
      title,
      breadcrumb,
      parentModal:'dataManagerModal',
      parentLabel:'Data'
    });
  }

  function downloadPlannerBackup(){
    const keys=['ait-pha-health-planner-v4','ait-pha-health-planner-v3','heart-routine-theme'];
    const payload={exportedAt:new Date().toISOString(),version:'99.24',storage:{}};
    keys.forEach(key=>{const value=localStorage.getItem(key);if(value!==null)payload.storage[key]=value;});
    const blob=new Blob([JSON.stringify(payload,null,2)],{type:'application/json'});
    const url=URL.createObjectURL(blob);
    const link=document.createElement('a');
    link.href=url;
    link.download=`ait-health-planner-backup-${new Date().toISOString().slice(0,10)}.json`;
    link.click();
    URL.revokeObjectURL(url);
  }

  function importPlannerBackup(file){
    if(!file)return;
    const reader=new FileReader();
    reader.onload=()=>{
      try{
        const payload=JSON.parse(String(reader.result||''));
        if(!payload.storage||typeof payload.storage!=='object')throw new Error('Invalid backup format');
        Object.entries(payload.storage).forEach(([key,value])=>localStorage.setItem(key,String(value)));
        alert('Planner data imported successfully.');
        location.reload();
      }catch(error){alert(`Import failed: ${error.message}`);}
    };
    reader.readAsText(file);
  }

  shell.addEventListener('click',event=>{
    const plannerButton=event.target.closest('[data-planner-module]');
    if(plannerButton){
      event.preventDefault();
      event.stopPropagation();
      const moduleId=plannerButton.getAttribute('data-planner-module');
      openPlannerDataModule(moduleId);
      return;
    }
    const actionButton=event.target.closest('[data-workspace-action]');
    if(!actionButton)return;
    event.preventDefault();
    const action=actionButton.dataset.workspaceAction;
    if(action==='backup'){downloadPlannerBackup();return;}
    if(action==='sync'){localStorage.setItem('ait-health-planner-last-sync',new Date().toISOString());alert('Local planner data synchronized.');return;}
    if(action==='import'){document.getElementById('terminalDataImportFile')?.click();return;}
    if(action==='poster'){document.documentElement.dataset.printMode='poster';closeModal();setTimeout(()=>{window.print();delete document.documentElement.dataset.printMode;},80);}
  });

  document.getElementById('terminalDataImportFile')?.addEventListener('change',event=>{
    importPlannerBackup(event.target.files?.[0]);
    event.target.value='';
  });

  window.addEventListener('message',event=>{
    if(event.data?.type==='ait-pha-workspace-breadcrumb'){
      workspaceNavigator.home();
      openModal(event.data.target||'workspaceModal');
    }
  });

  window.addEventListener('message',event=>{
    if(event.data?.type==='ait-pha-open-terminal')setDock(true);
  });

  window.addEventListener('message',event=>{
    if(event.data?.type==='ait-pha-open-data-center-food'){
      openPlannerDataModule('foodsModule',event.data.foodId||'',event.data.mode||'');
    }
    if(event.data?.type==='ait-pha-food-data-updated'){
      try{exerciseFrame.contentWindow?.postMessage({type:'ait-pha-refresh-food-data'},'*')}catch(error){}
    }
  });

  window.addEventListener('message',e=>{
    if(e.data?.type!=='ait-pha-open-tool'||!e.data.src)return;
    exerciseTitle.textContent=e.data.title||'Tool Workspace';
    exerciseFrame.dataset.parentModal='plannerModal';
    exerciseFrame.dataset.parentLabel='Planner';

    exerciseFrame.src=e.data.src;
    exerciseFrame.addEventListener('load',()=>syncExerciseTheme(),{once:true});
  });


  class DynamicTerminalController{
    constructor(schema,mount){this.schema=schema||{menu:[]};this.mount=mount;this.stack=[];this.bind();this.render();}
    bind(){this.mount?.addEventListener('click',e=>{const back=e.target.closest('[data-dynamic-terminal-back]');if(back){e.preventDefault();this.back();return;}const btn=e.target.closest('[data-dynamic-terminal-item]');if(!btn)return;e.preventDefault();const item=this.find(btn.dataset.dynamicTerminalItem);if(item)this.activate(item);});}
    render(items=this.schema.menu||[],title='Terminal'){
      if(!this.mount)return;
      this.mount.innerHTML=`${this.stack.length?`<button class="dynamic-terminal-back" data-dynamic-terminal-back type="button">← ${this.escape(title)}</button>`:''}${items.map(item=>`<button class="terminal-group-card" data-dynamic-terminal-item="${this.escape(item.id)}" type="button"><span class="terminal-group-card__icon">${this.escape(item.icon||'•')}</span><span><b>${this.escape(item.label||item.id)}</b><small>${this.escape(item.description||'')}</small></span><i>${item.children?.length?'→':'↗'}</i></button>`).join('')}`;
    }
    activate(item){
      if(item.children?.length){this.stack.push(item);this.render(item.children,item.label);return;}
      const a=item.action||{};
      if(a.type==='workspace'){workspaceNavigator.open({src:a.route,title:a.title||item.label,breadcrumb:a.breadcrumb||[...this.stack.map(x=>x.label),item.label],parentModal:'toolsModal',parentLabel:this.stack.at(-1)?.label||'Terminal'});setDock(false);return;}
      if(a.type==='modal'){openModal(a.modalId);return;}
      if(a.type==='command'){
        if(a.command==='backup')downloadPlannerBackup();
        if(a.command==='sync'){localStorage.setItem('ait-health-planner-last-sync',new Date().toISOString());alert('Local planner data synchronized.');}
        if(a.command==='import')document.getElementById('terminalDataImportFile')?.click();
        if(a.command==='print'){setDock(false);setTimeout(()=>clickId('printBtn'),80);}
        if(a.command==='image'){setDock(false);setTimeout(()=>clickId('jpgBtn'),80);}
        if(a.command==='poster'){document.documentElement.dataset.printMode='poster';setDock(false);setTimeout(()=>{window.print();delete document.documentElement.dataset.printMode;},80);}
      }
    }
    back(){this.stack.pop();const p=this.stack.at(-1);this.render(p?.children||this.schema.menu||[],p?.label||'Terminal');}
    find(id,items=this.schema.menu||[]){for(const item of items){if(item.id===id)return item;const found=item.children&&this.find(id,item.children);if(found)return found;}return null;}
    escape(v){const d=document.createElement('div');d.textContent=String(v??'');return d.innerHTML;}
  }
  const dynamicTerminalController=new DynamicTerminalController(window.AIT_TERMINAL_SCHEMA,document.getElementById('dynamicTerminalMenuMount'));

  launcher.addEventListener('click',()=>setDock(!dock.classList.contains('open')));
  document.getElementById('terminalToolsTrigger')?.addEventListener('click',event=>{event.preventDefault();event.stopPropagation();openModal('toolsModal');}); dockClose?.addEventListener('click',()=>setDock(false)); dockBackdrop?.addEventListener('click',()=>setDock(false));
  document.addEventListener('click',event=>{
    const modalTrigger=event.target.closest('[data-open-terminal-modal]');
    if(!modalTrigger)return;
    event.preventDefault();
    event.stopPropagation();
    const modalId=modalTrigger.getAttribute('data-open-terminal-modal');
    if(modalId)openModal(modalId);
  });
  document.querySelectorAll('[data-close-terminal-modal]').forEach(b=>b.addEventListener('click',closeModal)); modalBackdrop?.addEventListener('click',closeModal);
  document.querySelectorAll('[data-theme-value]').forEach(b=>b.addEventListener('click',()=>applyTheme(b.dataset.themeValue)));
  document.querySelectorAll('[data-paper-command]').forEach(b=>b.addEventListener('click',()=>{const s=document.getElementById('paperSize');if(s){s.value=b.dataset.paperCommand;s.dispatchEvent(new Event('change',{bubbles:true}));}syncPaper();}));
  shell.addEventListener('click',e=>{const pageButton=e.target.closest('[data-page-index]');if(pageButton){const list=pages();const index=Number(pageButton.dataset.pageIndex);if(Number.isInteger(index)&&list[index]){closeModal();setTimeout(()=>list[index].scrollIntoView({behavior:'smooth',block:'start'}),80);}return;}const b=e.target.closest('[data-command]');if(!b)return;const c=b.dataset.command;if(c==='print'){closeModal();setTimeout(()=>clickId('printBtn'),80);}if(c==='image'){closeModal();setTimeout(()=>clickId('jpgBtn'),80);}if(c==='top')window.scrollTo({top:0,behavior:'smooth'});if(c==='bottom')window.scrollTo({top:document.documentElement.scrollHeight,behavior:'smooth'});if(c==='zoom-in'){clickId('zoomIn');setTimeout(syncZoom,0);}if(c==='zoom-out'){clickId('zoomOut');setTimeout(syncZoom,0);}if(c==='zoom-reset'){clickId('resetZoom');setTimeout(syncZoom,0);}if(c==='previous')goPage(-1);if(c==='next')goPage(1);});
  document.getElementById('terminalFocusMode')?.addEventListener('change',e=>document.body.classList.toggle('terminal-focus-mode',e.target.checked));
  document.getElementById('terminalCompactHeader')?.addEventListener('change',e=>document.body.classList.toggle('terminal-compact-header',e.target.checked));
  document.getElementById('terminalFullscreen')?.addEventListener('change',async e=>{try{if(e.target.checked&&!document.fullscreenElement)await document.documentElement.requestFullscreen();else if(!e.target.checked&&document.fullscreenElement)await document.exitFullscreen();}catch(err){e.target.checked=!!document.fullscreenElement;}});
  document.addEventListener('fullscreenchange',()=>{const c=document.getElementById('terminalFullscreen');if(c)c.checked=!!document.fullscreenElement;});
  document.addEventListener('keydown',e=>{if(e.key!=='Escape')return;if(exerciseShell?.classList.contains('open'))exitExercise();else if(shell.classList.contains('open'))closeModal();else if(dock.classList.contains('open')){setDock(false);launcher.focus();}});
  window.addEventListener('beforeprint',()=>{setDock(false);closeModal();});
  document.getElementById('paperSize')?.addEventListener('change',syncPaper); document.getElementById('zoomIn')?.addEventListener('click',()=>setTimeout(syncZoom,0)); document.getElementById('zoomOut')?.addEventListener('click',()=>setTimeout(syncZoom,0)); document.getElementById('resetZoom')?.addEventListener('click',()=>setTimeout(syncZoom,0));
  applyTheme(localStorage.getItem('heart-routine-theme')||'dark-glass',false); syncPaper(); syncZoom();
})();


// V99.6 emergency terminal visibility guard.
document.addEventListener('DOMContentLoaded', function () {
  var launcher = document.getElementById('terminalLauncher');
  if (!launcher) return;
  launcher.hidden = false;
  launcher.removeAttribute('hidden');
  launcher.style.setProperty('display','flex','important');
  launcher.style.setProperty('visibility','visible','important');
  launcher.style.setProperty('opacity','1','important');
  launcher.style.setProperty('z-index','2147483647','important');
  launcher.setAttribute('title','Open Workspace, Navigation, Tools, Interaction and Appearance terminal');
});
