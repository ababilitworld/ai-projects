export default class ThemeManager {
  constructor(root=document.documentElement){this.root=root;this.key='aitb-theme';}
  init(){const saved=localStorage.getItem(this.key);if(saved)this.root.dataset.aitbTheme=saved;}
  toggle(){const next=this.root.dataset.aitbTheme==='dark'?'light':'dark';this.root.dataset.aitbTheme=next;localStorage.setItem(this.key,next);}
}
