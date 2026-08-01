(() => {
'use strict';

class FoodDataWorkspace {
  constructor() {
    this.key='ait-pha-health-planner-v4';
    this.legacyKey='ait-pha-health-planner-v3';
    this.defaultFoods=Array.isArray(window.AIT_BD_FOODS)?window.AIT_BD_FOODS:[];
    this.nutrientKeys=['protein','carbohydrate','fat','fiber','sugar','sodium','calcium','iron','potassium','vitaminC','vitaminA','cholesterol'];
    this.state=this.load();
    this.editingId=null;
    this.applyTheme(localStorage.getItem('heart-routine-theme')||'dark-glass');
    this.migrate();
    this.bind();
    this.render();
    const params=new URLSearchParams(location.search);
    const editId=params.get('edit');
    if(editId){
      this.openEditor(editId);
    }else if(params.get('create')==='1'){
      this.openEditor();
    }
  }
  q(id){return document.getElementById(id)}
  uid(){return crypto?.randomUUID?.()||`food-${Date.now()}-${Math.random().toString(36).slice(2)}`}
  esc(value){const n=document.createElement('div');n.textContent=String(value??'');return n.innerHTML}
  num(value,f=0){const n=Number(value);return Number.isFinite(n)?n:f}
  round(value,d=1){return this.num(value).toFixed(d)}
  applyTheme(theme){document.documentElement.dataset.theme=theme||'dark-glass';document.documentElement.style.colorScheme=theme==='classic-light'?'light':'dark'}
  load(){
    for(const key of [this.key,this.legacyKey]){
      try{const data=JSON.parse(localStorage.getItem(key));if(data&&Array.isArray(data.foods))return data}catch(error){}
    }
    return{schemaVersion:4,profiles:[],foods:[],reports:[]}
  }
  save(){this.state.schemaVersion=4;localStorage.setItem(this.key,JSON.stringify(this.state))}
  normalize(food){
    const english=String(food.englishName||food.title||food.name||'').trim();
    const bengali=String(food.bengaliName||food.name||'').trim();
    const nutrients=food.nutrients||{};
    return{
      id:food.id||this.uid(),title:english&&bengali?`${english} (${bengali})`:(english||bengali),
      englishName:english,bengaliName:bengali,name:bengali||english,category:food.category||'Other',
      serving:food.serving||'1 serving',servingWeight:this.num(food.servingWeight,100),
      energyKcal:this.num(food.energyKcal,String(food.energy||'').match(/[\d.]+/)?.[0]||0),
      ingredients:food.ingredients||'',notes:food.notes||'',custom:Boolean(food.custom),
      nutrients:Object.fromEntries(this.nutrientKeys.map(key=>[key,this.num(nutrients[key])]))
    }
  }
  migrate(){
    const bundled=new Map(this.defaultFoods.map(food=>[food.id,this.normalize({...food,custom:false})]));
    const custom=(this.state.foods||[]).map(food=>this.normalize(food)).filter(food=>food.custom||!bundled.has(food.id));
    this.state.foods=[...bundled.values(),...custom];
    this.save()
  }
  bind(){
    addEventListener('message',event=>{if(event.data?.type==='ait-pha-theme')this.applyTheme(event.data.theme)});
    this.q('addFood').onclick=()=>this.openEditor();
    this.q('refreshBundled').onclick=()=>this.refreshBundled();
    this.q('foodSearch').oninput=()=>this.render();
    this.q('foodCategory').onchange=()=>this.render();
    this.q('closeEditor').onclick=()=>this.closeEditor();
    this.q('cancelEditor').onclick=()=>this.closeEditor();
    this.q('foodForm').onsubmit=event=>{event.preventDefault();this.saveFood()};
    ['foodEnglishName','foodBengaliName'].forEach(id=>this.q(id).addEventListener('input',()=>this.syncTitle()));
    addEventListener('keydown',event=>{if(event.key==='Escape'&&!this.q('foodEditor').hidden)this.closeEditor()});
  }
  syncTitle(){
    const e=this.q('foodEnglishName').value.trim(),b=this.q('foodBengaliName').value.trim();
    this.q('foodTitle').value=e&&b?`${e} (${b})`:(e||b)
  }
  categories(){return[...new Set(this.state.foods.map(food=>food.category))].sort()}
  render(){
    this.q('foodCount').textContent=this.state.foods.length;
    const select=this.q('foodCategory'),old=select.value||'all';
    select.innerHTML='<option value="all">All categories</option>'+this.categories().map(c=>`<option value="${this.esc(c)}">${this.esc(c)}</option>`).join('');
    select.value=this.categories().includes(old)?old:'all';
    const term=this.q('foodSearch').value.toLowerCase(),category=select.value;
    const foods=this.state.foods.filter(food=>(category==='all'||food.category===category)&&`${food.title} ${food.englishName} ${food.bengaliName} ${food.category} ${food.serving}`.toLowerCase().includes(term));
    this.q('foodList').innerHTML=foods.map(food=>`<article class="hp-food-admin-row">
      <div class="hp-food-admin-icon">🍽</div>
      <div class="hp-food-identity"><span>${this.esc(food.category)}</span><h3>${this.esc(food.title)}</h3><dl><div><dt>English</dt><dd>${this.esc(food.englishName)}</dd></div><div><dt>বাংলা</dt><dd lang="bn">${this.esc(food.bengaliName)}</dd></div></dl></div>
      <div class="hp-food-serving"><b>${this.esc(food.serving)}</b><span>${this.round(food.servingWeight)} g</span><strong>${this.round(food.energyKcal)} kcal</strong></div>
      <div class="hp-food-nutrients">
        <span><b>Protein</b>${this.round(food.nutrients.protein)} g</span><span><b>Carbohydrate</b>${this.round(food.nutrients.carbohydrate)} g</span>
        <span><b>Fat</b>${this.round(food.nutrients.fat)} g</span><span><b>Fiber</b>${this.round(food.nutrients.fiber)} g</span>
        <span><b>Sodium</b>${this.round(food.nutrients.sodium)} mg</span><span><b>Calcium</b>${this.round(food.nutrients.calcium)} mg</span>
        <span><b>Iron</b>${this.round(food.nutrients.iron,2)} mg</span><span><b>Potassium</b>${this.round(food.nutrients.potassium)} mg</span>
      </div>
      <div class="hp-profile-actions"><button data-edit="${food.id}">Edit</button><button data-copy="${food.id}">Copy</button><button class="hp-danger" data-delete="${food.id}">Delete</button></div>
    </article>`).join('')||'<div class="hp-empty">No matching foods.</div>';
    this.q('foodList').querySelectorAll('[data-edit]').forEach(b=>b.onclick=()=>this.openEditor(b.dataset.edit));
    this.q('foodList').querySelectorAll('[data-copy]').forEach(b=>b.onclick=()=>this.copyFood(b.dataset.copy));
    this.q('foodList').querySelectorAll('[data-delete]').forEach(b=>b.onclick=()=>this.deleteFood(b.dataset.delete));
  }
  openEditor(id=null){
    this.editingId=id;
    const food=this.normalize(id?this.state.foods.find(item=>item.id===id)||{}:{});
    this.q('editorTitle').textContent=id?'Edit Food':'Add Food';
    this.q('foodId').value=id||'';
    this.q('foodEnglishName').value=food.englishName||'';
    this.q('foodBengaliName').value=food.bengaliName||'';
    this.q('foodCategoryInput').value=food.category==='Other'&&!id?'':food.category;
    this.q('foodServing').value=id?food.serving:'';
    this.q('foodServingWeight').value=id?food.servingWeight:'';
    this.q('foodEnergyKcal').value=id?food.energyKcal:'';
    this.q('foodIngredients').value=food.ingredients||'';
    this.q('foodNotes').value=food.notes||'';
    this.nutrientKeys.forEach(key=>{const idName=`food${key[0].toUpperCase()}${key.slice(1)}`;this.q(idName).value=id?food.nutrients[key]:0});
    this.syncTitle();
    this.q('foodEditor').hidden=false;this.q('foodEditor').setAttribute('aria-hidden','false');document.body.classList.add('hp-workspace-open')
  }
  closeEditor(){this.q('foodEditor').hidden=true;this.q('foodEditor').setAttribute('aria-hidden','true');document.body.classList.remove('hp-workspace-open')}
  saveFood(){
    const english=this.q('foodEnglishName').value.trim(),bengali=this.q('foodBengaliName').value.trim(),category=this.q('foodCategoryInput').value.trim(),serving=this.q('foodServing').value.trim();
    const weight=this.num(this.q('foodServingWeight').value),energy=this.num(this.q('foodEnergyKcal').value);
    if(!english||!bengali||!category||!serving||weight<=0){alert('English name, Bengali name, category, serving and serving weight are required.');return}
    const nutrients=Object.fromEntries(this.nutrientKeys.map(key=>[key,this.num(this.q(`food${key[0].toUpperCase()}${key.slice(1)}`).value)]));
    const record=this.normalize({id:this.editingId||this.uid(),englishName:english,bengaliName:bengali,category,serving,servingWeight:weight,energyKcal:energy,ingredients:this.q('foodIngredients').value.trim(),notes:this.q('foodNotes').value.trim(),nutrients,custom:true});
    const index=this.state.foods.findIndex(food=>food.id===record.id);
    if(index>=0)this.state.foods[index]=record;else this.state.foods.unshift(record);
    this.save();this.render();this.closeEditor();parent.postMessage({type:'ait-pha-food-data-updated'},'*')
  }
  copyFood(id){const source=this.state.foods.find(food=>food.id===id);if(!source)return;const copy=this.normalize({...JSON.parse(JSON.stringify(source)),id:this.uid(),englishName:`${source.englishName} Copy`,custom:true});this.state.foods.unshift(copy);this.save();this.render();parent.postMessage({type:'ait-pha-food-data-updated'},'*')}
  deleteFood(id){const food=this.state.foods.find(item=>item.id===id);if(!food||!confirm(`Delete “${food.title}”?`))return;this.state.foods=this.state.foods.filter(item=>item.id!==id);this.state.profiles.forEach(profile=>profile.data.selectedFoods=(profile.data.selectedFoods||[]).filter(foodId=>foodId!==id));this.save();this.render();parent.postMessage({type:'ait-pha-food-data-updated'},'*')}
  refreshBundled(){if(!confirm('Refresh bundled food values? Custom foods remain unchanged.'))return;const custom=this.state.foods.filter(food=>food.custom||!this.defaultFoods.some(item=>item.id===food.id));this.state.foods=[...this.defaultFoods.map(food=>this.normalize({...food,custom:false})),...custom];this.save();this.render();parent.postMessage({type:'ait-pha-food-data-updated'},'*')}
}
document.addEventListener('DOMContentLoaded',()=>new FoodDataWorkspace());
})();