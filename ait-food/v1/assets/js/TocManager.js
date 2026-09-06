export default class TocManager {
  constructor(container, selector='.aitb-recipe-card'){this.container=container;this.selector=selector;}
  build(){this.container.innerHTML=[...document.querySelectorAll(this.selector)].map((el,i)=>{const title=el.querySelector('h3')?.textContent||`Recipe ${i+1}`;return `<a href="#${el.id}"><span>${String(i+1).padStart(2,'0')} — ${title}</span><span>›</span></a>`}).join('');}
}
