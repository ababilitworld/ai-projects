export default class BakingBook {
  constructor({container, recipes}) { this.container = container; this.recipes = recipes; }
  render(items = this.recipes) {
    this.container.innerHTML = items.map((r,i)=>`<article class="aitb-recipe-card" id="${r.id}">
      <div class="aitb-recipe-card__head"><div><span class="aitb-badge">RECIPE ${String(i+1).padStart(2,'0')}</span><h3>${r.name}</h3><p class="aitb-muted">${r.category} · ${r.difficulty}</p></div><span class="aitb-badge">${r.temp}°C</span></div>
      <div class="aitb-recipe-meta"><div><small>Yield</small><strong>${r.yield}</strong></div><div><small>Prep</small><strong>${r.prep}</strong></div><div><small>Bake</small><strong>${r.bake}</strong></div><div><small>Rack</small><strong>${r.rack}</strong></div></div>
      <div class="aitb-oven-panel"><h4>MIYAKO 52L OVEN SETTINGS</h4><div class="aitb-oven-grid"><div><small>Preheat</small><br><strong>${r.preheat}</strong></div><div><small>Temperature</small><br><strong>${r.temp}°C</strong></div><div><small>Heating</small><br><strong>Top + Bottom</strong></div><div><small>Rack</small><br><strong>${r.rack}</strong></div><div><small>Time</small><br><strong>${r.bake}</strong></div></div></div>
      <div class="aitb-table-wrap"><table class="aitb-table"><thead><tr><th>Ingredient</th><th>Weight</th><th>Purpose</th></tr></thead><tbody>${r.ingredients.map(x=>`<tr><td>${x[0]}</td><td>${x[1]}</td><td>${x[2]}</td></tr>`).join('')}</tbody></table></div>
      <h4>প্রস্তুত প্রণালী</h4><ol class="aitb-steps">${r.steps.map(x=>`<li>${x}</li>`).join('')}</ol>
      <div class="aitb-quality"><strong>Professional Quality Target:</strong> ${r.quality}</div>
    </article>`).join('');
  }
}
