(() => {
'use strict';
const PAPER_SIZES={"a0":{"label":"A0","width":841,"height":1189,"unit":"mm","dimensions":"841 × 1189 mm","group":"ISO A"},"a1":{"label":"A1","width":594,"height":841,"unit":"mm","dimensions":"594 × 841 mm","group":"ISO A"},"a2":{"label":"A2","width":420,"height":594,"unit":"mm","dimensions":"420 × 594 mm","group":"ISO A"},"a3":{"label":"A3","width":297,"height":420,"unit":"mm","dimensions":"297 × 420 mm","group":"ISO A"},"a4":{"label":"A4","width":210,"height":297,"unit":"mm","dimensions":"210 × 297 mm","group":"ISO A"},"a5":{"label":"A5","width":148,"height":210,"unit":"mm","dimensions":"148 × 210 mm","group":"ISO A"},"a6":{"label":"A6","width":105,"height":148,"unit":"mm","dimensions":"105 × 148 mm","group":"ISO A"},"a7":{"label":"A7","width":74,"height":105,"unit":"mm","dimensions":"74 × 105 mm","group":"ISO A"},"a8":{"label":"A8","width":52,"height":74,"unit":"mm","dimensions":"52 × 74 mm","group":"ISO A"},"a9":{"label":"A9","width":37,"height":52,"unit":"mm","dimensions":"37 × 52 mm","group":"ISO A"},"a10":{"label":"A10","width":26,"height":37,"unit":"mm","dimensions":"26 × 37 mm","group":"ISO A"},"b0":{"label":"B0","width":1000,"height":1414,"unit":"mm","dimensions":"1000 × 1414 mm","group":"ISO B"},"b1":{"label":"B1","width":707,"height":1000,"unit":"mm","dimensions":"707 × 1000 mm","group":"ISO B"},"b2":{"label":"B2","width":500,"height":707,"unit":"mm","dimensions":"500 × 707 mm","group":"ISO B"},"b3":{"label":"B3","width":353,"height":500,"unit":"mm","dimensions":"353 × 500 mm","group":"ISO B"},"b4":{"label":"B4","width":250,"height":353,"unit":"mm","dimensions":"250 × 353 mm","group":"ISO B"},"b5":{"label":"B5","width":176,"height":250,"unit":"mm","dimensions":"176 × 250 mm","group":"ISO B"},"b6":{"label":"B6","width":125,"height":176,"unit":"mm","dimensions":"125 × 176 mm","group":"ISO B"},"b7":{"label":"B7","width":88,"height":125,"unit":"mm","dimensions":"88 × 125 mm","group":"ISO B"},"b8":{"label":"B8","width":62,"height":88,"unit":"mm","dimensions":"62 × 88 mm","group":"ISO B"},"b9":{"label":"B9","width":44,"height":62,"unit":"mm","dimensions":"44 × 62 mm","group":"ISO B"},"b10":{"label":"B10","width":31,"height":44,"unit":"mm","dimensions":"31 × 44 mm","group":"ISO B"},"c0":{"label":"C0","width":917,"height":1297,"unit":"mm","dimensions":"917 × 1297 mm","group":"ISO C"},"c1":{"label":"C1","width":648,"height":917,"unit":"mm","dimensions":"648 × 917 mm","group":"ISO C"},"c2":{"label":"C2","width":458,"height":648,"unit":"mm","dimensions":"458 × 648 mm","group":"ISO C"},"c3":{"label":"C3","width":324,"height":458,"unit":"mm","dimensions":"324 × 458 mm","group":"ISO C"},"c4":{"label":"C4","width":229,"height":324,"unit":"mm","dimensions":"229 × 324 mm","group":"ISO C"},"c5":{"label":"C5","width":162,"height":229,"unit":"mm","dimensions":"162 × 229 mm","group":"ISO C"},"c6":{"label":"C6","width":114,"height":162,"unit":"mm","dimensions":"114 × 162 mm","group":"ISO C"},"c7":{"label":"C7","width":81,"height":114,"unit":"mm","dimensions":"81 × 114 mm","group":"ISO C"},"c8":{"label":"C8","width":57,"height":81,"unit":"mm","dimensions":"57 × 81 mm","group":"ISO C"},"c9":{"label":"C9","width":40,"height":57,"unit":"mm","dimensions":"40 × 57 mm","group":"ISO C"},"c10":{"label":"C10","width":28,"height":40,"unit":"mm","dimensions":"28 × 40 mm","group":"ISO C"},"business-card":{"label":"Business Card","width":85,"height":55,"unit":"mm","dimensions":"85 × 55 mm","group":"Card"},"letter":{"label":"Letter","width":8.5,"height":11,"unit":"in","dimensions":"8.5 × 11 in","group":"North America"},"legal":{"label":"Legal","width":8.5,"height":14,"unit":"in","dimensions":"8.5 × 14 in","group":"North America"},"tabloid":{"label":"Tabloid","width":11,"height":17,"unit":"in","dimensions":"11 × 17 in","group":"North America"},"ledger":{"label":"Ledger","width":17,"height":11,"unit":"in","dimensions":"17 × 11 in","group":"North America"},"executive":{"label":"Executive","width":7.25,"height":10.5,"unit":"in","dimensions":"7.25 × 10.5 in","group":"North America"},"statement":{"label":"Statement","width":5.5,"height":8.5,"unit":"in","dimensions":"5.5 × 8.5 in","group":"North America"},"folio":{"label":"Folio","width":8.5,"height":13,"unit":"in","dimensions":"8.5 × 13 in","group":"North America"},"quarto":{"label":"Quarto","width":8.5,"height":10.83,"unit":"in","dimensions":"8.5 × 10.83 in","group":"North America"},"government-letter":{"label":"Government Letter","width":8,"height":10.5,"unit":"in","dimensions":"8 × 10.5 in","group":"North America"},"government-legal":{"label":"Government Legal","width":8.5,"height":13,"unit":"in","dimensions":"8.5 × 13 in","group":"North America"},"junior-legal":{"label":"Junior Legal","width":5,"height":8,"unit":"in","dimensions":"5 × 8 in","group":"North America"},"ansi-c":{"label":"ANSI C","width":17,"height":22,"unit":"in","dimensions":"17 × 22 in","group":"ANSI"},"ansi-d":{"label":"ANSI D","width":22,"height":34,"unit":"in","dimensions":"22 × 34 in","group":"ANSI"},"ansi-e":{"label":"ANSI E","width":34,"height":44,"unit":"in","dimensions":"34 × 44 in","group":"ANSI"},"arch-a":{"label":"ARCH A","width":9,"height":12,"unit":"in","dimensions":"9 × 12 in","group":"Architectural"},"arch-b":{"label":"ARCH B","width":12,"height":18,"unit":"in","dimensions":"12 × 18 in","group":"Architectural"},"arch-c":{"label":"ARCH C","width":18,"height":24,"unit":"in","dimensions":"18 × 24 in","group":"Architectural"},"arch-d":{"label":"ARCH D","width":24,"height":36,"unit":"in","dimensions":"24 × 36 in","group":"Architectural"},"arch-e":{"label":"ARCH E","width":36,"height":48,"unit":"in","dimensions":"36 × 48 in","group":"Architectural"},"4x6":{"label":"Photo 4×6","width":4,"height":6,"unit":"in","dimensions":"4 × 6 in","group":"Photo"},"5x7":{"label":"Photo 5×7","width":5,"height":7,"unit":"in","dimensions":"5 × 7 in","group":"Photo"},"8x10":{"label":"Photo 8×10","width":8,"height":10,"unit":"in","dimensions":"8 × 10 in","group":"Photo"},"square-5":{"label":"Square 5×5","width":5,"height":5,"unit":"in","dimensions":"5 × 5 in","group":"Photo"},"square-8":{"label":"Square 8×8","width":8,"height":8,"unit":"in","dimensions":"8 × 8 in","group":"Photo"},"index-3x5":{"label":"Index Card 3×5","width":3,"height":5,"unit":"in","dimensions":"3 × 5 in","group":"Card"},"index-4x6":{"label":"Index Card 4×6","width":4,"height":6,"unit":"in","dimensions":"4 × 6 in","group":"Card"},"index-5x8":{"label":"Index Card 5×8","width":5,"height":8,"unit":"in","dimensions":"5 × 8 in","group":"Card"}};
class PrintWorkspace{
  constructor(){this.form=document.getElementById('printConfigForm');this.bind();this.update()}
  bind(){
    this.form.addEventListener('change',()=>this.update());
    document.getElementById('applyButton').addEventListener('click',()=>this.send(false));
    document.getElementById('previewButton').addEventListener('click',()=>this.openPreview());
    document.getElementById('resetButton').addEventListener('click',()=>setTimeout(()=>this.update(),0));
    document.querySelectorAll('[data-paper-preset]').forEach(button=>button.addEventListener('click',()=>{
      document.getElementById('paperSizeSelect').value=button.dataset.paperPreset;
      this.update();
    }));
    document.querySelectorAll('[data-close-preview]').forEach(button=>button.addEventListener('click',()=>this.closePreview()));
    document.getElementById('modalPrintButton').addEventListener('click',()=>{
      this.closePreview();
      this.send(true);
    });
    addEventListener('keydown',event=>{
      if(event.key==='Escape'&&!document.getElementById('printPreviewModal').hidden)this.closePreview();
    });
    addEventListener('message',e=>{if(e.data?.type==='ait-pha-theme')document.documentElement.dataset.theme=e.data.theme});
  }
  value(name){return this.form.elements[name]?.value||''}
  checked(name){return Boolean(this.form.elements[name]?.checked)}
  config(){return{mode:this.value('mode'),paper:this.value('paper'),orientation:this.value('orientation'),bookType:this.value('bookType'),binding:this.value('binding'),duplex:this.checked('duplex'),cropMarks:this.checked('cropMarks'),pageNumbers:this.checked('pageNumbers'),printQuality:this.value('printQuality'),printerType:this.value('printerType'),resolution:Number(this.value('resolution')||300),colorProfile:this.value('colorProfile'),pdfStandard:this.value('pdfStandard'),renderingIntent:this.value('renderingIntent'),bleed:Number(this.value('bleed')||0),safeMargin:Number(this.value('safeMargin')||10),spineMode:this.value('spineMode'),spineWidth:Number(this.value('spineWidth')||0),coverType:this.value('coverType'),coverStock:this.value('coverStock'),insidePaper:this.value('insidePaper'),lamination:this.value('lamination'),finishing:this.value('finishing'),imposition:this.value('imposition'),spotUv:this.checked('spotUv'),foilLayer:this.checked('foilLayer'),insideCover:this.checked('insideCover')}}
  update(){
    const c=this.config(),book=c.mode==='book';
    document.querySelectorAll('.pw-book-only').forEach(s=>s.hidden=!book);
    summaryMode.textContent=book?'Book':'Normal';
    const paper=PAPER_SIZES[c.paper]||PAPER_SIZES.a4;
    summaryPaper.textContent=paper.label;
    document.getElementById('paperFamilyValue').textContent=paper.group;
    document.getElementById('paperDimensionsValue').textContent=paper.dimensions;
    document.querySelectorAll('[data-paper-preset]').forEach(button=>button.classList.toggle('is-active',button.dataset.paperPreset===c.paper));
    summaryOrientation.textContent=this.label(c.orientation);
    summaryBookType.textContent=book?this.label(c.bookType):'—';
    summaryBinding.textContent=book?this.label(c.binding):'—';
    summaryDuplex.textContent=c.duplex?'Yes':'No';

    const saddleSheets={a6:'A5 Landscape',a5:'A4 Landscape',a4:'A3 Landscape',a3:'A2 Landscape',a2:'A1 Landscape',a1:'A0 Landscape'};
    summaryOutputSheet.textContent=book&&c.binding==='saddle-stitch'
      ? (saddleSheets[c.paper]||`${paper.label} parent sheet`)
      : `${paper.label} ${this.label(c.orientation)}`;

    const safeMargins={
      normal:'10 mm',
      'saddle-stitch':'8 mm',
      'perfect-binding':'12 mm inner / 8 mm outer',
      'wire-o':'16 mm binding / 8 mm outer'
    };
    summarySafeMargin.textContent=book
      ? safeMargins[c.binding]
      : safeMargins.normal;
    previewSheet.classList.toggle('is-portrait',c.orientation==='portrait');
    const previewPaper=PAPER_SIZES[c.paper]||PAPER_SIZES.a4;
    const ratio=previewPaper.width/previewPaper.height;
    previewSheet.style.aspectRatio=c.orientation==='landscape'?`${1/ratio}/1`:`${ratio}/1`;
    printAdvice.textContent=!book
      ? `Normal ${(PAPER_SIZES[c.paper]||PAPER_SIZES.a4).label} ${c.orientation} printing is selected.`
      : c.binding==='saddle-stitch'
        ? `${(PAPER_SIZES[c.paper]||PAPER_SIZES.a4).label} is the folded page size. The PDF uses ${saddleSheets[c.paper]} sheets with two pages side by side. Print duplex and flip on the short edge.`
        : c.binding==='perfect-binding'
          ? 'Perfect Binding uses sequential pages with mirrored inner gutters.'
          : 'Wire-O reserves a larger inner punch margin.';
  }
  openPreview(){
    const config=this.config();
    this.renderSelectedConfiguration(config);
    this.renderSuggestedPrinterConfiguration(config);
    this.renderImpositionPreview(config);

    const modal=document.getElementById('printPreviewModal');
    modal.hidden=false;
    modal.setAttribute('aria-hidden','false');
    document.body.classList.add('pw-modal-open');
  }

  closePreview(){
    const modal=document.getElementById('printPreviewModal');
    modal.hidden=true;
    modal.setAttribute('aria-hidden','true');
    document.body.classList.remove('pw-modal-open');
  }

  renderSelectedConfiguration(config){
    const rows=[
      ['Mode',this.label(config.mode)],
      ['Paper',(PAPER_SIZES[config.paper]||PAPER_SIZES.a4).label],
      ['Orientation',this.label(config.orientation)],
      ['Book type',config.mode==='book'?this.label(config.bookType):'Not applicable'],
      ['Binding',config.mode==='book'?this.label(config.binding):'Not applicable'],
      ['Duplex',config.duplex?'Yes':'No'],
      ['Crop marks',config.cropMarks?'Yes':'No'],
      ['Page numbers',config.pageNumbers?'Yes':'No'],['Print quality',this.label(config.printQuality)],['Printer type',this.label(config.printerType)],['Resolution',`${config.resolution} DPI`],['Color intent',this.label(config.colorProfile)],['PDF standard',this.label(config.pdfStandard)],['Bleed',`${config.bleed} mm`],['Safe margin',`${config.safeMargin} mm`],['Spine',config.spineMode==='auto'?'Auto':`${config.spineWidth} mm`],['Cover',config.mode==='book'?this.label(config.coverType):'Not applicable'],['Lamination',config.mode==='book'?this.label(config.lamination):'Not applicable'],['Finishing',config.mode==='book'?this.label(config.finishing):'Not applicable']
    ];
    document.getElementById('selectedConfiguration').innerHTML=this.renderDetails(rows);
  }

  renderSuggestedPrinterConfiguration(config){
    const suggestion=this.printerSuggestion(config);
    const rows=[
      ['Printer paper',suggestion.paper],
      ['Printer orientation',suggestion.orientation],
      ['Two-sided',suggestion.duplex],
      ['Flip edge',suggestion.flip],
      ['Scale',suggestion.scale],
      ['Margins',suggestion.margins],
      ['Pages per sheet',suggestion.pagesPerSheet],
      ['Page order',suggestion.order]
    ];

    document.getElementById('suggestedPrinterConfiguration').innerHTML=this.renderDetails(rows);
    document.getElementById('printerDeviceNote').innerHTML=`
      <b>Device note</b>
      <p>${suggestion.note}</p>
    `;
  }

  printerSuggestion(config){
    if(config.mode!=='book'){
      return{
        paper:(PAPER_SIZES[config.paper]||PAPER_SIZES.a4).label,
        orientation:this.label(config.orientation),
        duplex:config.duplex?'On':'Optional',
        flip:config.orientation==='landscape'?'Short edge':'Long edge',
        scale:'100% / Actual size',
        margins:'None or Default',
        pagesPerSheet:'1',
        order:'Sequential',
        note:'Use the browser print dialog with Actual size or 100% scale. Disable any additional booklet or multiple-pages-per-sheet option.'
      };
    }

    if(config.binding==='saddle-stitch'){
      const sheets={a6:'A5',a5:'A4',a4:'A3',a3:'A2',a2:'A1',a1:'A0'};
      return{
        paper:sheets[config.paper]||`${(PAPER_SIZES[config.paper]||PAPER_SIZES.a4).label} parent sheet`,
        orientation:'Landscape',
        duplex:'On',
        flip:'Short edge',
        scale:'100% / Actual size',
        margins:'None',
        pagesPerSheet:'1 imposed sheet side',
        order:'Already booklet-imposed',
        note:'Do not enable the printer driver booklet option. The application already arranges two final pages on each sheet side. Print all PDF pages in order, duplex, flip on the short edge, then fold and staple.'
      };
    }

    if(config.binding==='perfect-binding'){
      return{
        paper:(PAPER_SIZES[config.paper]||PAPER_SIZES.a4).label,
        orientation:this.label(config.orientation),
        duplex:config.duplex?'On':'Optional',
        flip:config.orientation==='landscape'?'Short edge':'Long edge',
        scale:'100% / Actual size',
        margins:'None',
        pagesPerSheet:'1',
        order:'Sequential',
        note:'Pages use mirrored inner gutters. Print in normal sequential order. Do not enable booklet imposition in the printer driver.'
      };
    }

    return{
      paper:(PAPER_SIZES[config.paper]||PAPER_SIZES.a4).label,
      orientation:this.label(config.orientation),
      duplex:config.duplex?'On':'Optional',
      flip:config.orientation==='landscape'?'Short edge':'Long edge',
      scale:'100% / Actual size',
      margins:'None',
      pagesPerSheet:'1',
      order:'Sequential',
      note:'A wider binding edge is reserved for punching. Confirm that the printer is not applying Fit to page.'
    };
  }

  renderImpositionPreview(config){
    const sheet=document.getElementById('impositionSheet');
    const warning=document.getElementById('previewWarning');

    sheet.className='pw-imposition-sheet';
    sheet.innerHTML='<div class="pw-sheet-safe-area" aria-hidden="true"></div>';
    sheet.dataset.paper=config.paper;
    sheet.dataset.orientation=config.orientation;
    sheet.dataset.binding=config.binding||'normal';

    const addPage=(label,className='')=>{
      const page=document.createElement('div');
      page.className=`pw-imposition-page ${className}`.trim();
      page.innerHTML=`<div class="pw-imposition-page__safe"><span>${label}</span></div>`;
      sheet.appendChild(page);
    };

    if(config.mode==='book'&&config.binding==='saddle-stitch'){
      sheet.classList.add('is-landscape','is-booklet');
      addPage('Last','is-left');
      addPage('1','is-right');
      warning.innerHTML='<b>Saddle-Stitch:</b> Preview shows the front side of an imposed sheet. The reverse side uses the next/previous page pair.';
      return;
    }

    sheet.classList.toggle('is-landscape',config.orientation==='landscape');
    sheet.classList.toggle('is-portrait',config.orientation==='portrait');

    if(config.mode==='book'){
      addPage('L','is-facing-left');
      addPage('R','is-facing-right');
      warning.innerHTML=`<b>${this.label(config.binding)}:</b> Preview shows sequential facing pages with binding margin.`;
      return;
    }

    addPage('1');
    warning.innerHTML='<b>Normal print:</b> One document page is printed on each sheet side.';
  }

  renderDetails(rows){
    return rows.map(([term,value])=>`
      <div>
        <dt>${term}</dt>
        <dd>${value}</dd>
      </div>
    `).join('');
  }

  send(print){parent.postMessage({type:'ait-pha-print-request',config:this.config(),print:Boolean(print)},'*')}
  label(v){return String(v||'').split('-').map(w=>w.charAt(0).toUpperCase()+w.slice(1)).join(' ')}
}
document.addEventListener('DOMContentLoaded',()=>new PrintWorkspace());
})();