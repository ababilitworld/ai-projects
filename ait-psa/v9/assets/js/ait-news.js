(function (root) {
  'use strict';
  // Monochrome symbols keep subtype colors consistent across canvas and reports.
  const categories = {
    financial: {label:'Financials',symbol:'▤',color:'#5486b4',types:{q1:['Q1','#5486b4'],q2:['Q2','#408f93'],q3:['Q3','#927ab5'],q4:['Q4','#ac8452'],results:['Other','#6a889d']}},
    dividend: {label:'Dividend',symbol:'◆',color:'#458c72',types:{declaration:['Declaration','#458c72'],disbursement:['Disbursement','#80994f']}},
    spot: {label:'Spot News',symbol:'◉',color:'#b28c43',types:{notice:['','#b28c43']}},
    trading: {label:'Trading',symbol:'⇄',color:'#ae6c7b',types:{suspension:['Suspension','#ae6c7b'],resumption:['Resumption','#56977e']}},
    credit: {label:'Credit Rating',symbol:'⬟',color:'#837cae',types:{rating:['','#837cae']}},
    general: {label:'General',symbol:'●',color:'#788a99',types:{notice:['','#788a99']}},
    pricehike: {label:'Price Hike',symbol:'↗',color:'#b57f53',types:{notice:['','#b57f53']}},
    declaration: {label:'Declaration',symbol:'△',color:'#598f9f',types:{buy:['Buy','#598f9f'],sell:['Sell','#b2768c'],transfer:['Transfer','#8e8d55']}},
    board: {label:'Board Meeting',symbol:'▦',color:'#9d79a5',types:{scheduled:['Scheduled','#9d79a5'],rescheduled:['Rescheduled','#aa866d'],cancelled:['Cancelled','#a6656d']}},
    sensitive: {label:'Price Sensitive',symbol:'✦',color:'#ab7a70',types:{disclosure:['Disclosure','#ab7a70'],clarification:['Clarification','#a3905e']}},
    corporate: {label:'Corporate Action',symbol:'◇',color:'#6e9563',types:{agm:['AGM / EGM','#6e9563'],rights:['Rights / capital','#7188aa']}}
  };
  const lineColors = {up: '#518675', down: '#b27178', equal: '#4b5058'};
  const esc = v => String(v ?? '').replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
  const normalizeCode = v => String(v || '').trim().toUpperCase().replace(/[^A-Z0-9().&_\-]/g, '');
  function classify(row) {
    const title = String(row.title || '').toLowerCase(), body = String(row.body || '').toLowerCase();
    const text = title + ' ' + body, tags = [];
    const add = (category, type) => {if (!tags.some(t => t.category === category && t.type === type)) tags.push({category, type});};
    // Meeting notices mentioning forthcoming financial statements are not released results.
    if (/board meeting|meeting of the board|board of directors will be held/.test(text)) {
      add('board', /cancel/.test(title) ? 'cancelled' : /reschedul|revised|postpon/.test(text) ? 'rescheduled' : 'scheduled');
    } else {
      const q = (title.match(/\bq\s*([1-4])\b/) || body.match(/\bq\s*([1-4])\b/) || [])[1];
      if (q || /financial (?:statement|result)|earnings|\beps\b|quarter|half.year/.test(text)) {
        const type = q ? 'q' + q : /first quarter|1st quarter/.test(text) ? 'q1' : /second quarter|2nd quarter|half.year/.test(text) ? 'q2' : /third quarter|3rd quarter|nine.month/.test(text) ? 'q3' : /audited|year ended|annual|fourth quarter|4th quarter/.test(text) ? 'q4' : 'results';
        add('financial', type);
      }
      if (/dividend/.test(text) && !/spot news|record date|trading.*suspen/.test(title)) {
        add('dividend', /disburs|credited|remitt|payment of.*dividend/.test(text) ? 'disbursement' : 'declaration');
      }
    }
    if (/credit rat|\bcrisl\b|\bcrab\b/.test(text)) add('credit', 'rating');
    if (/price sensitive|\bpsi\b/.test(text)) add('sensitive', /clarif|query|unusual/.test(text) ? 'clarification' : 'disclosure');
    if (/unusual (?:price|volume)|price hike|price movement/.test(title)) add('pricehike', 'notice');
    if (/resum/.test(title)) add('trading', 'resumption');
    else if (/suspen/.test(title)) add('trading', 'suspension');
    else if (/spot|record date/.test(title)) add('spot', 'notice');
    if (/agm|egm/.test(title)) add('corporate', 'agm');
    if (/transfer/.test(title)) add('declaration', 'transfer');
    else if (/buy|purchase/.test(title)) add('declaration', 'buy');
    else if (/sale|sell/.test(title)) add('declaration', 'sell');
    if (/rights (?:share|issue)|capital increase/.test(text)) add('corporate', 'rights');
    if (!tags.length) add('general', 'notice');
    return tags;
  }
  function style(tag) {
    const cat = categories[tag.category] || categories.general;
    const subtype = cat.types[tag.type] || Object.values(cat.types)[0];
    return {symbol: cat.symbol, color: subtype[1], label: cat.label + (subtype[0] ? ' · ' + subtype[0] : '')};
  }
  function mergeRows(previous, incoming) {
    const map = new Map();
    [...previous, ...incoming].forEach(row => {
      if (!row || !row.id || !/^\d{4}-\d{2}-\d{2}$/.test(row.date)) return;
      map.set(row.id, {...row, code: normalizeCode(row.code), tags: classify(row)});
    });
    return [...map.values()].sort((a,b) => a.date.localeCompare(b.date) || a.id.localeCompare(b.id));
  }
  function mergeDownload(previous, payload) {
    const earliest = (a,b) => [a,b].filter(Boolean).sort()[0];
    const latest = (a,b) => [a,b].filter(Boolean).sort().at(-1);
    return {...payload, rows: mergeRows(previous.rows || [], payload.rows),
      start: earliest(previous.start, payload.start), end: latest(previous.end, payload.end),
      sourceStart: earliest(previous.sourceStart, payload.sourceStart), sourceEnd: latest(previous.sourceEnd, payload.sourceEnd)};
  }
  function chartData(data, history = data) {
    const sorted = [...history].sort((a,b)=>a.date.localeCompare(b.date));
    let cursor=0, previous=null;
    return data.map(bar=>{
      while(cursor<sorted.length && sorted[cursor].date<bar.date){const price=Number(sorted[cursor++].close);if(price>0 && Number.isFinite(price))previous=price;}
      const raw=Number(bar.close), close=raw>0 && Number.isFinite(raw) ? raw : previous;
      if (!(close>0)) return {...bar};
      const result={...bar,close,_newsFallback:bar._newsFallback||!(raw>0),_newsRawClose:bar._newsRawClose??bar.close};
      ['open','high','low'].forEach(key=>{if(!(Number(result[key])>0))result[key]=close;});
      return result;
    });
  }
  function eventsFor(data, news, history = data) {
    const dates = new Map();
    news.forEach(row => {if (!dates.has(row.date)) dates.set(row.date, []); dates.get(row.date).push(row);});
    return chartData(data,history).flatMap((bar, index) => {
      const items = dates.get(bar.date);
      if (!items || !(Number(bar.close)>0) || !Number.isFinite(Number(bar.close)) || !Number.isFinite(Number(bar.low))) return [];
      const tags = new Map();
      items.forEach(row => (row.tags || classify(row)).forEach(tag => tags.set(tag.category + ':' + tag.type, tag)));
      return [{index, date: bar.date, close: Number(bar.close), usedPreviousClose:!!bar._newsFallback, markerPrice: Number(bar.low) * .9, tags: [...tags.values()], items}];
    });
  }
  function segments(events) {
    return events.slice(1).map((to, i) => ({from: events[i], to, color: lineColors[to.close > events[i].close ? 'up' : to.close < events[i].close ? 'down' : 'equal']}));
  }
  function symbolMetrics(width, height) {
    const size=Math.round(Math.max(20,Math.min(34,Math.min(width*.045,height*.08))));
    return {size,gap:size+5,radius:size*.6};
  }
  function watermark(ctx, left, top, width, height) {
    ctx.save();
    ctx.beginPath();ctx.rect(left,top,width,height);ctx.clip();
    ctx.font=`700 ${Math.round(Math.max(26,Math.min(width*.16,height*.3,100)))}px system-ui, sans-serif`;
    ctx.textAlign='center';ctx.textBaseline='middle';
    ctx.fillStyle='#7c8fa4';ctx.globalAlpha=.15;
    ctx.fillText('AIT-PSA',left+width/2,top+height/2,width*.75);
    ctx.restore();
  }
  function bounds(data, events, height, metrics = symbolMetrics(600,300)) {
    const max = Math.max(...data.map(r => Number(r.high)));
    let min = Math.min(...data.map(r => Number(r.low)));
    for (const e of events) {
      const fraction = Math.min(.95, (metrics.radius + (e.tags.length - 1) * metrics.gap) / Math.max(1, height));
      min = Math.min(min, (e.markerPrice - max * fraction) / (1 - fraction));
    }
    return {min, max, range: Math.max(.01, max - min)};
  }
  const records = new Map(), manifests = new Map();
  function forCode(code) {return records.get(normalizeCode(code)) || [];}
  function draw(ctx, canvas, events, x, y, metrics = symbolMetrics(canvas.width/(root.devicePixelRatio||1),canvas.height/(root.devicePixelRatio||1))) {
    ctx.save();
    for (const segment of segments(events)) {
      ctx.beginPath(); ctx.strokeStyle = segment.color; ctx.lineWidth = 2;
      ctx.moveTo(x(segment.from.index), y(segment.from.close)); ctx.lineTo(x(segment.to.index), y(segment.to.close)); ctx.stroke();
    }
    const hits = [];
    events.forEach(e => {
      ctx.fillStyle = '#596c78'; ctx.beginPath(); ctx.arc(x(e.index), y(e.close), 2.5, 0, Math.PI * 2); ctx.fill();
      e.tags.forEach((tag, i) => {
        const s = style(tag), xx = x(e.index), yy = y(e.markerPrice) + i * metrics.gap;
        ctx.fillStyle = s.color; ctx.font = `bold ${metrics.size}px "Segoe UI Symbol", sans-serif`; ctx.textAlign = 'center'; ctx.textBaseline = 'middle';
        ctx.fillText(s.symbol, xx, yy);
        hits.push({x: xx, y: yy, radius:metrics.radius, event: e, tag});
      });
    });
    ctx.restore();
    canvas._aitNewsHits = hits;
    const box = canvas.closest('.chart-box,.v11-chart-slot');
    const legendHost = box?.classList.contains('v11-chart-slot') ? box : box?.parentElement;
    if (box && !legendHost.querySelector(':scope > .ait-news-chart-legend')) {
      const legend = document.createElement('div'); legend.className = 'ait-news-chart-legend';
      legend.innerHTML = `<span>News: markers at low −10%</span> <span style="color:${lineColors.up}">↗ Higher close</span> <span style="color:${lineColors.down}">↘ Lower close</span> <span style="color:${lineColors.equal}">→ Equal close</span><button type="button" class="btn soft" data-ait-news-open="report">News</button>`;
      if (legendHost === box) box.appendChild(legend); else box.insertAdjacentElement('afterend', legend);
    }
    const newsButton = legendHost?.querySelector(':scope > .ait-news-chart-legend [data-ait-news-open]');
    if (newsButton) newsButton.dataset.aitNewsCode = canvas.dataset.newsCode || '';
    if (!canvas._aitNewsBound) {
      canvas._aitNewsBound = true;
      canvas.addEventListener('mousemove', event => {
        const rect = canvas.getBoundingClientRect(), ratio = (canvas.width / (root.devicePixelRatio || 1)) / rect.width;
        const px = (event.clientX - rect.left) * ratio, py = (event.clientY - rect.top) * ((canvas.height / (root.devicePixelRatio || 1)) / rect.height);
        const hit = canvas._aitNewsHits?.find(h => Math.abs(h.x - px) < h.radius && Math.abs(h.y - py) < h.radius);
        canvas.title = hit ? `${hit.event.date} · ${style(hit.tag).label} · Close ${hit.event.close.toFixed(2)}\n${hit.event.items.map(r => r.title).join('\n')}\nClick to read news` : '';
        canvas.style.cursor = hit ? 'pointer' : '';
      });
      canvas.addEventListener('click', event => {
        const rect = canvas.getBoundingClientRect();
        const px = (event.clientX-rect.left)*(canvas.width/(root.devicePixelRatio||1))/rect.width;
        const py = (event.clientY-rect.top)*(canvas.height/(root.devicePixelRatio||1))/rect.height;
        const hit = canvas._aitNewsHits?.find(h => Math.abs(h.x-px)<h.radius && Math.abs(h.y-py)<h.radius);
        if (hit) openWorkspace('report', {code: canvas.dataset.newsCode, date: hit.event.date});
      });
    }
  }
  const api = {categories, lineColors, classify, style, mergeRows, mergeDownload, chartData, eventsFor, segments, symbolMetrics, watermark, bounds, forCode, draw};
  if (typeof module !== 'undefined' && module.exports) module.exports = api;
  root.AITNews = api;
  if (!root.document) return;

  let dbPromise, ready, busy = false, stop = false, lastFailed = [], page = 0;
  const $ = id => document.getElementById(id);
  function database() {
    return dbPromise ||= new Promise((resolve, reject) => {
      const request = indexedDB.open('ait-psa-dse-news-v1', 1);
      request.onupgradeneeded = () => request.result.createObjectStore('symbols', {keyPath: 'code'});
      request.onsuccess = () => resolve(request.result);
      request.onerror = () => reject(request.error);
    });
  }
  async function load() {
    const db = await database();
    await new Promise((resolve, reject) => {
      const tx = db.transaction('symbols'), request = tx.objectStore('symbols').getAll();
      request.onsuccess = () => request.result.forEach(row => {records.set(row.code, mergeRows([], row.rows)); manifests.set(row.code, row);});
      tx.oncomplete = resolve; tx.onerror = () => reject(tx.error);
    });
    render(); refreshCharts();
  }
  async function save(payload) {
    const code = normalizeCode(payload.code), previous = manifests.get(code) || {};
    const saved = mergeDownload({...previous, rows: forCode(code)}, payload);
    const db = await database();
    await new Promise((resolve,reject) => {
      const tx = db.transaction('symbols', 'readwrite'); tx.objectStore('symbols').put(saved);
      tx.oncomplete = resolve; tx.onerror = () => reject(tx.error); tx.onabort = () => reject(tx.error || new Error('News storage aborted.'));
    });
    records.set(code, saved.rows); manifests.set(code, saved);
  }
  function activeCodes() {return [...new Set((root.app?.active()?.codes || []).map(normalizeCode).filter(Boolean))];}
  function today() {return new Intl.DateTimeFormat('en-CA',{timeZone:'Asia/Dhaka',year:'numeric',month:'2-digit',day:'2-digit'}).format(new Date());}
  async function download(mode) {
    if (busy) return;
    try {await ready;} catch (e) {status('News storage is unavailable: ' + e.message, true); return;}
    if (busy) return;
    const list = root.app?.active(), codes = mode === 'retry' ? activeCodes().filter(c => lastFailed.includes(c)) : activeCodes();
    if (!codes.length) {status('Select a watch list containing trading codes first.', true); return;}
    const listName = list.name, end = today(); busy = true; stop = false; lastFailed = []; let completed = 0, added = 0;
    $('aitNewsStop').disabled = false;
    document.querySelectorAll('[data-ait-news-download]').forEach(b => b.disabled = true);
    for (let i = 0; i < codes.length; i++) {
      if (stop) break;
      const code = codes[i], existing = manifests.get(code);
      const start = mode === 'update' && existing?.end ? existing.end : '1900-01-01';
      status(`${listName} · ${i + 1}/${codes.length} · Downloading ${code} (${start === '1900-01-01' ? 'all available archive news' : start} → ${end})…`);
      $('aitNewsProgress').value = i / codes.length * 100;
      const before = forCode(code).length;
      try {
        const response = await fetch('dse_news.php', {method:'POST', headers:{'Content-Type':'application/json'}, body:JSON.stringify({code,start,end,force:mode==='all'||mode==='retry'}), signal:AbortSignal.timeout(75000)});
        const payload = await response.json();
        if (!response.ok || !payload.ok) throw new Error(payload.message || `HTTP ${response.status}`);
        if (payload.code !== code || !Array.isArray(payload.rows) || payload.rows.some(r => r.code !== code)) throw new Error('Unexpected news symbol in response.');
        await save(payload); completed++; added += forCode(code).length - before;
      } catch(e) {
        lastFailed.push(code); const item = document.createElement('li'); item.textContent = `${code}: ${e.message}`; $('aitNewsErrors').appendChild(item);
      }
      render();
    }
    busy = false; $('aitNewsStop').disabled = true;
    document.querySelectorAll('[data-ait-news-download]').forEach(b => b.disabled = false);
    $('aitNewsRetry').hidden = !lastFailed.length;
    $('aitNewsProgress').value = stop ? (completed + lastFailed.length) / codes.length * 100 : 100;
    status(`${stop ? 'Stopped' : 'Finished'} · ${listName} · ${completed}/${codes.length} symbols saved · ${added} new articles · ${lastFailed.length} failed${stop ? ' · Remaining symbols can be downloaded later.' : ''}`, lastFailed.length > 0);
    root.app?.log?.(`DSE news: ${completed}/${codes.length} codes in ${listName}, ${added} new articles, ${lastFailed.length} failed`);
    refreshCharts();
  }
  function status(message, error = false) {$('aitNewsStatus').textContent = message; $('aitNewsStatus').classList.toggle('ait-news-error', error);}
  function filtered() {
    const q = $('aitNewsSearch').value.trim().toLowerCase(), category = $('aitNewsCategory').value, type = $('aitNewsType').value;
    const code = $('aitNewsCode').value, from = $('aitNewsFrom').value, to = $('aitNewsTo').value;
    return activeCodes().flatMap(forCode).filter(row => (!code || row.code === code) && (!from || row.date >= from) && (!to || row.date <= to) &&
      (!category || row.tags.some(t => t.category === category && (!type || t.type === type))) && (!q || `${row.code} ${row.title} ${row.body}`.toLowerCase().includes(q)))
      .sort((a,b) => b.date.localeCompare(a.date) || a.code.localeCompare(b.code) || a.id.localeCompare(b.id));
  }
  function badge(tag) {const s = style(tag); return `<span class="ait-news-badge" style="--news-color:${s.color}"><b>${s.symbol}</b> ${esc(s.label)}</span>`;}
  function render() {
    if (!$('aitNewsRows')) return;
    const codes = activeCodes(), selected = $('aitNewsCode').value;
    $('aitNewsCode').innerHTML = '<option value="">All active-list symbols</option>' + codes.map(c => `<option>${esc(c)}</option>`).join('');
    if (codes.includes(selected)) $('aitNewsCode').value = selected;
    const all = filtered();
    const stored = codes.reduce((n,c) => n + forCode(c).length, 0), downloaded = codes.filter(c => manifests.has(c)).length;
    $('aitNewsScope').textContent = `${root.app?.active()?.name || 'No active watch list'} · ${downloaded}/${codes.length} symbols downloaded · ${stored.toLocaleString()} articles stored`;
    const sourceStarts = codes.map(c => manifests.get(c)?.sourceStart).filter(Boolean).sort();
    const checked = codes.map(c => manifests.get(c)?.downloadedAt).filter(Boolean).sort().at(-1);
    $('aitNewsCoverage').textContent = `${sourceStarts.length ? `Downloaded archive coverage from ${sourceStarts[0]}. ` : ''}All news means all articles currently supplied by DSE; older saved articles remain available.${checked ? ` Last download: ${new Date(checked).toLocaleString()}.` : ''}`;
    $('aitNewsCount').textContent = `${all.length.toLocaleString()} articles · Column sorting and filtering apply to every row.`;
    const prices=new Map();
    codes.forEach(code=>{const history=root.app?.s?.history?.[code]||[];prices.set(code,new Map(chartData(history).map(bar=>[bar.date,bar])));});
    $('aitNewsRows').innerHTML = all.map(row => {
      const bar=prices.get(row.code)?.get(row.date),close=bar?.close>0?Number(bar.close):null;
      return `<tr data-news-id="${esc(row.id)}"><td data-ait-sort-value="${esc(row.date)}">${esc(row.date)}</td><td><strong>${esc(row.code)}</strong></td><td data-ait-sort-value="${close??''}" title="${bar?._newsFallback?'Previous valid trading-day close; reported CloseP was zero.':''}">${close!==null?close.toFixed(2):'—'}${bar?._newsFallback?'<small class="ait-news-fallback">Previous close</small>':''}</td><td><div class="ait-news-tags">${row.tags.map(badge).join('')}</div></td><td class="ait-news-text"><strong>${esc(row.title)}</strong><p>${esc(row.body)}</p><a href="${esc(row.sourceUrl)}" target="_blank" rel="noopener noreferrer">DSE source ↗</a></td></tr>`;
    }).join('') || '<tr><td colspan="5" class="empty">No matching news. Download DSE news for this watch list or adjust the filters.</td></tr>';
    root.AITSortableFilterableTables?.getByBodyId('aitNewsRows')?.apply();
  }
  function refreshCharts() {
    if (root.app?.chartModal?.classList.contains('open')) root.app.drawCurrent();
    if (root.app?.galleryModal?.classList.contains('open')) root.app.openGallery(Number(root.app.galleryModal.dataset.months || 3));
    if ($('v11RankedChartModal')?.classList.contains('open')) root.AITRefreshRankedCharts?.();
    root.dispatchEvent(new Event('resize'));
  }
  let returnState = null;
  function closeWorkspace() {
    const state=returnState, shell=$('aitPsaTerminalModalShell');
    if(!state)return;
    returnState=null;
    state.panels.forEach(([panel,hidden])=>{if(panel.isConnected)panel.hidden=hidden;});
    $('aitPsaNewsWorkspaceModal').hidden=true;
    shell.classList.toggle('open',state.open);
    shell.classList.toggle('ait-news-front',state.front);
    shell.setAttribute('aria-hidden',state.ariaHidden);
    document.body.classList.toggle('ait-psa-terminal-open',state.bodyLocked);
    document.body.style.overflow=state.overflow;
    if(state.focus?.isConnected)state.focus.focus({preventScroll:true});
  }
  function openWorkspace(origin = 'report', filter = {}) {
    const modal = $('aitPsaNewsWorkspaceModal');
    const shell=$('aitPsaTerminalModalShell');
    if(modal.hidden||!shell.classList.contains('open')){
      returnState={panels:[...shell.querySelectorAll('.ait-psa-terminal-modal')].map(panel=>[panel,panel.hidden]),
        open:shell.classList.contains('open'),front:shell.classList.contains('ait-news-front'),ariaHidden:shell.getAttribute('aria-hidden')||'true',
        bodyLocked:document.body.classList.contains('ait-psa-terminal-open'),overflow:document.body.style.overflow,focus:document.activeElement};
    }
    $('aitNewsBack').removeAttribute('data-ait-psa-open');
    $('aitNewsBack').textContent = '← Back';
    if (filter.code) {render(); $('aitNewsCode').value = normalizeCode(filter.code); $('aitNewsFrom').value = filter.date || ''; $('aitNewsTo').value = filter.date || ''; $('aitNewsSearch').value = ''; $('aitNewsCategory').value = ''; updateTypes(); root.AITSortableFilterableTables?.getByBodyId('aitNewsRows')?.clearFilters();}
    const proxy = document.createElement('button'); proxy.dataset.aitPsaOpen = modal.id; proxy.hidden = true; document.body.appendChild(proxy); proxy.click(); proxy.remove();
    // Chart overlays may sit above the terminal; retain their state behind news.
    $('aitPsaTerminalModalShell').classList.add('ait-news-front');
    render();
  }
  function updateTypes() {
    const category = categories[$('aitNewsCategory').value];
    $('aitNewsType').innerHTML = '<option value="">All types</option>' + (category ? Object.entries(category.types).map(([id,[name]]) => `<option value="${id}">${esc(name)}</option>`).join('') : '');
    $('aitNewsType').disabled = !category;
  }
  function exportNews() {
    root.AITSortableFilterableTables?.getByBodyId('aitNewsRows')?.apply();
    const quote = v => '"' + String(v ?? '').replace(/"/g, '""').replace(/^[=+@\-]/, "'$&") + '"';
    const rows=[...$('aitNewsRows').rows].filter(row=>row.dataset.newsId&&!row.hidden&&row.style.display!=='none');
    const csv = [['Date','Trading Code','CloseP','News Category - Subcategory','News'], ...rows.map(row=>[...row.cells].map(cell=>cell.textContent.trim()))].map(row=>row.map(quote).join(',')).join('\r\n');
    const url = URL.createObjectURL(new Blob(['\ufeff'+csv],{type:'text/csv;charset=utf-8'})); const a = document.createElement('a'); a.href=url; a.download='dse-news-report.csv'; a.click(); setTimeout(()=>URL.revokeObjectURL(url),1000);
  }
  document.addEventListener('DOMContentLoaded', () => {
    // Capture before the shared modal/ESC handlers, which otherwise close the
    // underlying chart as well or discard the terminal panel we came from.
    root.addEventListener('click', event=>{
      if(!returnState||$('aitPsaNewsWorkspaceModal').hidden)return;
      if(event.target.closest('#aitNewsBack,#aitPsaNewsWorkspaceModal [data-ait-psa-close],#aitPsaTerminalModalBackdrop')){
        event.preventDefault();event.stopImmediatePropagation();closeWorkspace();
      }
    },true);
    root.addEventListener('keydown',event=>{
      if(event.key==='Escape'&&returnState&&!$('aitPsaNewsWorkspaceModal').hidden){event.preventDefault();event.stopImmediatePropagation();closeWorkspace();}
    },true);
    $('aitNewsCategory').innerHTML = '<option value="">All categories</option>' + Object.entries(categories).map(([id,c]) => `<option value="${id}">${c.symbol} ${c.label}</option>`).join('');
    $('aitNewsLegend').innerHTML = Object.entries(categories).map(([category,c]) => `<div><strong><span style="color:${c.color}">${c.symbol}</span> ${esc(c.label)}</strong><div class="ait-news-tags">${Object.keys(c.types).map(type=>badge({category,type})).join('')}</div></div>`).join('');
    document.addEventListener('click', event => {
      const open = event.target.closest('[data-ait-news-open]');
      if (open) {event.preventDefault(); openWorkspace(open.dataset.aitNewsOpen, {code: open.dataset.aitNewsCode});}
      const button = event.target.closest('[data-ait-news-download]');
      if (button) {openWorkspace('download'); $('aitNewsErrors').replaceChildren(); download(button.dataset.aitNewsDownload);}
      if (event.target.closest('[data-ait-psa-close],#aitPsaTerminalModalBackdrop')) $('aitPsaTerminalModalShell').classList.remove('ait-news-front');
      if (event.target.closest('[data-ait-data-action^="viewListCharts"],[data-ait-trading-tab="charts"]')) $('aitPsaTerminalModalShell').classList.remove('ait-news-front');
    });
    ['aitNewsSearch','aitNewsCode','aitNewsType','aitNewsFrom','aitNewsTo'].forEach(id => $(id).addEventListener('input', () => {page = 0; render();}));
    $('aitNewsCategory').addEventListener('change', () => {updateTypes(); page = 0; render();});
    $('aitNewsReset').onclick = () => {['aitNewsSearch','aitNewsCode','aitNewsCategory','aitNewsFrom','aitNewsTo'].forEach(id=>$(id).value=''); updateTypes(); root.AITSortableFilterableTables?.getByBodyId('aitNewsRows')?.clearFilters(); render();};
    $('aitNewsExport').onclick = exportNews; $('aitNewsStop').onclick = () => {stop=true; status('Stopping after the current symbol is saved…');};
    root.addEventListener('ait:active-watchlist-changed', () => {page=0; render();});
    root.addEventListener('ait:ohlc-history-changed', render);
    ready = load(); ready.catch(e => status('Unable to load news storage: ' + e.message, true));
    updateTypes(); render();
  });
  api.openWorkspace = openWorkspace;
  api.closeWorkspace = closeWorkspace;
})(typeof window !== 'undefined' ? window : globalThis);
