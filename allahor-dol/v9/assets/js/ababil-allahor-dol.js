(() => {
  'use strict';

  class AbabilBookTerminal {
    constructor() {
      this.root = document.documentElement;
      this.body = document.body;
      this.terminal = document.getElementById('ababilTerminal');
      this.backdrop = document.getElementById('ababilTerminalBackdrop');
      this.activityDrawer = document.getElementById('ababilActivityDrawer');
      this.activityList = document.getElementById('ababilActivityList');
      this.toastRegion = document.getElementById('ababilToastRegion');
      this.controlModal = document.getElementById('ababilControlModal');
      this.modalTitle = document.getElementById('ababilModalTitle');
      this.modalKicker = document.getElementById('ababilModalKicker');
      this.modalContent = document.getElementById('ababilModalContent');
      this.activities = JSON.parse(localStorage.getItem('ababilBookActivities') || '[]');
      this.notificationsEnabled = true;
      this.pages = [
        ['ababilIntro','Cover & introduction'],['ababilLessons','খিযির (আ.) থেকে শিক্ষা'],
        ['ababilUnity','ঐক্য ও সহযোগিতা'],['ababilRoadmap','কর্মপথ'],
        ['ababilPrinciples','১১টি মূলনীতি'],['ababilDua','সমাপনী দোয়া']
      ];
      this.bindEvents(); this.renderActivities(); this.initTerminalChrome(); this.logActivity('eBook terminal initialized');
    }

    bindEvents() {
      document.getElementById('ababilActivityClose')?.addEventListener('click', () => this.closeActivity());
      document.getElementById('ababilModalClose')?.addEventListener('click', () => this.closeModal());
      this.controlModal?.addEventListener('click', e => { if (e.target === this.controlModal) this.closeModal(); });
      document.addEventListener('keydown', e => { if (e.key === 'Escape') this.closeModal(); });
      document.addEventListener('ababil:terminal-select', e => {
        const detail=e.detail||{};
        if(detail.modal) this.openModal(detail.modal);
        else if(detail.action) this.handleAction(detail.action);
      });
      document.querySelectorAll('[data-target]').forEach(button => button.addEventListener('click', () => this.navigate(button.dataset.target)));
      document.querySelectorAll('[data-action]').forEach(button => button.addEventListener('click', () => this.handleAction(button.dataset.action)));
      document.querySelectorAll('.ababil-section-toggle').forEach(button => button.addEventListener('click', () => this.toggleSection(button)));
      document.querySelectorAll('.ababil-checklist-grid input').forEach(input => input.addEventListener('change', () => this.logActivity(`Checklist updated: ${input.parentElement.textContent.trim()}`)));
      window.addEventListener('afterprint', () => this.resetPrintState());
    }


    initTerminalChrome(){
      const clock=document.getElementById('ababilTerminalClock');
      const theme=document.getElementById('ababilTerminalTheme');
      const updateClock=()=>{if(clock)clock.textContent=new Intl.DateTimeFormat('en-GB',{hour:'2-digit',minute:'2-digit',hour12:false}).format(new Date());};
      const updateTheme=()=>{if(theme){const key=document.documentElement.dataset.theme||'dark-glass';theme.textContent=key.replace(/(^.|-.)/g,s=>s.replace('-',' ').toUpperCase());}};
      updateClock();updateTheme();setInterval(updateClock,30000);
      new MutationObserver(updateTheme).observe(document.documentElement,{attributes:true,attributeFilter:['data-theme']});
    }

    openTerminal(){window.ababilTerminal?.open();}
    closeTerminal(){window.ababilTerminal?.close();}
    navigate(id){const target=document.getElementById(id);if(!target)return;this.closeTerminal();this.closeModal();target.scrollIntoView({behavior:'smooth',block:'start'});this.logActivity(`Navigated to: ${id}`);}
    toggleSection(button){const body=button.nextElementSibling,expanded=button.getAttribute('aria-expanded')==='true';button.setAttribute('aria-expanded',String(!expanded));button.querySelector('b').textContent=expanded?'+':'−';body.hidden=expanded;this.logActivity(`${expanded?'Collapsed':'Expanded'} section`);}

    openModal(type){
      if(type==='workspace') return this.openWorkspacePicker();
      const menus={
        appearance:{title:'Appearance',kicker:'Choose an appearance tool',items:[['Theme','Select Emerald, Midnight or Parchment.','theme'],['Typography','Configure reading font size.','typography']]},
        interaction:{title:'Interaction',kicker:'Choose an interaction tool',items:[['Sections','Expand or collapse book sections.','sections'],['Insight cards','Show or hide insight cards.','cards'],['Highlights','Clear reading highlights.','highlights']]},
        navigation:{title:'Navigation',kicker:'Choose a navigation tool',items:[['Chapters','Select and open a chapter.','chapters'],['Reading position','Jump to top or continue current reading.','position']]},
        notification:{title:'Notification',kicker:'Choose a notification tool',items:[['Reading notifications','Enable or disable notices.','notices'],['Progress reminder','Configure a progress reminder.','reminder'],['Learning tip','Display a learning tip.','tip']]},
        activity:{title:'Activity',kicker:'Choose an activity tool',items:[['Recent activity','Review terminal activity history.','recent'],['Clear activity','Remove saved activity records.','clear']]}
      };
      const menu=menus[type]; if(!menu)return;
      this.closeTerminal(); this.modalTitle.textContent=menu.title; this.modalKicker.textContent=menu.kicker;
      this.modalContent.innerHTML=`<div class="ababil-workspace-picker">${menu.items.map(i=>`<button type="button" data-tool="${i[2]}"><span>${i[0]}</span><small>${i[1]}</small><b>→</b></button>`).join('')}</div>`;
      this.modalContent.querySelectorAll('[data-tool]').forEach(b=>b.addEventListener('click',()=>this.openToolWorkspace(type,b.dataset.tool)));
      this.showModal(); this.logActivity(`Opened ${menu.title} menu`);
    }

    openToolWorkspace(menu,tool){
      const back=`<button type="button" data-back-menu>← ${menu}</button>`;
      const done=(label,action)=>`<button class="ababil-primary-action" type="submit">${label}</button>`;
      this.modalKicker.textContent=`${menu} workspace`; this.modalTitle.textContent=tool.replace(/(^.|-.)/g,s=>s.replace('-',' ').toUpperCase());
      let content='';
      if(menu==='appearance'&&tool==='theme') content=`<form id="toolForm"><section class="ababil-workspace-section"><h3>Theme selection</h3><p>নির্বাচিত theme অনুযায়ী eBook, terminal, modal, cards, controls, print ও image workspace স্বয়ংক্রিয়ভাবে tune হবে।</p><div class="ababil-theme-grid">
${[
['emerald','Emerald','Classic Islamic green','#087454','#0e4f3e'],
['dark-glass','Midnight','Deep premium dark','#07120f','#4bd39d'],
['classic-light','Parchment','Warm book-paper reading','#fffaf0','#6b5124'],
['royal-purple','Royal Amethyst','Elegant purple and gold','#6552c9','#382889'],
['sapphire','Sapphire','Professional blue terminal','#1376a8','#0b4668'],
['crimson','Rosewood','Rich maroon editorial','#9e4058','#642436'],
['carbon-oled','Obsidian Gold','Luxury black and gold','#111317','#d4a84f'],
['aurora','Ocean Teal','Calm aqua reading','#0c8b8f','#07565b'],
['coffee','Sunrise','Warm orange premium','#d86a34','#8e3e1d']
].map((t,i)=>`<label class="ababil-theme-card"><input type="radio" name="value" value="${t[0]}" ${document.documentElement.dataset.theme===t[0]||(!document.documentElement.dataset.theme&&i===0)?'checked':''}><span class="ababil-theme-preview" style="--preview-a:${t[3]};--preview-b:${t[4]}"></span><strong>${t[1]}</strong><small>${t[2]}</small></label>`).join('')}
</div></section><div class="ababil-workspace-actions">${back}${done('Apply Theme')}</div></form>`;
      else if(menu==='appearance') content=`<form id="toolForm"><section class="ababil-workspace-section"><h3>Typography options</h3><label class="ababil-field"><span>Font size</span><select name="value"><option value="14">Small</option><option value="16" selected>Default</option><option value="18">Large</option><option value="20">Extra large</option></select></label></section><div class="ababil-workspace-actions">${back}${done('Apply Typography')}</div></form>`;
      else if(menu==='interaction'&&tool==='sections') content=`<form id="toolForm"><section class="ababil-workspace-section"><h3>Section action</h3><div class="ababil-option-grid"><label><input type="radio" name="value" value="expand" checked> Expand all</label><label><input type="radio" name="value" value="collapse"> Collapse all</label></div></section><div class="ababil-workspace-actions">${back}${done('Apply')}</div></form>`;
      else if(menu==='interaction'&&tool==='cards') content=`<form id="toolForm"><section class="ababil-workspace-section"><h3>Insight card visibility</h3><div class="ababil-option-grid"><label><input type="radio" name="value" value="show" checked> Show</label><label><input type="radio" name="value" value="hide"> Hide</label></div></section><div class="ababil-workspace-actions">${back}${done('Apply')}</div></form>`;
      else if(menu==='interaction') content=`<form id="toolForm"><section class="ababil-workspace-section"><h3>Clear highlights</h3><p>This removes temporary reading highlights.</p></section><div class="ababil-workspace-actions">${back}${done('Clear Highlights')}</div></form>`;
      else if(menu==='navigation'&&tool==='chapters') content=`<form id="toolForm"><section class="ababil-workspace-section"><h3>Page selection</h3><label class="ababil-field"><span>Chapter</span><select name="value">${this.pages.map(p=>`<option value="${p[0]}">${p[1]}</option>`).join('')}</select></label></section><div class="ababil-workspace-actions">${back}${done('Open Chapter')}</div></form>`;
      else if(menu==='navigation') content=`<form id="toolForm"><section class="ababil-workspace-section"><h3>Reading position</h3><div class="ababil-option-grid"><label><input type="radio" name="value" value="top" checked> Book top</label><label><input type="radio" name="value" value="current"> Current position</label></div></section><div class="ababil-workspace-actions">${back}${done('Navigate')}</div></form>`;
      else if(menu==='notification'&&tool==='notices') content=`<form id="toolForm"><section class="ababil-workspace-section"><h3>Notification state</h3><div class="ababil-option-grid"><label><input type="radio" name="value" value="on" checked> Enable</label><label><input type="radio" name="value" value="off"> Disable</label></div></section><div class="ababil-workspace-actions">${back}${done('Save')}</div></form>`;
      else if(menu==='notification'&&tool==='reminder') content=`<form id="toolForm"><section class="ababil-workspace-section"><h3>Progress reminder</h3><label class="ababil-field"><span>Reminder point</span><select name="value"><option value="25">25%</option><option value="50" selected>50%</option><option value="75">75%</option></select></label></section><div class="ababil-workspace-actions">${back}${done('Set Reminder')}</div></form>`;
      else if(menu==='notification') content=`<form id="toolForm"><section class="ababil-workspace-section"><h3>Learning tip</h3><p>শেখা বিষয়কে দৈনন্দিন ছোট কাজে প্রয়োগ করুন।</p></section><div class="ababil-workspace-actions">${back}${done('Show Tip')}</div></form>`;
      else if(menu==='activity'&&tool==='recent') content=`<section class="ababil-workspace-section"><h3>Recent activity</h3><div class="ababil-activity-modal-list">${this.activities.length?this.activities.map(i=>`<div><strong>${this.escapeHtml(i.message)}</strong><br><small>${this.escapeHtml(i.time)}</small></div>`).join(''):'<div>No activity yet.</div>'}</div></section><div class="ababil-workspace-actions">${back}<button class="ababil-primary-action" type="button" data-finish>Done</button></div>`;
      else content=`<form id="toolForm"><section class="ababil-workspace-section"><h3>Clear activity history</h3><p>This action removes all locally stored activity records.</p></section><div class="ababil-workspace-actions">${back}${done('Clear Activity')}</div></form>`;
      this.modalContent.innerHTML=content;
      this.modalContent.querySelector('[data-back-menu]').addEventListener('click',()=>this.openModal(menu));
      const finish=this.modalContent.querySelector('[data-finish]'); if(finish)finish.addEventListener('click',()=>this.closeModal());
      const form=this.modalContent.querySelector('#toolForm'); if(form)form.addEventListener('submit',e=>{e.preventDefault();this.applyTool(menu,tool,new FormData(form));});
      this.logActivity(`Opened ${menu}/${tool} workspace`);
    }

    applyTool(menu,tool,data){
      const value=data.get('value');
      if(menu==='appearance'&&tool==='theme')this.setTheme(value);
      else if(menu==='appearance') {this.root.style.setProperty('--ababil-font-size',`${value}px`);this.logActivity(`Typography set: ${value}px`);}
      else if(menu==='interaction'&&tool==='sections')this.setAllSections(value==='expand');
      else if(menu==='interaction'&&tool==='cards'){this.body.classList.toggle('is-hidden-cards',value==='hide');this.logActivity(`Insight cards ${value}`);}
      else if(menu==='interaction'){this.toast('Highlights cleared');this.logActivity('Highlights cleared');}
      else if(menu==='navigation'&&tool==='chapters')return this.navigate(value);
      else if(menu==='navigation'&&value==='top')window.scrollTo({top:0,behavior:'smooth'});
      else if(menu==='notification'&&tool==='notices'){this.notificationsEnabled=value==='on';this.logActivity(`Notifications ${value}`);}
      else if(menu==='notification'&&tool==='reminder'){localStorage.setItem('ababilProgressReminder',value);this.logActivity(`Progress reminder set: ${value}%`);}
      else if(menu==='notification')this.toast('শেখা বিষয়কে দৈনন্দিন ছোট কাজে প্রয়োগ করুন।');
      else if(menu==='activity'){this.clearActivity();}
      this.closeModal(); this.toast('Settings applied');
    }

    openWorkspacePicker(){
      this.closeTerminal();this.modalTitle.textContent='Workspace';this.modalKicker.textContent='Output control center';
      this.modalContent.innerHTML=`<div class="ababil-workspace-picker">
        <button class="ababil-workspace-choice" type="button" data-workspace="print"><span class="ababil-workspace-icon">⎙</span><h3>Print</h3><p>পৃষ্ঠা নির্বাচন, paper size, orientation, color এবং background নিয়ন্ত্রণ করে প্রিন্ট করুন।</p></button>
        <button class="ababil-workspace-choice" type="button" data-workspace="image"><span class="ababil-workspace-icon">▧</span><h3>Image</h3><p>পৃষ্ঠা নির্বাচন, format, scale এবং background নিয়ন্ত্রণ করে image export করুন।</p></button>
      </div>`;
      this.modalContent.querySelectorAll('[data-workspace]').forEach(b=>b.addEventListener('click',()=>b.dataset.workspace==='print'?this.openPrintWorkspace():this.openImageWorkspace()));
      this.showModal();this.logActivity('Opened Workspace modal');
    }

    pageCheckboxes(prefix){return this.pages.map((p,i)=>`<label class="ababil-check-option"><input type="checkbox" name="${prefix}-pages" value="${p[0]}" ${i===0?'checked':''}> <span>${p[1]}</span></label>`).join('');}

    openPrintWorkspace(){
      this.modalTitle.textContent='Print Workspace';this.modalKicker.textContent='Workspace / Print';
      this.modalContent.innerHTML=`<form class="ababil-workspace-form" id="ababilPrintForm">
        <section class="ababil-workspace-step"><header><b>১</b><h3>Page selection</h3></header><label class="ababil-check-option"><input type="checkbox" id="ababilPrintAll"> <span>সব পৃষ্ঠা নির্বাচন করুন</span></label><div class="ababil-page-options">${this.pageCheckboxes('print')}</div></section>
        <section class="ababil-workspace-step"><header><b>২</b><h3>Print options</h3></header><div class="ababil-option-grid">
          <label class="ababil-field"><span>Paper size</span><select name="paper"><option value="a4">A4</option><option value="a5">A5 / Book</option></select></label>
          <label class="ababil-field"><span>Orientation</span><select name="orientation"><option value="portrait">Portrait</option><option value="landscape">Landscape</option></select></label>
          <label class="ababil-field"><span>Color mode</span><select name="color"><option value="color">Color</option><option value="grayscale">Black & white</option></select></label>
          <label class="ababil-check-option"><input type="checkbox" name="background" checked> <span>Print backgrounds</span></label>
        </div></section>
        <div class="ababil-output-summary">নির্বাচিত পৃষ্ঠাগুলো browser print preview-তে পাঠানো হবে। Printer, copies এবং final destination browser dialog থেকে নির্ধারণ করা যাবে।</div>
        <div class="ababil-workspace-actions"><button type="button" data-back-workspace>← Workspace</button><button class="ababil-primary-action" type="submit">Print</button></div>
      </form>`;
      this.bindSelectAll('ababilPrintAll','print-pages');
      this.modalContent.querySelector('[data-back-workspace]').addEventListener('click',()=>this.openWorkspacePicker());
      this.modalContent.querySelector('#ababilPrintForm').addEventListener('submit',e=>{e.preventDefault();this.executePrint(new FormData(e.currentTarget));});
      this.logActivity('Opened Print workspace');
    }

    openImageWorkspace(){
      this.modalTitle.textContent='Image Workspace';this.modalKicker.textContent='Workspace / Image';
      this.modalContent.innerHTML=`<form class="ababil-workspace-form" id="ababilImageForm">
        <section class="ababil-workspace-step"><header><b>১</b><h3>Page selection</h3></header><label class="ababil-check-option"><input type="checkbox" id="ababilImageAll"> <span>সব পৃষ্ঠা নির্বাচন করুন</span></label><div class="ababil-page-options">${this.pageCheckboxes('image')}</div></section>
        <section class="ababil-workspace-step"><header><b>২</b><h3>Image options</h3></header><div class="ababil-option-grid">
          <label class="ababil-field"><span>Format</span><select name="format"><option value="png">PNG</option><option value="jpeg">JPEG</option><option value="svg">SVG</option></select></label>
          <label class="ababil-field"><span>Scale</span><select name="scale"><option value="1">1× Standard</option><option value="2" selected>2× High quality</option><option value="3">3× Extra high</option></select></label>
          <label class="ababil-field"><span>Page width</span><select name="width"><option value="1240">1240 px</option><option value="1754" selected>1754 px — A4</option><option value="2480">2480 px — Print quality</option></select></label>
          <label class="ababil-field"><span>Background</span><select name="background"><option value="theme">Current theme</option><option value="white">White</option><option value="transparent">Transparent</option></select></label>
        </div></section>
        <div class="ababil-output-summary">প্রতিটি নির্বাচিত page আলাদা image হিসেবে export হবে। একাধিক page নির্বাচন করলে browser একাধিক download শুরু করতে পারে।</div>
        <div class="ababil-workspace-actions"><button type="button" data-back-workspace>← Workspace</button><button class="ababil-primary-action" type="submit">Create Image</button></div>
      </form>`;
      this.bindSelectAll('ababilImageAll','image-pages');
      this.modalContent.querySelector('[data-back-workspace]').addEventListener('click',()=>this.openWorkspacePicker());
      this.modalContent.querySelector('#ababilImageForm').addEventListener('submit',e=>{e.preventDefault();this.executeImage(new FormData(e.currentTarget));});
      this.logActivity('Opened Image workspace');
    }

    bindSelectAll(id,name){const all=this.modalContent.querySelector(`#${id}`),items=[...this.modalContent.querySelectorAll(`input[name="${name}"]`)];all.addEventListener('change',()=>items.forEach(i=>i.checked=all.checked));items.forEach(i=>i.addEventListener('change',()=>all.checked=items.every(x=>x.checked)));}
    selectedPages(formData,name){return formData.getAll(name).filter(id=>document.getElementById(id));}

    executePrint(data){
      const selected=this.selectedPages(data,'print-pages');if(!selected.length){this.toast('কমপক্ষে একটি পৃষ্ঠা নির্বাচন করুন।');return;}
      this.resetPrintState();this.root.dataset.printSize=data.get('paper');this.root.dataset.printOrientation=data.get('orientation');
      this.body.classList.add('ababil-print-selection-active');if(data.get('color')==='grayscale')this.body.classList.add('ababil-print-grayscale');if(!data.get('background'))this.body.classList.add('ababil-print-no-background');
      selected.forEach(id=>document.getElementById(id).classList.add('ababil-print-selected'));this.closeModal();this.logActivity(`Printed ${selected.length} selected page(s)`);setTimeout(()=>window.print(),120);
    }
    resetPrintState(){this.body.classList.remove('ababil-print-selection-active','ababil-print-grayscale','ababil-print-no-background');document.querySelectorAll('.ababil-print-selected').forEach(e=>e.classList.remove('ababil-print-selected'));delete this.root.dataset.printOrientation;}

    async executeImage(data){
      const selected=this.selectedPages(data,'image-pages');if(!selected.length){this.toast('কমপক্ষে একটি পৃষ্ঠা নির্বাচন করুন।');return;}
      const format=data.get('format'),width=Number(data.get('width')),scale=Number(data.get('scale')),background=data.get('background');
      this.toast('Image তৈরি হচ্ছে…');
      for(const id of selected){await this.exportSectionImage(document.getElementById(id),{format,width,scale,background});}
      this.logActivity(`Exported ${selected.length} page image(s) as ${format.toUpperCase()}`);this.closeModal();
    }

    async exportSectionImage(section,options){
      const clone=section.cloneNode(true);clone.querySelectorAll('button,input').forEach(el=>el.remove());
      const rect=section.getBoundingClientRect();const ratio=Math.max(.45,rect.height/Math.max(rect.width,1));const width=options.width;const height=Math.max(900,Math.round(width*ratio));
      const computed=getComputedStyle(this.body);const bg=options.background==='transparent'?'transparent':options.background==='white'?'#ffffff':computed.backgroundColor;
      const styles=[...document.styleSheets].map(sheet=>{try{return [...sheet.cssRules].map(r=>r.cssText).join('\n')}catch(e){return ''}}).join('\n');
      const serialized=new XMLSerializer().serializeToString(clone);
      const svg=`<svg xmlns="http://www.w3.org/2000/svg" width="${width}" height="${height}" viewBox="0 0 ${width} ${height}"><foreignObject width="100%" height="100%"><div xmlns="http://www.w3.org/1999/xhtml" style="box-sizing:border-box;width:${width}px;min-height:${height}px;padding:36px;background:${bg};color:${computed.color};font-family:system-ui,sans-serif"><style>${styles}</style>${serialized}</div></foreignObject></svg>`;
      if(options.format==='svg'){this.downloadBlob(new Blob([svg],{type:'image/svg+xml;charset=utf-8'}),`${section.id}.svg`);return;}
      const url=URL.createObjectURL(new Blob([svg],{type:'image/svg+xml;charset=utf-8'}));
      try{const image=await this.loadImage(url);const canvas=document.createElement('canvas');canvas.width=width*options.scale;canvas.height=height*options.scale;const ctx=canvas.getContext('2d');ctx.scale(options.scale,options.scale);if(options.background!=='transparent'){ctx.fillStyle=bg;ctx.fillRect(0,0,width,height);}ctx.drawImage(image,0,0,width,height);const mime=options.format==='jpeg'?'image/jpeg':'image/png';const blob=await new Promise(resolve=>canvas.toBlob(resolve,mime,.94));this.downloadBlob(blob,`${section.id}.${options.format==='jpeg'?'jpg':'png'}`);}finally{URL.revokeObjectURL(url);}
    }
    loadImage(url){return new Promise((resolve,reject)=>{const i=new Image();i.onload=()=>resolve(i);i.onerror=reject;i.src=url;});}
    downloadBlob(blob,name){if(!blob)return;const a=document.createElement('a'),url=URL.createObjectURL(blob);a.href=url;a.download=name;document.body.appendChild(a);a.click();a.remove();setTimeout(()=>URL.revokeObjectURL(url),1000);}

    showModal(){this.controlModal.classList.add('is-open');this.controlModal.setAttribute('aria-hidden','false');}
    closeModal(){this.controlModal.classList.remove('is-open');this.controlModal.setAttribute('aria-hidden','true');}
    handleAction(action){const a={'theme-emerald':()=>this.setTheme('emerald'),'theme-midnight':()=>this.setTheme('midnight'),'theme-parchment':()=>this.setTheme('parchment'),'font-increase':()=>this.changeFont(1),'font-decrease':()=>this.changeFont(-1),'font-reset':()=>this.resetFont(),'toggle-cards':()=>this.toggleCards(),'expand-all':()=>this.setAllSections(true),'collapse-all':()=>this.setAllSections(false),'clear-highlights':()=>this.toast('Highlights cleared'),'notifications-toggle':()=>this.toggleNotifications(),'progress-alert':()=>this.toast('Reading progress reminder enabled'),'show-tip':()=>this.toast('শেখা বিষয়কে দৈনন্দিন ছোট কাজে প্রয়োগ করুন।'),'show-activity':()=>this.openActivity(),'clear-activity':()=>this.clearActivity()};a[action]?.();}
    setTheme(theme){this.root.dataset.theme=theme;localStorage.setItem('ababilBookTheme',theme);this.logActivity(`Theme changed: ${theme}`);this.toast(`Theme changed to ${theme}`);}
    changeFont(delta){const current=parseInt(getComputedStyle(this.root).getPropertyValue('--ababil-font-size'))||16,next=Math.min(21,Math.max(13,current+delta));this.root.style.setProperty('--ababil-font-size',`${next}px`);this.logActivity(`Font size changed: ${next}px`);}
    resetFont(){this.root.style.setProperty('--ababil-font-size','16px');this.logActivity('Font size reset');}
    toggleCards(){this.body.classList.toggle('is-hidden-cards');this.logActivity('Insight cards toggled');}
    setAllSections(expand){document.querySelectorAll('.ababil-section-toggle').forEach(b=>{b.setAttribute('aria-expanded',String(expand));b.querySelector('b').textContent=expand?'−':'+';b.nextElementSibling.hidden=!expand;});this.logActivity(`${expand?'Expanded':'Collapsed'} all sections`);}
    toggleNotifications(){this.notificationsEnabled=!this.notificationsEnabled;this.logActivity(`Notifications ${this.notificationsEnabled?'enabled':'disabled'}`);this.toast(`Notifications ${this.notificationsEnabled?'enabled':'disabled'}`);}
    searchTerminal(){const q=document.getElementById('ababilTerminalSearch').value.trim().toLowerCase();if(!q)return;const m=[...document.querySelectorAll('[data-target],[data-action],[data-modal]')].find(i=>i.textContent.toLowerCase().includes(q));if(m?.dataset.target)return this.navigate(m.dataset.target);if(m?.dataset.modal)return this.openModal(m.dataset.modal);this.toast(m?`Found: ${m.textContent.trim()}`:'কোনো মিল পাওয়া যায়নি');this.logActivity(`Search: ${q}`);}
    openActivity(){this.closeTerminal();this.activityDrawer.classList.add('is-open');this.activityDrawer.setAttribute('aria-hidden','false');this.renderActivities();}
    closeActivity(){this.activityDrawer.classList.remove('is-open');this.activityDrawer.setAttribute('aria-hidden','true');}
    clearActivity(){this.activities=[];this.saveActivities();this.renderActivities();this.toast('Activity cleared');}
    logActivity(message){this.activities.unshift({message,time:new Date().toLocaleString('bn-BD')});this.activities=this.activities.slice(0,40);this.saveActivities();this.renderActivities();}
    saveActivities(){localStorage.setItem('ababilBookActivities',JSON.stringify(this.activities));}
    renderActivities(){if(!this.activityList)return;this.activityList.innerHTML=this.activities.length?this.activities.map(i=>`<li><strong>${this.escapeHtml(i.message)}</strong><br><small>${this.escapeHtml(i.time)}</small></li>`).join(''):'<li>এখনও কোনো activity নেই।</li>';}
    toast(message){if(!this.notificationsEnabled)return;const n=document.createElement('div');n.className='ababil-toast';n.textContent=message;this.toastRegion.appendChild(n);setTimeout(()=>n.remove(),2600);}
    escapeHtml(value){const d=document.createElement('div');d.textContent=value;return d.innerHTML;}
  }
  document.addEventListener('DOMContentLoaded',()=>{const t=localStorage.getItem('ababilBookTheme');if(t)document.documentElement.dataset.theme=t;new AbabilBookTerminal();});
})();
