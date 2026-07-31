(() => {
'use strict';
const root=document.documentElement;
const STORAGE_KEY='ait-pha-integrated-health-plan-v1';
const applyTheme=t=>{root.dataset.theme=t||'dark-glass';root.style.colorScheme=t==='classic-light'?'light':'dark'};
addEventListener('message',e=>{if(e.data?.type==='ait-pha-theme')applyTheme(e.data.theme)});
applyTheme(localStorage.getItem('heart-routine-theme')||'dark-glass');
const q=id=>document.getElementById(id);
const n=(id,f=0)=>{const value=Number(q(id)?.value);return Number.isFinite(value)?value:f};
const clamp=(value,min,max)=>Math.min(max,Math.max(min,value));
const round=(value,d=1)=>Number(value).toFixed(d);
const profile=()=>{try{return JSON.parse(localStorage.getItem(STORAGE_KEY)||'{}')}catch{return {}}};
const save=data=>localStorage.setItem(STORAGE_KEY,JSON.stringify({...profile(),...data,updatedAt:new Date().toISOString()}));
const interpolate=(a,b,index,total)=>a+(b-a)*(index/total);
const bmi=(weight,heightCm)=>weight/((heightCm/100)**2);
const bmr=(sex,weight,heightCm,age)=>10*weight+6.25*heightCm-5*age+(sex==='female'?-161:5);
const bindTabs=()=>document.querySelectorAll('[data-step-target]').forEach(button=>button.addEventListener('click',()=>{
 document.querySelectorAll('[data-step-target]').forEach(x=>x.classList.remove('is-active'));
 document.querySelectorAll('.planner-step').forEach(x=>x.classList.remove('is-active'));
 button.classList.add('is-active');q(button.dataset.stepTarget)?.classList.add('is-active');
}));
window.Planner={q,n,clamp,round,profile,save,interpolate,bmi,bmr,bindTabs};
document.addEventListener('DOMContentLoaded',bindTabs);
})();