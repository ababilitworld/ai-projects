import {Component,element as el,filterSteps} from './core.js';
export class Pipeline extends Component {
  constructor(root, stages) { super(root); this.stages = stages; this.selected = stages[0].id; }
  mount() {
    this.tabs = el('div',{className:'stage-tabs',role:'tablist','aria-label':'Release stages'});
    this.panel = el('div',{className:'stage-panel',role:'tabpanel',id:'stage-panel',tabindex:'0'});
    this.buttons = this.stages.map(stage => el('button',{className:'stage-tab',type:'button',role:'tab',id:`stage-${stage.id}`,'aria-controls':'stage-panel',onclick:()=>this.select(stage.id)},el('span',{},stage.caption),el('strong',{},stage.label)));
    this.tabs.append(...this.buttons);
    this.tabs.addEventListener('keydown', event => {
      const index = this.stages.findIndex(stage => stage.id === this.selected);
      const next = {ArrowRight:(index+1)%this.stages.length,ArrowLeft:(index-1+this.stages.length)%this.stages.length,Home:0,End:this.stages.length-1}[event.key];
      if (next !== undefined) {event.preventDefault();this.select(this.stages[next].id);this.buttons[next].focus();}
    });
    this.render(this.tabs,this.panel); this.select(this.selected);
  }
  select(id) {
    this.selected=id;const stage=this.stages.find(item=>item.id===id);
    this.buttons.forEach((button,index)=>{const active=this.stages[index].id===id;button.setAttribute('aria-selected',String(active));button.tabIndex=active?0:-1;});
    this.panel.setAttribute('aria-labelledby',`stage-${id}`);
    this.panel.replaceChildren(el('div',{},el('h3',{},stage.title),el('p',{},stage.description)),el('div',{className:'stage-meta'},el('div',{},el('strong',{},'NEXT CHECKPOINT'),stage.destination),el('div',{},el('strong',{},'DEPLOYMENT'),stage.site)));
  }
}
export class Playbook extends Component {
  constructor(root, data, clipboard, notify) {super(root);Object.assign(this,{data,clipboard,notify});this.selected=data[0].id;this.query='';}
  mount() {
    this.tabs=el('div',{className:'playbook-tabs','aria-label':'Playbook categories'});
    this.buttons=this.data.map(book=>el('button',{type:'button','aria-pressed':String(book.id===this.selected),onclick:()=>{this.selected=book.id;this.query='';this.search.value='';this.update();}},book.label));
    this.tabs.append(...this.buttons);this.list=el('div',{});this.render(this.tabs,this.list);
    this.search=document.querySelector('#guide-search');this.search.addEventListener('input',()=>{this.query=this.search.value;this.update();});this.update();
  }
  update() {
    this.buttons.forEach((button,index)=>button.setAttribute('aria-pressed',String(!this.query.trim()&&this.data[index].id===this.selected)));
    const steps=filterSteps(this.data,this.selected,this.query);
    this.list.replaceChildren(...steps.map((step,index)=>{
      const body=el('div',{},el('h3',{},step.title),el('p',{},step.body));
      if(this.query.trim())body.prepend(el('div',{className:'eyebrow'},step.category));
      if(step.command)body.append(el('div',{className:'command'},el('pre',{},el('code',{},step.command)),el('button',{className:'copy-button',type:'button','aria-label':`Copy commands: ${step.title}`,onclick:async()=>{try{await this.clipboard.copy(step.command);this.notify('Commands copied.');}catch{this.notify('Clipboard unavailable. Select and copy the command text.');}}},'Copy ↗')));
      if(step.link)body.append(el('a',{href:step.link},step.linkLabel+' ↗'));
      return el('article',{className:'step'},el('span',{className:'step-number'},String(index+1).padStart(2,'0')),body);
    }));
    if(!steps.length)this.list.append(el('p',{className:'empty-state',role:'status'},'No matching steps. Try “preview”, “feature” or “rollback”.'));
  }
}
export class Environments extends Component {
  constructor(root,data){super(root);this.data=data;}
  mount(){this.render(el('div',{className:'env-grid'},this.data.map(env=>el('article',{className:'env-card'},el('div',{className:'eyebrow'},env.caption),el('h3',{},env.title),el('p',{},env.description),el('dl',{},[['Pages project',env.project],['Serving branch',env.branch],['Preview branches',env.preview]].map(([key,value])=>el('div',{},el('dt',{},key),el('dd',{},value)))),el('a',{href:env.url},env.url.replace('https://','')+' ↗')))));}
}
export class ReleaseChecklist extends Component {
  constructor(root,checks,store,clipboard,notify){super(root);Object.assign(this,{checks,store,clipboard,notify});}
  mount(){
    this.reference=document.querySelector('#release-name');this.reference.value=this.store.state.reference;
    this.reference.addEventListener('input',()=>this.saved(this.store.setReference(this.reference.value)));
    this.inputs=this.checks.map(check=>{const input=el('input',{type:'checkbox','aria-label':check.title});input.checked=this.store.state.completed.includes(check.id);input.addEventListener('change',()=>{this.saved(this.store.toggle(check.id,input.checked));this.progress();});return input;});
    this.render(...this.checks.map((check,index)=>el('label',{className:'check-item'},this.inputs[index],el('span',{},check.title,el('small',{},check.detail)))),el('div',{className:'checklist-actions'},el('button',{type:'button',className:'primary-button',onclick:()=>this.copySummary()},'Copy release notes ↗'),el('button',{type:'button',className:'quiet-button',onclick:()=>{this.saved(this.store.reset());this.reference.value='';this.inputs.forEach(input=>input.checked=false);this.progress();this.notify('Checklist reset for your next release.');}},'Reset')));
    this.progress();
  }
  saved(success){if(!success)this.notify('Browser storage is unavailable. Progress will last only for this visit.');}
  progress(){const {done,total,percent}=this.store.progress;document.querySelector('#release-progress').replaceChildren(el('div',{className:'progress-summary',role:'status'},el('span',{},`${done} of ${total} checks complete`),el('strong',{},`${percent}%`)),el('div',{className:'progress-track',role:'progressbar','aria-label':'Release readiness','aria-valuenow':String(percent),'aria-valuemin':'0','aria-valuemax':'100'},el('div',{className:'progress-fill',style:`width:${percent}%`})) );}
  async copySummary(){const text=[`Release: ${this.store.state.reference||'(add version and candidate SHA)'}`,'',...this.checks.map(check=>`- [${this.store.state.completed.includes(check.id)?'x':' '}] ${check.title}`),'','Candidate preview URL:','Test evidence:','Rollback plan:'].join('\n');try{await this.clipboard.copy(text);this.notify('Release notes copied. Paste them into your PR.');}catch{this.notify('Clipboard unavailable. Copy your checklist into the PR manually.');}}
}
export class Navigation {
  constructor(links){this.links=links;}
  mount(){if(!('IntersectionObserver'in window))return;this.observer=new IntersectionObserver(entries=>{entries.forEach(entry=>{if(entry.isIntersecting)this.links.forEach(link=>{const active=link.hash===`#${entry.target.id}`;link.classList.toggle('active',active);if(active)link.setAttribute('aria-current','location');else link.removeAttribute('aria-current');});});},{rootMargin:'-10% 0px -65% 0px'});document.querySelectorAll('.section-anchor').forEach(section=>this.observer.observe(section));}
}
