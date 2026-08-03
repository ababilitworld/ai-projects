(() => {
'use strict';
const params=new URLSearchParams(location.search);
const initial=params.get('size')==='a5'?'a5':'a4';
const radios=[...document.querySelectorAll('input[name="size"]')];
const sizeValue=document.getElementById('sizeValue');
function selected(){return radios.find(r=>r.checked)?.value||initial}
function sync(){sizeValue.textContent=selected().toUpperCase()}
function send(print=false){parent.postMessage({type:'ait-pha-print-request',config:{mode:'normal',size:selected()},print},'*')}
radios.forEach(r=>{r.checked=r.value===initial;r.addEventListener('change',sync)});
document.getElementById('applyButton').addEventListener('click',()=>send(false));
document.getElementById('printButton').addEventListener('click',()=>send(true));
addEventListener('message',e=>{if(e.data?.type==='ait-pha-theme'){document.documentElement.dataset.theme=e.data.theme}});
sync();
})();