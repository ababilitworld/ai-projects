'use strict';
const e=value=>String(value).replace(/[&<>"']/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
class App {
 constructor(data){this.flow=new ConversationFlow(data);}
 choice(action,value,label,detail=''){return `<button class="choice" data-${action}="${e(value)}"><strong>${e(label)}</strong><small>${e(detail)}</small></button>`;}
 exchange(n){const f=this.flow;return `<section class="chat-thread"><header class="chat-heading"><h3>${e(f.title(n))}</h3></header>${window.conversationHasTopic(n)?`<h4 class="chat-subtopic">${e(f.data[n.t].title)} / ${e(f.data[n.t].subtopics[n.s].title)}</h4>`:''}<p class="context-strip">${e(n.place)} · ${e(CONVERSATION_MOODS[n.mood].label)}</p><div class="chat-exchange">${f.lines(n).map(l=>`<article class="bubble message-bubble ${l.speaker==='Child'?'child':''}"><div class="message-meta"><strong>${e(l.speaker)}</strong><div class="message-details">${e(f.title(n))} · ${e(f.stage(n).candidates[n.pattern].label)}</div></div><p class="message-text">${e(l.text)}</p></article>`).join('')}</div></section>`;}
 init(){
  const picker=document.getElementById('theme'),themes=['ocean','emerald','midnight','sunset','royal','rose','gold','cyan','slate'];picker.innerHTML=themes.map(t=>`<option>${t}</option>`).join('');
  try{const saved=localStorage.getItem('mtc-theme');if(themes.includes(saved))picker.value=saved;}catch{}
  const theme=()=>{document.getElementById('themeCss').href=`assets/css/themes/${picker.value}.css`;try{localStorage.setItem('mtc-theme',picker.value);}catch{}};picker.onchange=theme;theme();
  document.getElementById('showDialog').onclick=()=>{document.querySelectorAll('.menubar details').forEach(d=>d.open=false);document.getElementById('workspace').focus();};
  document.getElementById('print').onclick=()=>window.print();document.getElementById('restart').onclick=()=>{if(confirm('Start fresh and clear this conversation?')){this.flow.reset();this.render(true);}};
  this.csv=new CsvPanel(this.flow,()=>this.render(true));
  document.querySelector('main').onclick=event=>{
   const b=event.target.closest('button');if(!b)return;const d=b.dataset,f=this.flow;
   if('print'in d){window.print();return;}
   if('visit'in d)f.visit(+d.visit);
   else if('place'in d)f.choosePlace(d.place);
   else if('mood'in d){const place=document.getElementById('conversationPlace').value;if(!f.validPlace(place)){document.getElementById('choiceError').textContent='Enter a place between 1 and 80 characters.';return;}f.chooseMood(+d.mood,place);}
   else if('topic'in d)f.chooseTopic(+d.topic);
   else if('subtopic'in d)f.chooseSubtopic(+d.subtopic);
   else if('branch'in d)f.branch(d.branch);
   else if('direction'in d)f.chooseDirection(d.direction);
   else if('structure'in d){f.previewStructure(+d.structure);this.render();document.querySelector(`[data-structure="${+d.structure}"]`).focus({preventScroll:true});return;}
   else if('useStructure'in d)f.useStructure();
   else if('editStructure'in d)f.editStructure();
   else if('next'in d)f.next();
   else if('pattern'in d)f.selectPattern(+d.pattern);
   else return;
   this.render(true);
  };
  document.querySelector('main').onsubmit=event=>{if(event.target.id!=='customPlaceForm')return;event.preventDefault();const place=new FormData(event.target).get('place');if(!this.flow.validPlace(place)){document.getElementById('choiceError').textContent='Enter a place between 1 and 80 characters.';return;}this.flow.choosePlace(place);this.render(true);};this.render();
 }
 render(focus=false){
  const f=this.flow,n=f.current,moods=CONVERSATION_MOODS;let body='',hint='';
  if(n.type==='place'){
   hint='Where are the speakers? Choose a place, or enter another setting. You can change it before each subtopic.';
   body='<div class="choices">'+CONVERSATION_PLACES.map(p=>this.choice('place',p.label,p.label,p.setting)).join('')+'</div><form id="customPlaceForm"><label>Other place <input name="place" maxlength="80" required placeholder="e.g. Library"></label><button class="primary">Use this place</button></form>';
  }else if(n.type==='mood'){
   hint=n.scope==='greeting'?'Choose your mood before saying hello.':`${f.data[n.t].title} / ${f.data[n.t].subtopics[n.s].title}. Confirm the place and choose a mood to begin.`;
   body=`<label class="context-place">Place <input id="conversationPlace" list="places" maxlength="80" value="${e(n.place)}"><datalist id="places">${CONVERSATION_PLACES.map(p=>`<option value="${e(p.label)}">`).join('')}</datalist></label><div class="choices">${moods.map((m,i)=>this.choice('mood',i,`${m.icon} ${m.label}`,CONVERSATION_DIRECTIONS[m.label])).join('')}</div>${n.scope==='subtopic'?`<button data-mood="${n.mood}">Keep previous mood: ${e(moods[n.mood].label)}</button>`:''}`;
  }else if(n.type==='structure'){
   const stage=f.stage(),selected=n.preview;
   hint='Preview both speakers, select a conversation structure, then use it for this exchange.';
   body=`<p class="context-strip">${e(n.place)} · ${e(moods[n.mood].label)}${window.conversationHasTopic(n)?` · ${e(f.data[n.t].title)} / ${e(f.data[n.t].subtopics[n.s].title)}`:''}</p><p class="small muted">${e(CONVERSATION_DIRECTIONS[moods[n.mood].label])}</p><div class="structure-grid" role="group" aria-label="Conversation structures">${stage.candidates.map((c,i)=>{
     const definition=window.CONVERSATION_STRUCTURES.find(s=>s.label===c.label);
     const lines=f.lines({...n,pattern:i});
     return `<button class="structure-card ${selected===i?'selected':''}" data-structure="${i}" aria-pressed="${selected===i}"><strong>${i+1}. ${e(c.label)}</strong><span class="structure-description">${e(definition?.description||'Imported conversation wording.')}</span><span class="structure-preview">${lines.map(l=>`<span><b>${e(l.speaker)}:</b> ${e(l.text)}</span>`).join('')}</span></button>`;
   }).join('')}</div><div class="structure-confirm"><p id="structureSelection" role="status">${selected==null?'Select a structure above.':`Selected: ${e(stage.candidates[selected].label)}`}</p><button class="primary" data-use-structure ${selected==null?'disabled':''}>Use this structure →</button></div>`;
  }else if(n.type==='topic'){
   hint=`Suggestions for ${n.place}; every topic is available.`;body='<div class="choices">'+f.data.map((t,i)=>this.choice('topic',i,t.title,`${f.suggestions().includes(t.title)?'Suggested here · ':''}${t.subtopics.length} subtopics`)).join('')+'</div>';
  }else if(n.type==='subtopic'){
   hint=f.data[n.t].title;body='<div class="choices">'+f.data[n.t].subtopics.map((s,i)=>this.choice('subtopic',i,s.title,'Introduction → Description → Conclusion → Invitation')).join('')+'</div>';
  }else if(n.type==='decision'){
   hint='The invitation continues the same topic. Decide whether to keep talking or finish.';body='<div class="choices">'+this.choice('branch','continue','Continue talking','Choose a new topic or another subtopic.')+this.choice('branch','finish','Finish','Finishing → Goodbye')+'</div>';
  }else if(n.type==='direction'){
   hint='Choose where to go next.';body='<div class="choices">'+this.choice('direction','topic','New topic','Return to the topic proposal.')+this.choice('direction','subtopic','Another subtopic',f.data[n.t].title)+'</div>';
  }else if(n.type==='complete'){
   hint='Review your conversation below, or print it.';body='<button class="primary" data-print>Print conversation</button>';
  }else{
   const stage=f.stage();hint=CONVERSATION_DIRECTIONS[moods[n.mood].label];
   body=`${window.conversationHasTopic(n)?`<ol class="phase-track" aria-label="Subtopic stages">${['Introduction','Description','Conclusion','Invitation'].map(label=>`<li ${n.part.startsWith(label.toLowerCase())?'aria-current="step"':''}>${label}</li>`).join('')}</ol>`:''}${n.customLines?'<p class="edit-notice">Imported dialogue is preserved, including its original wording.</p>':''}${this.exchange(n)}<div class="step-actions"><button data-edit-structure>Change conversation structure</button><span class="small muted">Practise both parts aloud.</span><button class="primary" data-next>Continue →</button></div>`;
  }
  document.getElementById('workspace').innerHTML=`<div class="workspace-heading"><p class="eyebrow">YOUR CONVERSATION</p><h2>${e(f.title(n))}</h2><p class="muted">${e(hint)}</p></div>${n.confirmed&&n.type!=='speech'?`<p class="edit-notice">${n.type==='structure'?'Changing the structure updates this exchange and keeps your conversation path.':'Changing this choice replaces later steps.'}</p>`:''}${body}<p id="choiceError" role="alert"></p>`;
  document.getElementById('roadmap').innerHTML='<ol class="timeline">'+f.nodes.map((x,i)=>`<li class="${x===n?'current':x.confirmed?'done':'pending'}"><button data-visit="${x.id}" ${i<=f.cursor||f.nodes.slice(0,i).every(y=>y.confirmed)?'':'disabled'} ${x===n?'aria-current="step"':''}><span class="node-dot">${x.confirmed?'✓':i+1}</span><span><strong>${e(f.title(x))}</strong>${window.conversationHasTopic(x)?`<small>${e(f.data[x.t].subtopics[x.s].title)}</small>`:''}</span></button></li>`).join('')+'</ol>';
  document.getElementById('stepCount').textContent=`${f.nodes.filter(x=>x.confirmed).length} completed`;
  document.getElementById('summary').innerHTML=f.transcript().map(x=>this.exchange(x)).join('')||'<p class="muted">Choose a place and greeting mood to begin.</p>';
  document.getElementById('announcement').textContent=f.title(n);
  if(focus){const panel=document.getElementById('workspace');panel.focus({preventScroll:true});panel.scrollIntoView({block:'start'});}
 }
}
