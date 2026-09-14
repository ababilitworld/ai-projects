/* Small replaceable components share a flow model; user-visible content is escaped. */
'use strict';
const escapeText=value=>String(value).replace(/[&<>"']/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
const e=escapeText;
class RoadmapView {
  constructor(root,flow) { this.root=root; this.flow=flow; }
  render() {
    const f=this.flow;
    this.root.innerHTML='<ol class="timeline">'+f.nodes.map((n,i)=>{
      const active=n===f.current, available=i<=f.cursor||f.nodes.slice(0,i).every(x=>x.confirmed);
      const context=n.t!=null&&!(n.type==='speech'&&[0,7,8].includes(n.g))?f.data[n.t].title+(n.s!=null?' / '+f.data[n.t].subtopics[n.s].title:''):'';
      return `<li class="${active?'current':n.confirmed?'done':'pending'} ${n.type==='speech'&&n.g>=1&&n.g<=5?'branch-lane':''} ${n.type==='speech'&&n.g===1?'lane-start':''} ${n.type==='speech'&&n.g===5?'lane-end':''}"><button data-visit="${n.id}" ${available?'':'disabled'} ${active?'aria-current="step"':''}><span class="node-dot">${n.confirmed&&!active?'✓':String(i+1).padStart(2,'0')}</span><span><strong>${e(f.title(n))}</strong>${context?`<small>${e(context)}</small>`:''}</span>${active?'<span class="here">NOW</span>':''}</button></li>`;
    }).join('')+'</ol>'+(f.nodes.at(-1).type==='complete'?'':'<div class="map-future"><span>⑂</span><p>Explore another subtopic<br>or branch into a new topic.</p><span>↓</span><p>Ending · Goodbye</p></div>');
    document.getElementById('stepCount').textContent=`${f.nodes.filter(n=>n.confirmed).length} completed`;
  }
}
class WorkspaceView {
  constructor(root,flow) { this.root=root; this.flow=flow; }
  choice(action,value,title,description,selected=false) {
    return `<button class="choice ${selected?'selected':''}" data-${action}="${value}"><span class="choice-icon">${selected?'✓':'↗'}</span><strong>${e(title)}</strong><small>${e(description)}</small></button>`;
  }
  render() {
    const f=this.flow,n=f.current;
    let content='', eyebrow='MAKE IT YOUR CONVERSATION', title=f.title(n), hint='';
    if(n.type==='topic') {
      hint='What would you like to talk about? Choose one topic to open its subtopics.';
      content='<div class="choices">'+f.data.map((t,i)=>this.choice('topic',i,t.title,`${t.subtopics.length} subtopics to explore`,n.t===i)).join('')+'</div>';
    } else if(n.type==='subtopic') {
      eyebrow=f.data[n.t].title; hint='Pick a starting point. You’ll move through five conversation steps, then decide where to go next.';
      content='<div class="choices">'+f.data[n.t].subtopics.map((s,i)=>this.choice('subtopic',i,s.title,'Question → Answer → Follow-up → Invitation → Response',n.s===i)).join('')+'</div>';
    } else if(n.type==='decision') {
      hint='Stay curious, change direction, or bring your conversation to a close.';
      content='<div class="fork-choices">'+this.choice('branch','subtopic','Another subtopic',`Stay with ${f.data[n.t].title}`,n.choice==='subtopic')+this.choice('branch','topic','Change topic','Say a transition, then choose a new topic.',n.choice==='topic')+this.choice('branch','finish','Wrap up','Ending → Goodbye',n.choice==='finish')+'</div>';
    } else if(n.type==='complete') {
      eyebrow='A CONVERSATION, WELL CONNECTED'; hint='You opened with a greeting, explored your chosen ideas and said goodbye. Review your path or print the conversation below.';
      content='<div class="complete-mark">✓</div><button class="primary" data-print>Print conversation</button>';
    } else {
      eyebrow=n.g===0?'START WITH A HELLO':`${f.data[n.t].title} / ${f.data[n.t].subtopics[n.s].title}`;
      hint=n.g===0?'Start warmly. Choose a way to say hello, then explore a topic.':'Choose how to say it, add a mood, and practice the exchange aloud.';
      const stage=f.stage(),moods=window.CONVERSATION_MOODS;
      content=`${n.customLines?'<p class="edit-notice">Imported dialogue text. Selecting a different pattern or mood regenerates this step from your library.</p>':''}<div class="dialogue" aria-label="Active dialogue">${f.lines().map(l=>`<div class="bubble ${l.speaker==='Child'?'child':''}"><span>${e(l.speaker)}</span><p>${e(l.text)}</p></div>`).join('')}</div>
        <div class="selection"><h3><span>01</span> Dialogue pattern <small>${e(stage.candidates[n.pattern].label)}</small></h3><div class="pattern-grid">${stage.candidates.map((c,i)=>`<button data-pattern="${i}" aria-pressed="${n.pattern===i}" class="${n.pattern===i?'selected':''}" title="${e(c.pattern)}">${e(c.label)}</button>`).join('')}</div></div>
        <div class="selection"><h3><span>02</span> Mood <small>${e(moods[n.mood].label)}</small></h3><div class="mood-grid">${moods.map((m,i)=>`<button data-mood="${i}" aria-pressed="${n.mood===i}" class="${n.mood===i?'selected':''}"><span>${m.icon}</span>${m.label}</button>`).join('')}</div></div>
        <div class="step-actions"><span class="muted small">Your pattern and mood stay with this step.</span><button class="primary" data-next>${n.g===0?'Choose a topic':n.g===8?'Finish conversation':'Continue'} <span>→</span></button></div>`;
    }
    this.root.innerHTML=`<div class="workspace-heading"><p class="eyebrow">${e(eyebrow)}</p><h2>${e(title)}</h2><p class="muted">${e(hint)}</p></div>${n.confirmed&&['topic','subtopic','decision'].includes(n.type)?'<p class="edit-notice">Choosing a different option replaces the steps after this point.</p>':''}${content}`;
  }
}
class TranscriptView {
  constructor(root,flow) { this.root=root; this.flow=flow; }
  render() {
    const f=this.flow;
    this.root.innerHTML=f.transcript().map(n=>`<article class="transcript-step"><h3>${e(f.title(n))}<small>${n.g>0&&n.g<7?e(f.data[n.t].title+' / '+f.data[n.t].subtopics[n.s].title):''} · ${e(window.CONVERSATION_MOODS[n.mood].label)}</small></h3>${f.lines(n).map(l=>`<p><b>${e(l.speaker)}</b> ${e(l.text)}</p>`).join('')}</article>`).join('');
  }
}
class App {
  constructor(data) {
    this.flow=new window.ConversationFlow(data);
    this.views=[new RoadmapView(document.getElementById('roadmap'),this.flow),new WorkspaceView(document.getElementById('workspace'),this.flow),new TranscriptView(document.getElementById('summary'),this.flow)];
  }
  init() {
    const themes=['ocean','emerald','midnight','sunset','royal','rose','gold','cyan','slate'];
    const picker=document.getElementById('theme');
    picker.innerHTML=themes.map(t=>`<option value="${t}">${t[0].toUpperCase()+t.slice(1)}</option>`).join('');
    let saved='ocean'; try { saved=localStorage.getItem('mtc-theme')||localStorage.getItem('theme')||'ocean'; } catch {}
    picker.value=themes.includes(saved)?saved:'ocean';
    const theme=()=>{document.getElementById('themeCss').href=`assets/css/themes/${picker.value}.css`;try{localStorage.setItem('mtc-theme',picker.value);}catch{}};
    theme(); picker.addEventListener('change',theme);
    document.getElementById('showDialog').onclick=()=>{document.querySelectorAll('.menubar details').forEach(d=>d.open=false);document.getElementById('workspace').focus();};
    this.csv=new CsvPanel(this.flow,()=>this.render(true));
    document.getElementById('print').onclick=()=>window.print();
    document.getElementById('restart').onclick=()=>{if(window.confirm('Start a fresh conversation? Your current path will be cleared.')){this.flow.reset();this.render(true);}};
    document.querySelector('main').addEventListener('click',event=>{
      const button=event.target.closest('button'); if(!button) return;
      const d=button.dataset,f=this.flow;
      if('print' in d) {window.print();return;}
      if('visit' in d) f.visit(Number(d.visit));
      else if('topic' in d) f.chooseTopic(Number(d.topic));
      else if('subtopic' in d) f.chooseSubtopic(Number(d.subtopic));
      else if('branch' in d) f.branch(d.branch);
      else if('next' in d) f.next();
      else if('pattern' in d) f.selectPattern(Number(d.pattern));
      else if('mood' in d) f.selectMood(Number(d.mood));
      else return;
      const selection='pattern' in d||'mood' in d;
      this.render(!selection);
      if(selection) document.querySelector(`[data-${'pattern' in d?'pattern':'mood'}="${d.pattern??d.mood}"]`).focus();
    });
    this.render();
  }
  render(focus=false) {
    this.views.forEach(v=>v.render());
    const n=this.flow.current;
    document.getElementById('announcement').textContent=n.type==='speech'?`${this.flow.title(n)}. ${this.flow.stage().candidates[n.pattern].label}. ${window.CONVERSATION_MOODS[n.mood].label}.`:this.flow.title(n);
    if(focus) {const panel=document.getElementById('workspace');panel.focus({preventScroll:true});if(matchMedia('(max-width: 800px)').matches) panel.scrollIntoView({behavior:'instant',block:'start'});}
  }
}
class CsvPanel {
  constructor(flow,onChange) {
    this.flow=flow;this.onChange=onChange;this.pending=null;this.readVersion=0;
    this.dialog=document.getElementById('csvDialog');
    document.getElementById('openCsv').onclick=()=>{document.querySelectorAll('.menubar details').forEach(d=>d.open=false);this.dialog.showModal();};
    document.getElementById('closeCsv').onclick=()=>this.dialog.close();
    document.getElementById('exportLibrary').onclick=()=>this.download('conversation-library.csv',window.ConversationCsv.libraryRecords(flow.data));
    document.getElementById('exportConversation').onclick=()=>this.download('selected-conversation.csv',window.ConversationCsv.conversationRecords(flow));
    document.getElementById('csvFile').onchange=event=>this.preview(event.target.files[0]);
    this.dialog.querySelectorAll('[name="importMode"]').forEach(r=>r.onchange=()=>this.validate());
    document.getElementById('applyCsv').onclick=()=>this.apply();
  }
  mode() {return this.dialog.querySelector('[name="importMode"]:checked').value;}
  status(message,error=false) {const el=document.getElementById('csvStatus');el.textContent=message;el.classList.toggle('error',error);}
  download(name,records) {
    if(!records.length){this.status('Choose a dialogue before exporting.',true);return;}
    const url=URL.createObjectURL(new Blob([window.ConversationCsv.stringify(records)],{type:'text/csv;charset=utf-8'}));
    const a=document.createElement('a');a.href=url;a.download=name;document.body.append(a);a.click();a.remove();setTimeout(()=>URL.revokeObjectURL(url),1000);
    this.status(`Exported ${records.length.toLocaleString()} dialogue lines.`);
  }
  async preview(file) {
    const version=++this.readVersion;this.pending=null;
    document.getElementById('importControls').hidden=true;document.getElementById('csvPreview').replaceChildren();this.status('');
    if(!file)return;
    try {
      if(file.size>15*1024*1024)throw Error('Choose a CSV file smaller than 15 MB.');
      const text=await file.text();if(version!==this.readVersion)return;
      this.pending=window.ConversationCsv.parse(text);
      const rows=this.pending.records;
      document.getElementById('csvPreview').innerHTML=`<h3>${rows.length.toLocaleString()} lines · ${e(this.pending.kind)}</h3><p class="small muted">Preview of the first ${Math.min(5,rows.length)} lines. Nothing has been applied yet.</p><div class="table-scroll"><table><thead><tr><th>Topic / step</th><th>Pattern / mood</th><th>Speaker</th><th>Text</th></tr></thead><tbody>${rows.slice(0,5).map(r=>`<tr><td>${e(r.topic)}<br>${e(r.step)}</td><td>${e(r.pattern)}<br>${e(r.mood)}</td><td>${e(r.speaker)}</td><td>${e(r.text)}</td></tr>`).join('')}</tbody></table></div>`;
      document.getElementById('importControls').hidden=false;this.validate();
    } catch(error){if(version===this.readVersion)this.status(error.message,true);}
  }
  validate() {
    if(!this.pending)return false;
    const mode=this.mode(),library=this.pending.kind==='library';
    document.getElementById('importEffect').textContent=library?
      `${mode==='merge'?'Merge adds patterns and replaces matching pattern/mood lines.':'Replace replaces the entire library.'} Applying starts a fresh conversation. Export a backup first if you want to keep your current path.`:
      `${mode==='merge'?'Merge appends imported dialogue to your current conversation. Repeated greetings or goodbyes are retained.':'Replace replaces your current conversation path.'} The library is unchanged. Imported steps remain editable; an imported path contains speaking steps rather than its original choice nodes.`;
    try {
      if(library)this.prepared=window.ConversationCsv.importLibrary(this.flow.data,this.pending.records,mode);
      else{const trial=new window.ConversationFlow(this.flow.data);trial.nodes=JSON.parse(JSON.stringify(this.flow.nodes));trial.cursor=this.flow.cursor;trial.sequence=this.flow.sequence;window.ConversationCsv.importConversation(trial,this.pending.records,mode);}
      document.getElementById('applyCsv').disabled=false;this.status('Validated. Review the preview and apply when ready.');return true;
    }catch(error){document.getElementById('applyCsv').disabled=true;this.status(error.message,true);return false;}
  }
  apply() {
    if(!this.validate())return;
    if(this.pending.kind==='library'){this.flow.data=this.prepared;this.flow.reset();}
    else window.ConversationCsv.importConversation(this.flow,this.pending.records,this.mode());
    this.pending=null;document.getElementById('csvFile').value='';document.getElementById('importControls').hidden=true;
    document.getElementById('csvPreview').replaceChildren();this.status('Import applied to this session. Export to keep a copy.');
    this.onChange();
  }
}
document.addEventListener('DOMContentLoaded',()=>new App(window.CONVERSATION_DATA).init());
