(() => {
  'use strict';
  class AitPsaGenericTerminal {
    constructor(options={}){
      this.options={...AitPsaGenericTerminal.defaults,...options,labels:{...AitPsaGenericTerminal.defaults.labels,...(options.labels||{})}};
      this.mount=typeof this.options.mount==='string'?document.querySelector(this.options.mount):this.options.mount;
      if(!this.mount) throw new Error('AIT PSA terminal mount not found.');
      this.render(); this.cache(); this.bind(); this.syncTheme();
    }
    static get defaults(){return{
      mount:'#ababilTerminalMount', id:'aitPsaGenericTerminal', logo:'AIT', title:'Generic Terminal', subtitle:'Local terminal ready',
      menus:[], footer:[], closeOnSelect:true, labels:{terminal:'Terminal',open:'Open terminal',close:'Close terminal'}
    }}
    esc(v){const n=document.createElement('div');n.textContent=String(v??'');return n.innerHTML}
    menu(m){return `<button class="ait-psa-terminal-group" type="button" data-terminal-menu="${this.esc(m.id)}" data-modal="${this.esc(m.modal||'')}"><span class="ait-psa-terminal-group__icon">${this.esc(m.icon||'◆')}</span><span><b>${this.esc(m.title)}</b><small>${this.esc(m.description||'')}</small></span><span aria-hidden="true">›</span></button>`}
    render(){const o=this.options;this.mount.innerHTML=`
      <button class="ait-psa-terminal-launcher" id="aitPsaTerminalLauncher" type="button" aria-expanded="false" aria-controls="${this.esc(o.id)}"><span class="ait-psa-terminal-launcher__icon">${this.esc(o.logo)}</span><span>${this.esc(o.labels.terminal)}</span></button>
      <button class="ait-psa-terminal-dock-backdrop" id="aitPsaTerminalDockBackdrop" type="button" aria-label="${this.esc(o.labels.close)}"></button>
      <aside class="ait-psa-terminal-dock" id="${this.esc(o.id)}" aria-label="${this.esc(o.title)}">
        <header class="ait-psa-terminal-head"><div><strong>${this.esc(o.title)}</strong><small><i class="ait-psa-live-dot"></i>${this.esc(o.subtitle)}</small></div><button class="ait-psa-terminal-close" id="aitPsaTerminalClose" type="button">×</button></header>
        <div class="ait-psa-terminal-search"><label for="aitPsaTerminalSearch">COMMAND SEARCH</label><div><input id="aitPsaTerminalSearch" type="search" placeholder="Search terminal modules..."><button id="aitPsaTerminalSearchButton" type="button">⌕</button></div></div>
        <div class="ait-psa-terminal-module-label"><span>TERMINAL MODULES</span><b>${String(o.menus.length).padStart(2,'0')}</b></div>
        <nav class="ait-psa-terminal-groups">${o.menus.map(m=>this.menu(m)).join('')}</nav>
        <section class="ait-psa-terminal-health"><div><span>ACTIVE THEME</span><strong data-terminal-theme>—</strong></div><div><span>SYSTEM</span><strong>READY</strong></div></section>
        <footer class="ait-psa-terminal-footer">${o.footer.map(f=>`<button type="button" data-terminal-menu="${this.esc(f.id)}" data-modal="${this.esc(f.modal||'')}"><span>${this.esc(f.icon||'◆')}</span>${this.esc(f.title)}</button>`).join('')}</footer>
      </aside>`}
    cache(){this.dock=this.mount.querySelector('.ait-psa-terminal-dock');this.launcher=this.mount.querySelector('#aitPsaTerminalLauncher');this.closeBtn=this.mount.querySelector('#aitPsaTerminalClose');this.backdrop=this.mount.querySelector('#aitPsaTerminalDockBackdrop');this.search=this.mount.querySelector('#aitPsaTerminalSearch')}
    bind(){this.launcher.onclick=()=>this.open();this.closeBtn.onclick=()=>this.close();this.backdrop.onclick=()=>this.close();this.mount.querySelector('#aitPsaTerminalSearchButton').onclick=()=>this.runSearch();this.search.onkeydown=e=>{if(e.key==='Enter')this.runSearch()};this.mount.querySelectorAll('[data-terminal-menu]').forEach(b=>b.onclick=()=>this.select(b));document.addEventListener('keydown',e=>{if(e.key==='Escape')this.close()})}
    select(button){const id=button.dataset.terminalMenu||'';const menu=this.options.menus.find(m=>m.id===id)||this.options.footer.find(m=>m.id===id)||{};this.mount.dispatchEvent(new CustomEvent('ababil:terminal-select',{bubbles:true,detail:{id,modal:button.dataset.modal||menu.modal||'',action:menu.action||'',label:menu.title||button.textContent.trim()}}));if(this.options.closeOnSelect)this.close()}
    runSearch(){const q=this.search.value.trim().toLowerCase();if(!q)return;const m=this.options.menus.find(x=>`${x.title} ${x.description||''}`.toLowerCase().includes(q));this.mount.dispatchEvent(new CustomEvent('ababil:terminal-search',{bubbles:true,detail:{query:q,match:m}}));if(m)this.mount.querySelector(`[data-terminal-menu="${CSS.escape(m.id)}"]`)?.click()}
    open(){this.dock.classList.add('open');this.backdrop.classList.add('open');document.body.classList.add('ait-psa-terminal-open');this.launcher.setAttribute('aria-expanded','true')}
    close(){this.dock.classList.remove('open');this.backdrop.classList.remove('open');document.body.classList.remove('ait-psa-terminal-open');this.launcher.setAttribute('aria-expanded','false')}
    syncTheme(){const update=()=>{const t=document.documentElement.dataset.theme||'dark-glass';this.mount.querySelectorAll('[data-terminal-theme]').forEach(n=>n.textContent=t.replaceAll('-',' ').toUpperCase())};update();this.observer=new MutationObserver(update);this.observer.observe(document.documentElement,{attributes:true,attributeFilter:['data-theme']})}
  }
  window.AbabilTerminal=AitPsaGenericTerminal;
  window.AitPsaGenericTerminal=AitPsaGenericTerminal;
})();