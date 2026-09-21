// Comparable chronological replay for the Elite and Elite Regime 2D, 3D, 6D and 9D scanners.
(()=>{"use strict";
 const DAYS=[2,3,6,9],TYPES=['elite','regime'];
 const byId=id=>document.getElementById(id);
 const bridge=()=>window.AITScannerDataBridge;
 const codes=()=>bridge()?.scannerCodes?.()||[];
 const history=()=>bridge()?.appState?.()?.history||{};
 const key=(type,days)=>`${type}-${days}`;
 const label=(type,days)=>`AIT Elite${type==='regime'?' Regime':''} ${days}D`;
 const esc=value=>String(value??'').replace(/[&<>"']/g,char=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'}[char]));
 const pct=(value,plus=false)=>value==null?'—':`${plus&&value>=0?'+':''}${value.toFixed(2)}%`;
 const empty=()=>({n:0,dates:new Set(),raw:0,benchmark:0,excess:0,rawWins:0,excessWins:0});
 const add=(bucket,date,raw,benchmark)=>{bucket.n++;bucket.dates.add(date);bucket.raw+=raw;bucket.benchmark+=benchmark;bucket.excess+=raw-benchmark;if(raw>0)bucket.rawWins++;if(raw>benchmark)bucket.excessWins++};
 const pack=bucket=>({n:bucket.n,dates:bucket.dates.size,raw:bucket.n?bucket.raw/bucket.n:null,benchmark:bucket.n?bucket.benchmark/bucket.n:null,excess:bucket.n?bucket.excess/bucket.n:null,rawWin:bucket.n?bucket.rawWins/bucket.n*100:null,excessWin:bucket.n?bucket.excessWins/bucket.n*100:null});
 const daysAndCloses=()=>{const h=history(),active=codes(),close=new Map(),dates=new Set(),market=new Map();for(const code of active){const series=new Map(),rows=(Array.isArray(h[code])?h[code]:[]).filter(row=>row?.date).sort((a,b)=>String(a.date).localeCompare(String(b.date)));let prior=null;for(const row of rows){const date=String(row.date).slice(0,10),value=Number(row.close);if(!date||!Number.isFinite(value))continue;dates.add(date);if(value>0)series.set(date,value);if(prior>0){const ret=(value/prior-1)*100,stats=market.get(date)||{sum:0,up:0,n:0};stats.sum+=ret;stats.up+=ret>0?1:0;stats.n++;market.set(date,stats)}prior=value}close.set(code,series)}return {active,close,dates:[...dates].sort(),market}};
 const regimeAt=(dates,index,market)=>{const today=market.get(dates[index])||{sum:0,up:0,n:0},breadth=today.n?today.up/today.n*100:0,ret=today.n?today.sum/today.n:null,recent=dates.slice(Math.max(0,index-19),index+1).map(date=>{const item=market.get(date);return item?.n?item.sum/item.n:null}).filter(Number.isFinite),momentum=recent.length?recent.reduce((a,b)=>a+b,0)/recent.length:0;return breadth>=62&&momentum>=0.15&&ret>=0?'Bull':breadth<=38&&momentum<=-0.15&&ret<=0?'Bear':'Sideways'};
 const signature=()=>`${bridge()?.scannerHistorySignature?.()||''}|${bridge()?.scannerUniverseSignature?.()||''}|${codes().join('|')}`;
 const storageKey='ait-psa-elite-horizon-comparison-v2';
 let memory=null,running=null,selected='all';
 const cached=sig=>{if(memory?.signature===sig)return memory;try{const found=JSON.parse(localStorage.getItem(storageKey)||'null');if(found?.signature===sig&&found?.version===2)return memory=found}catch(_){}return null};
 const save=value=>{memory=value;try{localStorage.setItem(storageKey,JSON.stringify(value))}catch(_){}return value};
 const clearScannerCaches=()=>{bridge()?.clearPrioritySnapshotCache?.();window.AitSignalPriorityHistory?.clearCache?.();window.AitAdvancedSignalPriority?.clearCache?.();window.AitEliteSignalPriority?.clearCache?.()};
 const tick=()=>new Promise(resolve=>setTimeout(resolve,0));
 const replay=async()=>{
  const sig=signature(),previous=cached(sig);if(previous)return previous;
  const {active,close,dates,market}=daysAndCloses(),start=20,end=dates.length-9;
  const totals=new Map(),details=new Map();for(const type of TYPES)for(const days of DAYS){totals.set(key(type,days),empty());details.set(key(type,days),new Map())}
  const status=byId('aitEliteCompareStatus');
  const cutoffBefore=window.__AIT_HISTORICAL_CUTOFF_DATE__;
  try{
   for(let i=start;i<end;i++){
    if((i-start)%10===0&&signature()!==sig)throw new Error('OHLC or active watch list changed during replay. Run the monitor again.');
    const date=dates[i],regime=regimeAt(dates,i,market);
    window.__AIT_HISTORICAL_CUTOFF_DATE__=date;clearScannerCaches();
    for(const days of DAYS){
     const future=dates[i+days],returns=[];
     for(const code of active){const first=close.get(code)?.get(date),last=close.get(code)?.get(future);if(first>0&&last>0)returns.push((last/first-1)*100)}
     if(!returns.length)continue;
     const benchmark=returns.reduce((a,b)=>a+b,0)/returns.length;
     const rows=window.AitEliteSignalPriority?.calculate?.(days)?.rows||[];
     for(const row of rows){
      const first=close.get(row.code)?.get(date),last=close.get(row.code)?.get(future);if(!(first>0&&last>0))continue;
      const raw=(last/first-1)*100,signal=String(row.finalSignal||'Avoid');
      if(signal==='Strong Buy'||signal==='Buy'){
       const id=key('elite',days),group=details.get(id),sub=group.get(signal)||empty();
       add(totals.get(id),date,raw,benchmark);add(sub,date,raw,benchmark);group.set(signal,sub);
      }
      if(regime){
       const adjustment=window.AITEliteRegime.adjust({label:regime},Number(row.eliteScore)||0,signal);
       const decision=window.AITEliteRegime.decide({...adjustment,signal});
       if(decision.action==='BUY NOW'||decision.action==='CONFIRMATION'){
        const id=key('regime',days),group=details.get(id),sub=group.get(regime)||empty();
        add(totals.get(id),date,raw,benchmark);add(sub,date,raw,benchmark);group.set(regime,sub);
       }
      }
     }
    }
    if(status)status.textContent=`Replaying ${i-start+1} of ${Math.max(0,end-start)} dates · ${date}`;
    if((i-start)%2===0)await tick();
   }
  }finally{if(cutoffBefore)window.__AIT_HISTORICAL_CUTOFF_DATE__=cutoffBefore;else delete window.__AIT_HISTORICAL_CUTOFF_DATE__;clearScannerCaches()}
  const value={version:2,signature:sig,builtAt:new Date().toISOString(),period:{from:dates[start]||null,to:dates[Math.max(start,end-1)]||null,dates:Math.max(0,end-start)},rows:Object.fromEntries([...totals].map(([id,bucket])=>[id,pack(bucket)])),details:Object.fromEntries([...details].map(([id,groups])=>[id,Object.fromEntries([...groups].map(([name,bucket])=>[name,pack(bucket)]))]))};
  return save(value);
 };
 const comparisonRow=(type,days,stats)=>`<tr data-monitor="${key(type,days)}"><td><strong>${label(type,days)}</strong></td><td>${stats?.dates??0}</td><td>${stats?.n??0}</td><td>${pct(stats?.raw)}</td><td>${pct(stats?.benchmark)}</td><td><strong>${pct(stats?.excess,true)}</strong></td><td>${pct(stats?.rawWin)}</td><td>${pct(stats?.excessWin)}</td></tr>`;
 const render=value=>{
  const body=byId('aitEliteCompareRows'),detail=byId('aitEliteCompareDetailRows'),heading=byId('aitEliteCompareDetailTitle');if(!body||!detail)return;
  body.innerHTML=TYPES.flatMap(type=>DAYS.map(days=>comparisonRow(type,days,value.rows[key(type,days)]))).join('');
  body.querySelectorAll('tr[data-monitor]').forEach(row=>{row.style.cursor='pointer';row.addEventListener('click',()=>{selected=row.dataset.monitor;render(value)})});
  body.querySelectorAll('tr[data-monitor]').forEach(row=>{if(row.dataset.monitor===selected)row.style.background='color-mix(in srgb,var(--v10-primary,#60a5fa) 12%,transparent)'});
  if(selected==='all'){heading.textContent='Signal and regime detail · all horizons';detail.innerHTML=TYPES.flatMap(type=>DAYS.flatMap(days=>Object.entries(value.details[key(type,days)]||{}).map(([name,stats])=>`<tr><td>${label(type,days)}</td><td>${esc(name)}</td><td>${stats.dates}</td><td>${stats.n}</td><td>${pct(stats.raw)}</td><td>${pct(stats.excess,true)}</td><td>${pct(stats.excessWin)}</td></tr>`))).join('')||'<tr><td colspan="7">No evaluable signals were found.</td></tr>'}
  else{const [type,daysText]=selected.split('-'),days=Number(daysText);heading.textContent=`${label(type,days)} · signal and regime detail`;detail.innerHTML=Object.entries(value.details[selected]||{}).map(([name,stats])=>`<tr><td>${label(type,days)}</td><td>${esc(name)}</td><td>${stats.dates}</td><td>${stats.n}</td><td>${pct(stats.raw)}</td><td>${pct(stats.excess,true)}</td><td>${pct(stats.excessWin)}</td></tr>`).join('')||'<tr><td colspan="7">No evaluable signals were found.</td></tr>'}
  const status=byId('aitEliteCompareStatus');if(status)status.textContent=value.period.dates?`${value.period.dates} common signal dates · ${value.period.from} to ${value.period.to} · last 9 forward sessions excluded`:'At least 30 trading dates with forward prices are needed.';
 };
 const run=async(force=false)=>{if(running)return running;if(force){memory=null;try{localStorage.removeItem(storageKey)}catch(_){}}const status=byId('aitEliteCompareStatus');if(status)status.textContent='Preparing historical replay…';const task=async()=>{try{const value=await replay();render(value);return value}catch(error){console.error('AIT Elite horizon performance:',error);if(status)status.textContent=error.message||'Historical replay failed.';throw error}finally{running=null}};running=window.AITEliteBusy?.execute?.({kicker:'AIT ELITE PERFORMANCE',title:'Comparing 2D, 3D, 6D and 9D',text:'Replaying signals in date order and measuring forward returns…'},task)||task();return running};
 window.AitEliteHorizonPerformance={run,render};
 const modal=()=>`<section class="ait-psa-terminal-modal ait-psa-workspace-modal" id="aitEliteCompareModal" hidden role="dialog" aria-modal="true"><header class="ait-psa-terminal-modal__head"><div><span class="ait-psa-terminal-modal__eyebrow">ELITE HORIZON PERFORMANCE</span><h2>AIT Elite · 2D, 3D, 6D and 9D Comparison</h2><p>Chronological close-to-close evaluation across the same eligible signal dates.</p></div><div class="ait-psa-terminal-head-actions"><button class="ait-psa-terminal-back" data-ait-psa-open="aitPsaSignalPriorityPerformanceModal" type="button">← Performance Monitor</button><button class="ait-psa-terminal-close" data-ait-psa-close type="button">×</button></div></header><div class="ait-psa-terminal-modal__body ait-psa-workspace-host"><section class="v11-workspace active"><article class="v11-card v11-scanner-card"><div class="v11-card-head"><div><h3>Performance by scanner and horizon</h3><small>All eight rows use the same historical dates and the active watch list.</small></div><button class="btn primary" id="aitEliteCompareRefresh" type="button">Recalculate</button></div><div class="v11-card-body"><section class="v11-potential-guideline" aria-label="Performance comparison guide"><div class="v11-potential-guideline-head"><div><h4>How to read this comparison</h4><p>Signals are reconstructed using only data available on their date. A stock's return is measured at its scanner horizon: 2, 3, 6 or 9 later trading sessions.</p></div></div><div class="v11-potential-guideline-grid"><div class="v11-potential-guide v11-potential-guide--strongest"><strong>Elite sample</strong><span>Strong Buy and Buy setup signals. The ranking is measured independently for each horizon.</span></div><div class="v11-potential-guide v11-potential-guide--formula"><strong>Regime sample</strong><span>Elite setups whose date-specific regime decision is BUY NOW or CONFIRMATION.</span></div><div class="v11-potential-guide v11-potential-guide--watch"><strong>Excess return</strong><span>Stock return minus the equal-weight active-universe return over the same sessions. Excess Win% is the share above that benchmark.</span></div><div class="v11-potential-guide v11-potential-guide--avoid"><strong>Evidence limit</strong><span>Compare return, win rate, and the number of distinct dates together. This is historical evidence, not a forecast or a validation of 2D, 3D and 6D calibration.</span></div></div></section><p class="v11-note" id="aitEliteCompareStatus" role="status">Open a monitor to calculate the comparison.</p><div class="v11-scanner-table-region" style="margin-top:14px"><div class="v11-table-scrollbar" aria-label="Horizontal table scrollbar"><div></div></div><div class="v11-table-wrap v11-scanner-table-wrap"><table class="v11-table v11-potential-table"><thead><tr><th>Scanner</th><th>Dates</th><th>Samples</th><th>Raw Avg</th><th>Benchmark Avg</th><th>Excess Avg</th><th>Raw Win%</th><th>Excess Win%</th></tr></thead><tbody id="aitEliteCompareRows"><tr><td colspan="8">Calculating…</td></tr></tbody></table></div></div><h4 id="aitEliteCompareDetailTitle" style="margin:20px 0 8px">Signal and regime detail · all horizons</h4><div class="v11-scanner-table-region"><div class="v11-table-scrollbar" aria-label="Horizontal table scrollbar"><div></div></div><div class="v11-table-wrap v11-scanner-table-wrap"><table class="v11-table v11-potential-table"><thead><tr><th>Scanner</th><th>Signal / Regime</th><th>Dates</th><th>Samples</th><th>Raw Avg</th><th>Excess Avg</th><th>Excess Win%</th></tr></thead><tbody id="aitEliteCompareDetailRows"><tr><td colspan="7">Calculating…</td></tr></tbody></table></div></div></div></article></section></div></section>`;
 const init=()=>{
  const menu=byId('aitPsaSignalPriorityPerformanceModal')?.querySelector('.ait-psa-terminal-command-grid'),shell=byId('aitPsaTerminalModalShell');if(!menu||!shell)return;
  menu.querySelector('[data-ait-psa-open="aitElitePerformanceModal"] b')?.replaceChildren(document.createTextNode('AIT Elite 9D'));
  menu.querySelector('[data-ait-psa-open="aitEliteRegimePerformanceModal"] b')?.replaceChildren(document.createTextNode('AIT Elite Regime 9D'));
  for(const type of TYPES)for(const days of [2,3,6]){const button=document.createElement('button');button.type='button';button.className='ait-psa-terminal-command';button.dataset.aitPsaOpen='aitEliteCompareModal';button.dataset.monitor=key(type,days);button.innerHTML=`<span>${type==='regime'?'◈':'✹'}</span><b>${label(type,days)}</b><small>${days}D historical outcomes and the 2D / 3D / 6D / 9D comparison.</small>`;const anchor=menu.querySelector(`[data-ait-psa-open="${type==='regime'?'aitEliteRegimePerformanceModal':'aitElitePerformanceModal'}"]`);anchor?.before(button)}
  const compare=document.createElement('button');compare.type='button';compare.className='ait-psa-terminal-command';compare.dataset.aitPsaOpen='aitEliteCompareModal';compare.dataset.monitor='all';compare.innerHTML='<span>⇄</span><b>Compare 2D, 3D, 6D and 9D</b><small>Eight scanners in one table, with signal and regime breakdowns.</small>';menu.appendChild(compare);
  shell.insertAdjacentHTML('beforeend',modal());
  menu.querySelectorAll('[data-ait-psa-open="aitEliteCompareModal"]').forEach(button=>button.addEventListener('click',()=>{selected=button.dataset.monitor||'all';setTimeout(()=>run().catch(()=>{}),0)}));
  byId('aitEliteCompareRefresh')?.addEventListener('click',()=>run(true).catch(()=>{}));
 };
 if(document.readyState==='loading')document.addEventListener('DOMContentLoaded',init);else init();
})();
