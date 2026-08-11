(() => {
'use strict';
const params=new URLSearchParams(location.search);
const allowed=['saddle-stitch','perfect-binding','wire-o'];
const initial=allowed.includes(params.get('binding'))?params.get('binding'):'saddle-stitch';
const radios=[...document.querySelectorAll('input[name="binding"]')];
const labels={
 'saddle-stitch':{name:'Saddle-Stitch',sheet:'A4 Landscape',order:'Booklet',note:'Print double-sided, flip on short edge. Fold sheets at the centre and staple through the fold.'},
 'perfect-binding':{name:'Perfect Binding',sheet:'A5 Portrait',order:'Sequential',note:'Print double-sided. The engine mirrors inner and outer margins for left/right pages.'},
 'wire-o':{name:'Wire-O',sheet:'A5 Portrait',order:'Sequential',note:'Print double-sided or single-sided according to your binding setup. Extra inner margin is reserved for punching.'}
};
function selected(){return radios.find(r=>r.checked)?.value||initial}
function sync(){const v=labels[selected()];bindingValue.textContent=v.name;sheetValue.textContent=v.sheet;orderValue.textContent=v.order;bindingNote.textContent=v.note}
function send(print=false){parent.postMessage({type:'ait-pha-print-request',config:{mode:'book',binding:selected()},print},'*')}
radios.forEach(r=>{r.checked=r.value===initial;r.addEventListener('change',sync)});
document.getElementById('applyButton').addEventListener('click',()=>send(false));
document.getElementById('printButton').addEventListener('click',()=>send(true));
addEventListener('message',e=>{if(e.data?.type==='ait-pha-theme'){document.documentElement.dataset.theme=e.data.theme}});
sync();
})();