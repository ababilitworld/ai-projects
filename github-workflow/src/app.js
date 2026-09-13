import {stages,playbooks,environments,releaseChecks} from './data.js';
import {BrowserStorage,ReleaseStore,ClipboardService} from './core.js';
import {Pipeline,Playbook,Environments,ReleaseChecklist,Navigation} from './components.js';
export class WorkflowApplication {
  constructor({storage=new BrowserStorage('ai-projects.release-atlas.v1'),clipboard=new ClipboardService(),componentTypes={Pipeline,Playbook,Environments,ReleaseChecklist,Navigation}}={}){Object.assign(this,{storage,clipboard,componentTypes});}
  notify(message){const toast=document.querySelector('#toast');toast.textContent=message;clearTimeout(this.toastTimer);this.toastTimer=setTimeout(()=>{toast.textContent='';},4000);}
  mount(){const C=this.componentTypes;const notify=message=>this.notify(message);this.components=[new C.Pipeline(document.querySelector('#pipeline'),stages),new C.Playbook(document.querySelector('#playbook-content'),playbooks,this.clipboard,notify),new C.Environments(document.querySelector('#environment-cards'),environments),new C.ReleaseChecklist(document.querySelector('#release-checklist'),releaseChecks,new ReleaseStore(this.storage,releaseChecks.map(check=>check.id)),this.clipboard,notify),new C.Navigation([...document.querySelectorAll('.sidebar nav a')])];this.components.forEach(component=>component.mount());document.querySelector('#print-guide').addEventListener('click',()=>window.print());}
}
new WorkflowApplication().mount();
