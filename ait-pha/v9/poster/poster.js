(() => {
'use strict';
class PosterWorkspace{
  constructor(){this.form=document.getElementById('posterConfigForm');this.bind();this.update()}
  bind(){
    this.form.addEventListener('change',()=>this.update());
    this.form.addEventListener('input',()=>this.update());
    document.getElementById('resetPoster').addEventListener('click',()=>setTimeout(()=>this.update(),0));
    document.getElementById('applyPoster').addEventListener('click',()=>this.send(false));
    document.getElementById('previewPoster').addEventListener('click',()=>this.openPreview());
    document.getElementById('printPoster').addEventListener('click',()=>{this.closePreview();this.send(true)});
    document.querySelectorAll('[data-close-poster-preview]').forEach(el=>el.addEventListener('click',()=>this.closePreview()));
    addEventListener('keydown',e=>{if(e.key==='Escape')this.closePreview()});
  }
  value(n){return this.form.elements[n]?.value||''}
  checked(n){return Boolean(this.form.elements[n]?.checked)}
  config(){return{size:this.value('size'),orientation:this.value('orientation'),layout:this.value('layout'),source:this.value('source'),pageRange:this.value('pageRange'),density:this.value('density'),showTitle:this.checked('showTitle'),showPageNumbers:this.checked('showPageNumbers'),showQr:this.checked('showQr'),theme:this.value('theme'),typography:this.value('typography'),radius:Number(this.value('radius')||0),gap:Number(this.value('gap')||0),bleed:Number(this.value('bleed')||0),safeMargin:Number(this.value('safeMargin')||10),printerType:this.value('printerType'),resolution:Number(this.value('resolution')||300),colorProfile:this.value('colorProfile'),mounting:this.value('mounting'),finishing:this.value('finishing'),cropMarks:this.checked('cropMarks'),registrationMarks:this.checked('registrationMarks'),includeBackground:this.checked('includeBackground'),customWidth:Number(this.value('customWidth')||420),customHeight:Number(this.value('customHeight')||594)}}
  update(){
    const c=this.config();customSizeFields.hidden=c.size!=='custom';
    sumSize.textContent=c.size==='custom'?`${c.customWidth} × ${c.customHeight} mm`:c.size.toUpperCase();
    sumOrientation.textContent=this.label(c.orientation);sumLayout.textContent=this.label(c.layout);sumDensity.textContent=this.label(c.density);sumBleed.textContent=`${c.bleed} mm`;sumSafe.textContent=`${c.safeMargin} mm`;sumDevice.textContent=this.label(c.printerType);
    miniPreview.style.aspectRatio=c.orientation==='landscape'?'1.414/1':'1/1.414';
    miniPreview.querySelector('.ps-mini-grid').style.gridTemplateColumns=c.layout==='timeline'?'1fr':c.layout==='infographic'?'repeat(3,1fr)':'repeat(2,1fr)';
    posterAdvice.textContent=`${sumSize.textContent} ${c.orientation} poster using ${this.label(c.layout)} layout and ${this.label(c.density)} content density.`;
  }
  openPreview(){
    const c=this.config();this.renderConfig(c);this.renderDevice(c);this.renderCanvas(c);
    posterPreviewModal.hidden=false;posterPreviewModal.setAttribute('aria-hidden','false');document.body.style.overflow='hidden';
  }
  closePreview(){posterPreviewModal.hidden=true;posterPreviewModal.setAttribute('aria-hidden','true');document.body.style.overflow=''}
  renderConfig(c){
    const rows=[['Size',c.size==='custom'?`${c.customWidth} × ${c.customHeight} mm`:c.size.toUpperCase()],['Orientation',this.label(c.orientation)],['Layout',this.label(c.layout)],['Source',this.label(c.source)],['Pages',c.pageRange||'Auto'],['Density',this.label(c.density)],['Bleed',`${c.bleed} mm`],['Safe margin',`${c.safeMargin} mm`],['Resolution',`${c.resolution} DPI`],['Color',this.label(c.colorProfile)],['Mounting',this.label(c.mounting)],['Finishing',this.label(c.finishing)]];
    posterSelectedConfig.innerHTML=this.rows(rows);
  }
  renderDevice(c){
    const scale=c.size==='a0'||c.size==='a1'||c.size==='24x36'?'Large-format printer':'Digital press or capable desktop printer';
    const rows=[['Device',this.label(c.printerType)],['Paper',c.size==='custom'?`${c.customWidth} × ${c.customHeight} mm`:c.size.toUpperCase()],['Orientation',this.label(c.orientation)],['Scale','100% / Actual size'],['Margins','None'],['Background graphics',c.includeBackground?'On':'Optional'],['Color mode',this.label(c.colorProfile)]];
    posterDeviceConfig.innerHTML=this.rows(rows);posterDeviceNote.textContent=`Recommended: ${scale}. Use ${c.resolution} DPI artwork, ${c.bleed} mm bleed and ${c.safeMargin} mm safe margin.`;
  }
  renderCanvas(c){
    posterPreviewCanvas.className='ps-preview-canvas';posterPreviewCanvas.classList.toggle('is-landscape',c.orientation==='landscape');
    posterPreviewCanvas.style.setProperty('--preview-radius',`${c.radius}px`);posterPreviewCanvas.style.setProperty('--preview-gap',`${c.gap}px`);
    previewPosterTitle.textContent=c.showTitle?'Personal Health Assistant Poster':'';
    const count=c.density==='minimal'?3:c.density==='detailed'?8:6;
    previewPosterCards.innerHTML=Array.from({length:count},(_,i)=>`<article><b>${String(i+1).padStart(2,'0')}</b><span></span><small></small></article>`).join('');
    previewPosterCards.dataset.layout=c.layout;
  }
  rows(rows){return rows.map(([k,v])=>`<div><dt>${k}</dt><dd>${v}</dd></div>`).join('')}
  send(print){parent.postMessage({type:'ait-pha-poster-request',config:this.config(),print:Boolean(print)},'*')}
  label(v){return String(v||'').split('-').map(w=>w.charAt(0).toUpperCase()+w.slice(1)).join(' ')}
}
document.addEventListener('DOMContentLoaded',()=>new PosterWorkspace());
})();