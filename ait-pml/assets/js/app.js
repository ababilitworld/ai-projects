class App{constructor(){this.data=window.CONVERSATION_DATA;this.t=0;this.s=0;this.g=0;this.m=0;this.sel=new Map();this.$=id=>document.getElementById(id)}init(){this.renderThemes();this.bind();this.render()}key(t=this.t,s=this.s,g=this.g,m=this.m){return`${t}:${s}:${g}:${m}`}moods(){return[
{label:'Neutral',icon:'●',lead:'',reply:''},
{label:'Happy',icon:'😊',lead:'Happily, ',reply:'I’m happy to say '},
{label:'Excited',icon:'🤩',lead:'Excitedly, ',reply:'I’m really excited! '},
{label:'Curious',icon:'🤔',lead:'Curiously, ',reply:'I’m curious too. '},
{label:'Friendly',icon:'🙂',lead:'In a friendly way, ',reply:'Sure! '},
{label:'Polite',icon:'🙏',lead:'Politely, ',reply:'Of course. '},
{label:'Calm',icon:'😌',lead:'Calmly, ',reply:'Okay. '},
{label:'Surprised',icon:'😮',lead:'With surprise, ',reply:'Oh, wow! '},
{label:'Confident',icon:'💪',lead:'Confidently, ',reply:'Absolutely. '}
]}
applyMood(candidate,moodIndex=this.m){
let mood=this.moods()[moodIndex]||this.moods()[0];
if(moodIndex===0)return candidate;
let lines=candidate.lines.map(([speaker,text],i)=>[
speaker,
i===0?`${mood.lead}${text}`:`${mood.reply}${text}`
]);
return {...candidate,pattern:lines[0][1],response:lines[1][1],lines}
}
renderThemes(){let n=['ocean','emerald','midnight','sunset','royal','rose','gold','cyan','slate'];this.$('themeSwitcher').innerHTML=n.map(x=>`<button data-theme="${x}">${x}</button>`).join('');this.applyTheme(localStorage.getItem('theme')||'ocean')}applyTheme(n){this.$('themeCss').href=`assets/css/themes/${n}.css`;localStorage.setItem('theme',n);this.$('themeSwitcher').querySelectorAll('button').forEach(b=>b.classList.toggle('active',b.dataset.theme===n))}bind(){this.$('themeSwitcher').onclick=e=>{let b=e.target.closest('[data-theme]');if(b)this.applyTheme(b.dataset.theme)};this.$('topicTabs').onclick=e=>{let b=e.target.closest('[data-topic]');if(b){this.t=+b.dataset.topic;this.s=0;this.g=0;this.m=0;this.render()}};this.$('subtopicTabs').onclick=e=>{let b=e.target.closest('[data-sub]');if(b){this.s=+b.dataset.sub;this.g=0;this.m=0;this.render()}};this.$('stageTabs').onclick=e=>{let b=e.target.closest('[data-stage]');if(b){this.g=+b.dataset.stage;this.m=0;this.render()}};this.$('moodTabs').onclick=e=>{let b=e.target.closest('[data-mood]');if(b){this.m=+b.dataset.mood;this.render()}};this.$('structureGrid').onclick=e=>{let b=e.target.closest('[data-structure]');if(b){this.sel.set(this.key(),+b.dataset.structure);this.render()}};this.$('prevMoodBtn').onclick=()=>this.moveMood(-1);this.$('nextMoodBtn').onclick=()=>this.moveMood(1);this.$('startBtn').onclick=()=>this.$('trainer').scrollIntoView({behavior:'smooth'});this.$('printBtn').onclick=()=>window.print()}moveMood(d){
let next=this.m+d;
if(next<0)next=this.moods().length-1;
if(next>=this.moods().length)next=0;
this.m=next;
this.render()
}
move(d){let ng=this.g+d,ns=this.s,nt=this.t;if(ng>8){ng=0;ns++;if(ns>8){ns=0;nt++}}if(ng<0){ng=8;ns--;if(ns<0){ns=8;nt--}}if(nt<0||nt>8)return;this.t=nt;this.s=ns;this.g=ng;this.m=0;this.render()}activeConversation(){
let topic=this.data[this.t],sub=topic.subtopics[this.s],stage=sub.stages[this.g],ci=this.sel.get(this.key())||0,c=this.applyMood(stage.candidates[ci],this.m);
return c.lines.map(([speaker,text])=>({speaker,text,t:this.t,s:this.s,g:this.g}))
}
summaryConversation(){
let out=[];
let topic=this.data[this.t];
let firstSub=topic.subtopics[0];

let greetingStage=firstSub.stages.find(stage=>stage.slug==='greeting');
if(greetingStage){
let gi=firstSub.stages.indexOf(greetingStage);
let isActive=this.s===0&&this.g===gi;
let moodIndex=isActive?this.m:0;
let ci=this.sel.get(this.key(this.t,0,gi,moodIndex))||0;
let c=this.applyMood(greetingStage.candidates[ci],moodIndex);
out.push({type:'global-stage',stageTitle:greetingStage.title,g:gi,active:isActive});
c.lines.forEach(([speaker,text])=>out.push({
type:'line',speaker,text,t:this.t,s:0,g:gi,active:isActive
}));
}

out.push({type:'topic',topicTitle:topic.title,t:this.t});

topic.subtopics.forEach((sub,si)=>{
out.push({
type:'subtopic',
topicTitle:topic.title,
subtopicTitle:sub.title,
t:this.t,
s:si,
active:si===this.s
});

sub.stages.forEach((stage,gi)=>{
if(['greeting','ending','goodbye'].includes(stage.slug))return;

let isActive=si===this.s&&gi===this.g;
let moodIndex=isActive?this.m:0;
let ci=this.sel.get(this.key(this.t,si,gi,moodIndex))||0;
let c=this.applyMood(stage.candidates[ci],moodIndex);

out.push({
type:'stage',
stageTitle:stage.title,
t:this.t,
s:si,
g:gi,
active:isActive
});

c.lines.forEach(([speaker,text])=>out.push({
type:'line',
speaker,
text,
t:this.t,
s:si,
g:gi,
active:isActive
}));
});

if(si<topic.subtopics.length-1){
out.push({
type:'subtopic-transition',
text:`Next Sub Topic → ${topic.subtopics[si+1].title}`,
t:this.t,
s:si
});
}
});

let lastSi=topic.subtopics.length-1;
let lastSub=topic.subtopics[lastSi];

['ending','goodbye'].forEach(slug=>{
let stage=lastSub.stages.find(item=>item.slug===slug);
if(!stage)return;

let gi=lastSub.stages.indexOf(stage);
let isActive=this.s===lastSi&&this.g===gi;
let moodIndex=isActive?this.m:0;
let ci=this.sel.get(this.key(this.t,lastSi,gi,moodIndex))||0;
let c=this.applyMood(stage.candidates[ci],moodIndex);

out.push({
type:'global-stage',
stageTitle:stage.title,
g:gi,
active:isActive
});

c.lines.forEach(([speaker,text])=>out.push({
type:'line',
speaker,
text,
t:this.t,
s:lastSi,
g:gi,
active:isActive
}));
});

return out
}
renderDialogue(id,hl){
let lines=this.activeConversation();
this.$(id).innerHTML=lines.map(l=>`<div class="line ${l.speaker==='Child'?'child':''} ${hl?'active':''}"><span>${l.speaker}</span><p>${l.text}</p></div>`).join('')
}
renderSummary(){
let items=this.summaryConversation();
this.$('finalDialogue').innerHTML=items.map(item=>{
if(item.type==='topic'){
return `<div class="summary-topic">${item.topicTitle}</div>`;
}
if(item.type==='subtopic'){
return `<div class="summary-subtopic ${item.active?'active-summary-subtopic':''}">${item.subtopicTitle}</div>`;
}
if(item.type==='subtopic-transition'){
return `<div class="summary-subtopic-transition">${item.text}</div>`;
}
if(item.type==='stage'){
return `<div class="stage-label ${item.active?'active-stage-label':''}">${item.g+1}. ${item.stageTitle}</div>`;
}
if(item.type==='global-stage'){
return `<div class="stage-label global-stage-label ${item.active?'active-stage-label':''}">${item.stageTitle}</div>`;
}
if(item.type==='transition'){
return `<div class="summary-transition">${item.text}</div>`;
}
return `<div class="line ${item.speaker==='Child'?'child':''} ${item.active?'active':''}"><span>${item.speaker}</span><p>${item.text}</p></div>`;
}).join('')
}
render(){let topic=this.data[this.t],sub=topic.subtopics[this.s],stage=sub.stages[this.g],ci=this.sel.get(this.key())||0,c=this.applyMood(stage.candidates[ci],this.m);this.$('topicTabs').innerHTML=this.data.map((x,i)=>`<button data-topic="${i}" class="${i===this.t?'active':''}">${i+1}. ${x.title}</button>`).join('');this.$('subtopicTabs').innerHTML=topic.subtopics.map((x,i)=>`<button data-sub="${i}" class="${i===this.s?'active':''}"><strong>${i+1}. ${x.title}</strong></button>`).join('');this.$('stageTabs').innerHTML=sub.stages.map((x,i)=>`<button data-stage="${i}" class="${i===this.g?'active':''}">${i+1}. ${x.title}</button>`).join('');this.$('moodTabs').innerHTML=this.moods().map((x,i)=>`<button data-mood="${i}" class="${i===this.m?'active':''}"><span>${x.icon}</span><strong>${i+1}. ${x.label}</strong></button>`).join('');

this.$('activeConversationPath').textContent=`Topic: ${topic.title}  •  Sub Topic: ${sub.title}  •  Conversation Stage: ${stage.title}  •  Mood: ${this.moods()[this.m].label}`;
this.$('activeMoodName').textContent=`${this.moods()[this.m].icon} ${this.moods()[this.m].label}`;this.$('structureGrid').innerHTML=stage.candidates.map((x,i)=>`<button data-structure="${i}" class="${i===ci?'active':''}">${i+1}. ${x.label}</button>`).join('');this.renderDialogue('dialogue',true);this.renderSummary()}}document.addEventListener('DOMContentLoaded',()=>new App().init());