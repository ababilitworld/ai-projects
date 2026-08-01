(() => {
'use strict';

class HealthPlannerStore {
  constructor() { this.key = 'ait-pha-health-planner-v4'; this.legacyKeys = ['ait-pha-health-planner-v3']; }
  load() {
    for (const key of [this.key, ...this.legacyKeys]) {
      try {
        const data = JSON.parse(localStorage.getItem(key));
        if (data && Array.isArray(data.profiles) && Array.isArray(data.foods) && Array.isArray(data.reports)) {
          data.schemaVersion = Number(data.schemaVersion || 1);
          return data;
        }
      } catch (error) {}
    }
    return { schemaVersion: 4, profiles: [], foods: [], reports: [] };
  }
  save(state) { localStorage.setItem(this.key, JSON.stringify(state)); }
}

class HealthPlanner {
  constructor() {
    this.store = new HealthPlannerStore();
    this.state = this.store.load();
    this.defaultFoods = Array.isArray(window.AIT_BD_FOODS) ? window.AIT_BD_FOODS : [];
    this.profileFields = [
      'profileName','lifeStage','sex','age','height','activity','startDate','planWeeks','notes',
      'currentWeight','currentWaist','currentHip','currentNeck','currentFat','currentBmr',
      'targetBmi','targetWeight','targetWaist','targetBsr','targetFat','targetBmr',
      'walkMinutes','walkDays','breathMinutes','breathDays','sunMinutes','sunDays',
      'fastingHours','mealCount','eatingStart','reviewDay','dietStyle','avoidFoods'
    ];
    this.editingProfileId = null;
    this.editingFoodId = null;
    this.foodNutrientFields = ['Protein','Carbohydrate','Fat','Fiber','Sugar','Sodium','Calcium','Iron','Potassium','VitaminC','VitaminA','Cholesterol'];
    this.selectedFoods = new Set();
    this.initializeState();
    this.applyTheme(localStorage.getItem('heart-routine-theme') || 'dark-glass');
    this.bind();
    this.render();
    const params = new URLSearchParams(location.search);
    const requestedModule = params.get('module');
    const dataMode = params.get('data');
    if (requestedModule && ['profilesModule','reportsModule'].includes(requestedModule)) {
      this.openModule(requestedModule);
    }
    if (dataMode === 'food') {
      this.openFoodDataCenterView();
    }
  }

  q(id) { return document.getElementById(id); }
  uid(prefix='id') { return crypto?.randomUUID?.() || `${prefix}-${Date.now()}-${Math.random().toString(36).slice(2)}`; }
  escape(value) { const node = document.createElement('div'); node.textContent = String(value ?? ''); return node.innerHTML; }
  round(value, digits=1) { return Number(value).toFixed(digits); }
  persist() { this.store.save(this.state); }
  applyTheme(theme) {
    document.documentElement.dataset.theme = theme || 'dark-glass';
    document.documentElement.style.colorScheme = theme === 'classic-light' ? 'light' : 'dark';
  }

  initializeState() {
    this.state.schemaVersion = 4;
    const bundledById = new Map(this.defaultFoods.map(food => [food.id, this.normalizeFood({ ...food, custom: false })]));
    const customFoods = (this.state.foods || [])
      .map(food => this.normalizeFood(food))
      .filter(food => food.custom || !bundledById.has(food.id));
    this.state.foods = [...bundledById.values(), ...customFoods];
    if (!this.state.profiles.length) {
      this.state.profiles.push({
        id: this.uid('profile'),
        name: 'My Health Profile',
        createdAt: new Date().toISOString(),
        updatedAt: new Date().toISOString(),
        data: this.defaultProfile('My Health Profile')
      });
    }
    this.persist();
  }

  defaultProfile(name='New Profile') {
    return {
      profileName: name, lifeStage: 'adult', sex: 'male', age: 41, height: 174, activity: '1.375',
      startDate: new Date().toISOString().slice(0,10), planWeeks: 24, notes: '',
      currentWeight: 80, currentWaist: 95, currentHip: 100, currentNeck: 40, currentFat: 28, currentBmr: '',
      targetBmi: 23, targetWeight: '', targetWaist: 84, targetBsr: .483, targetFat: 20, targetBmr: '',
      cycle: 'daily', walkMinutes: 30, walkDays: 5, breathMinutes: 10, breathDays: 7,
      sunMinutes: 15, sunDays: 4, fastingHours: '12', mealCount: '3', eatingStart: '08:00',
      reviewDay: 'Sunday', dietStyle: 'balanced', avoidFoods: '',
      selectedFoods: ['rice-white','roti','dal','egg','chicken','rui','spinach','mixed-veg','salad','banana','guava','papaya','yogurt','nuts']
    };
  }

  number(value, fallback=0) {
    const parsed = Number(value);
    return Number.isFinite(parsed) ? parsed : fallback;
  }

  parseEnergy(value) {
    if (Number.isFinite(Number(value))) return Number(value);
    const match = String(value || '').match(/[\d.]+/);
    return match ? Number(match[0]) : 0;
  }

  normalizeFood(food) {
    const nutrient = food.nutrients || {};
    const bengaliName = food.bengaliName || food.name || '';
    const englishName = food.englishName || food.title || bengaliName;
    const energyKcal = this.number(food.energyKcal, this.parseEnergy(food.energy));
    return {
      id: food.id || this.uid('food'),
      title: `${englishName} (${bengaliName})`,
      englishName,
      bengaliName,
      name: bengaliName || englishName,
      category: food.category || 'Other',
      serving: food.serving || '1 serving',
      servingWeight: this.number(food.servingWeight, 100),
      energyKcal,
      energy: `${energyKcal} kcal`,
      ingredients: food.ingredients || '',
      nutrients: {
        protein: this.number(nutrient.protein),
        carbohydrate: this.number(nutrient.carbohydrate),
        fat: this.number(nutrient.fat),
        fiber: this.number(nutrient.fiber),
        sugar: this.number(nutrient.sugar),
        sodium: this.number(nutrient.sodium),
        calcium: this.number(nutrient.calcium),
        iron: this.number(nutrient.iron),
        potassium: this.number(nutrient.potassium),
        vitaminC: this.number(nutrient.vitaminC),
        vitaminA: this.number(nutrient.vitaminA),
        cholesterol: this.number(nutrient.cholesterol)
      },
      notes: food.notes || '',
      custom: Boolean(food.custom)
    };
  }

  foodDisplayName(food) {
    const english = String(food.englishName || '').trim();
    const bengali = String(food.bengaliName || food.name || '').trim();
    return english && bengali ? `${english} (${bengali})` : (english || bengali || 'Unnamed food');
  }

  bind() {
    addEventListener('message', event => {
      if (event.data?.type === 'ait-pha-theme') this.applyTheme(event.data.theme);
      if (event.data?.type === 'ait-pha-refresh-food-data') {
        this.state = this.store.load();
        this.initializeState();
        this.renderProfileFoodFilters();
        this.renderProfileFoods();
      }
    });

    document.querySelectorAll('[data-module]').forEach(button => button.addEventListener('click', () => this.openModule(button.dataset.module)));
    document.querySelectorAll('[data-form-step]').forEach(button => button.addEventListener('click', () => this.openFormStep(button.dataset.formStep)));

    this.q('createProfile')?.addEventListener('click', () => this.openProfileWorkspace());
    this.q('closeProfileWorkspace')?.addEventListener('click', () => this.closeWorkspace('profileWorkspace'));
    this.q('cancelProfile')?.addEventListener('click', () => this.closeWorkspace('profileWorkspace'));
    this.q('profileForm')?.addEventListener('submit', event => { event.preventDefault(); this.saveProfile(false); });
    this.q('saveAndGenerate')?.addEventListener('click', () => this.saveProfile(true));

    this.q('profileFoodSearch')?.addEventListener('input', () => this.renderProfileFoods());
    this.q('profileFoodCategory')?.addEventListener('change', () => this.renderProfileFoods());
    this.q('profileFoodSelectionFilter')?.addEventListener('change', () => this.renderProfileFoods());
    this.q('clearProfileFoodSearch')?.addEventListener('click', () => {
      const input = this.q('profileFoodSearch');
      if (!input) return;
      input.value = '';
      this.renderProfileFoods();
      input.focus();
    });
    this.q('selectVisibleFoods')?.addEventListener('click', () => {
      this.getVisibleProfileFoods().forEach(food => this.selectedFoods.add(food.id));
      this.renderProfileFoods();
    });
    this.q('clearVisibleFoods')?.addEventListener('click', () => {
      this.getVisibleProfileFoods().forEach(food => this.selectedFoods.delete(food.id));
      this.renderProfileFoods();
    });
    this.q('addFoodFromProfile')?.addEventListener('click', event => {
      event.preventDefault();
      parent.postMessage({ type: 'ait-pha-open-data-center-food', mode: 'create' }, '*');
    });

    this.q('refreshReports')?.addEventListener('click', () => this.renderReports());
    this.q('closeReportWorkspace')?.addEventListener('click', () => this.closeWorkspace('reportWorkspace'));

    document.addEventListener('keydown', event => {
      if (event.key !== 'Escape') return;
      ['reportWorkspace','profileWorkspace'].forEach(id => {
        const workspace = this.q(id);
        if (workspace && !workspace.hidden) this.closeWorkspace(id);
      });
    });
  }

  openModule(id) {
    document.querySelectorAll('[data-module]').forEach(button => button.classList.toggle('is-active', button.dataset.module === id));
    document.querySelectorAll('.hp-module').forEach(module => module.classList.toggle('is-active', module.id === id));
    if (id === 'reportsModule') this.renderReports();
  }

  openFormStep(id) {
    document.querySelectorAll('[data-form-step]').forEach(button => button.classList.toggle('is-active', button.dataset.formStep === id));
    document.querySelectorAll('.hp-form-step').forEach(step => step.classList.toggle('is-active', step.id === id));
  }

  openWorkspace(id) {
    const workspace = this.q(id);
    workspace.hidden = false;
    workspace.setAttribute('aria-hidden','false');
    document.body.classList.add('hp-workspace-open');
  }

  closeWorkspace(id) {
    const workspace = this.q(id);
    workspace.hidden = true;
    workspace.setAttribute('aria-hidden','true');
    if (![...document.querySelectorAll('.hp-workspace')].some(item => !item.hidden)) document.body.classList.remove('hp-workspace-open');
  }

  openFoodDataCenterView() {
    document.querySelectorAll('[data-module]').forEach(button => button.classList.remove('is-active'));
    document.querySelectorAll('.hp-module').forEach(module => module.classList.remove('is-active'));

    let container = document.getElementById('foodDataCenterStandalone');
    if (!container) {
      container = document.createElement('section');
      container.id = 'foodDataCenterStandalone';
      container.className = 'hp-module is-active';
      container.innerHTML = `
        <div class="hp-module-head">
          <div><span class="calc-kicker">DATA CENTER / DATA / FOOD</span><h2>Bangladeshi Food Catalogue</h2><p>Manage shared food nutrition data used by profiles and balanced-diet reports.</p></div>
          <div class="hp-head-actions">
            <button class="calc-button" id="returnToPlannerProfiles" type="button">← AIT Planner Profiles</button>
            <button class="calc-button" id="refreshBundledFoodsStandalone" type="button">↻ Refresh Bundled Values</button>
            <button class="calc-button calc-button--primary" id="createFoodStandalone" type="button">＋ Add Food</button>
          </div>
        </div>
        <div class="hp-food-admin-toolbar"><input id="adminFoodSearchStandalone" type="search" placeholder="Search title, English/Bengali name, category or serving"><select id="adminFoodCategoryStandalone"><option value="all">All categories</option></select></div>
        <div class="hp-food-table-head" aria-hidden="true"><span>Food identity</span><span>Serving & energy</span><span>Nutrition per serving</span><span>Actions</span></div>
        <div class="hp-food-admin-list" id="foodAdminListStandalone"></div>`;
      document.querySelector('.calc-shell').appendChild(container);
      document.getElementById('returnToPlannerProfiles').addEventListener('click', () => { location.href = 'index.html?module=profilesModule'; });
      document.getElementById('refreshBundledFoodsStandalone').addEventListener('click', () => this.refreshBundledFoods());
      document.getElementById('createFoodStandalone').addEventListener('click', () => this.openFoodWorkspace());
      document.getElementById('adminFoodSearchStandalone').addEventListener('input', () => this.renderStandaloneFoods());
      document.getElementById('adminFoodCategoryStandalone').addEventListener('change', () => this.renderStandaloneFoods());
    }
    container.classList.add('is-active');
    this.renderStandaloneFoods();
  }

  renderStandaloneFoods() {
    const categorySelect = document.getElementById('adminFoodCategoryStandalone');
    const searchInput = document.getElementById('adminFoodSearchStandalone');
    const list = document.getElementById('foodAdminListStandalone');
    if (!categorySelect || !searchInput || !list) return;
    const categories = [...new Set(this.state.foods.map(food => food.category))].sort();
    const currentCategory = categorySelect.value || 'all';
    categorySelect.innerHTML = '<option value="all">All categories</option>' + categories.map(category => `<option value="${this.escape(category)}">${this.escape(category)}</option>`).join('');
    categorySelect.value = categories.includes(currentCategory) ? currentCategory : 'all';
    const term = searchInput.value.toLowerCase();
    const category = categorySelect.value;
    const foods = this.state.foods.filter(food => (category === 'all' || food.category === category) && `${food.title} ${food.englishName} ${food.bengaliName} ${food.category} ${food.serving}`.toLowerCase().includes(term));
    list.innerHTML = foods.length ? foods.map(food => `<article class="hp-food-admin-row">
      <div class="hp-food-admin-icon">🍽</div>
      <div class="hp-food-identity"><span>${this.escape(food.category)}</span><h3>${this.escape(this.foodDisplayName(food))}</h3><dl><div><dt>English</dt><dd>${this.escape(food.englishName)}</dd></div><div><dt>বাংলা</dt><dd lang="bn">${this.escape(food.bengaliName)}</dd></div></dl></div>
      <div class="hp-food-serving"><b>${this.escape(food.serving)}</b><span>${this.round(food.servingWeight)} g</span><strong>${this.round(food.energyKcal)} kcal</strong></div>
      <div class="hp-food-nutrients"><span><b>Protein</b>${this.round(food.nutrients.protein)} g</span><span><b>Carbohydrate</b>${this.round(food.nutrients.carbohydrate)} g</span><span><b>Fat</b>${this.round(food.nutrients.fat)} g</span><span><b>Fiber</b>${this.round(food.nutrients.fiber)} g</span><span><b>Sodium</b>${this.round(food.nutrients.sodium)} mg</span><span><b>Calcium</b>${this.round(food.nutrients.calcium)} mg</span><span><b>Iron</b>${this.round(food.nutrients.iron,2)} mg</span><span><b>Potassium</b>${this.round(food.nutrients.potassium)} mg</span></div>
      <div class="hp-profile-actions"><button data-food-edit="${food.id}">Edit</button><button data-food-copy="${food.id}">Copy</button><button data-food-delete="${food.id}" class="hp-danger">Delete</button></div>
    </article>`).join('') : '<div class="hp-empty">No matching foods.</div>';
    list.querySelectorAll('[data-food-edit]').forEach(button => button.addEventListener('click', () => this.openFoodWorkspace(button.dataset.foodEdit)));
    list.querySelectorAll('[data-food-copy]').forEach(button => button.addEventListener('click', () => { this.copyFood(button.dataset.foodCopy); this.renderStandaloneFoods(); }));
    list.querySelectorAll('[data-food-delete]').forEach(button => button.addEventListener('click', () => { this.deleteFood(button.dataset.foodDelete); this.renderStandaloneFoods(); }));
  }

  render() {
    if (this.q('heroBadge')) this.q('heroBadge').textContent = this.state.profiles.length;
    this.renderProfiles();
    this.renderReports();
  }

  renderProfiles() {
    const list = this.q('profileList');
    if (!list) return;
    list.innerHTML = this.state.profiles.map(profile => {
      const d = profile.data;
      const latest = this.state.reports.find(report => report.profileId === profile.id);
      return `<article class="hp-profile-row">
        <div class="hp-profile-avatar">${this.escape(profile.name.slice(0,1).toUpperCase())}</div>
        <div class="hp-profile-info">
          <span>${this.escape(d.lifeStage)} · ${this.escape(d.sex)}</span>
          <h3>${this.escape(profile.name)}</h3>
          <p>${this.escape(d.age || '—')} years · ${this.escape(d.height || '—')} cm · ${this.escape(d.currentWeight || '—')} kg</p>
          <small>${latest ? `Latest plan: ${new Date(latest.generatedAt).toLocaleString()}` : 'No generated plan yet'}</small>
        </div>
        <div class="hp-profile-actions">
          <button data-profile-edit="${profile.id}">Edit</button>
          <button data-profile-copy="${profile.id}">Copy</button>
          <button data-profile-generate="${profile.id}" class="is-primary">Generate Plan</button>
          <button data-profile-delete="${profile.id}" class="hp-danger">Delete</button>
        </div>
      </article>`;
    }).join('');

    list.querySelectorAll('[data-profile-edit]').forEach(button => button.addEventListener('click', () => this.openProfileWorkspace(button.dataset.profileEdit)));
    list.querySelectorAll('[data-profile-copy]').forEach(button => button.addEventListener('click', () => this.copyProfile(button.dataset.profileCopy)));
    list.querySelectorAll('[data-profile-generate]').forEach(button => button.addEventListener('click', () => this.generateFromSavedProfile(button.dataset.profileGenerate)));
    list.querySelectorAll('[data-profile-delete]').forEach(button => button.addEventListener('click', () => this.deleteProfile(button.dataset.profileDelete)));
  }

  openProfileWorkspace(profileId=null) {
    this.editingProfileId = profileId;
    const data = profileId
      ? JSON.parse(JSON.stringify(this.state.profiles.find(profile => profile.id === profileId)?.data || this.defaultProfile()))
      : this.defaultProfile(`Profile ${this.state.profiles.length + 1}`);

    this.q('profileWorkspaceTitle').textContent = profileId ? 'Edit Profile' : 'Create Profile';
    this.q('profileId').value = profileId || '';
    this.profileFields.forEach(id => { const element = this.q(id); if (element) element.value = data[id] ?? ''; });
    document.querySelectorAll('[name="cycle"]').forEach(radio => radio.checked = radio.value === (data.cycle || 'daily'));
    this.selectedFoods = new Set(data.selectedFoods || []);
    this.renderProfileFoodFilters();
    this.renderProfileFoods();
    this.openFormStep('identityStep');
    this.openWorkspace('profileWorkspace');
  }

  collectProfile() {
    const data = {};
    this.profileFields.forEach(id => { const element = this.q(id); if (element) data[id] = element.value; });
    data.cycle = document.querySelector('[name="cycle"]:checked')?.value || 'daily';
    data.selectedFoods = [...this.selectedFoods];
    return data;
  }

  validateProfile(data) {
    if (!data.profileName.trim()) return 'Profile name is required.';
    if (Number(data.height) <= 0 || Number(data.currentWeight) <= 0) return 'Height and current weight are required.';
    if (Number(data.planWeeks) < 4) return 'Planning horizon must be at least 4 weeks.';
    return '';
  }

  saveProfile(generate) {
    const data = this.collectProfile();
    const error = this.validateProfile(data);
    if (error) { alert(error); return; }

    let profile;
    if (this.editingProfileId) {
      profile = this.state.profiles.find(item => item.id === this.editingProfileId);
      profile.data = data;
      profile.name = data.profileName.trim();
      profile.updatedAt = new Date().toISOString();
    } else {
      profile = {
        id: this.uid('profile'),
        name: data.profileName.trim(),
        createdAt: new Date().toISOString(),
        updatedAt: new Date().toISOString(),
        data
      };
      this.state.profiles.unshift(profile);
      this.editingProfileId = profile.id;
    }

    if (generate) this.createReport(profile);
    this.persist();
    this.render();
    this.closeWorkspace('profileWorkspace');

    if (generate) {
      this.openModule('reportsModule');
      const report = this.state.reports.find(item => item.profileId === profile.id);
      if (report) this.openReport(report.id);
    }
  }

  copyProfile(id) {
    const source = this.state.profiles.find(profile => profile.id === id);
    if (!source) return;
    const copy = {
      id: this.uid('profile'),
      name: `${source.name} Copy`,
      createdAt: new Date().toISOString(),
      updatedAt: new Date().toISOString(),
      data: JSON.parse(JSON.stringify(source.data))
    };
    copy.data.profileName = copy.name;
    this.state.profiles.unshift(copy);
    this.persist();
    this.renderProfiles();
  }

  deleteProfile(id) {
    const profile = this.state.profiles.find(item => item.id === id);
    if (!profile || !confirm(`Delete profile “${profile.name}” and its reports?`)) return;
    this.state.profiles = this.state.profiles.filter(item => item.id !== id);
    this.state.reports = this.state.reports.filter(report => report.profileId !== id);
    this.persist();
    this.render();
  }

  generateFromSavedProfile(id) {
    const profile = this.state.profiles.find(item => item.id === id);
    if (!profile) return;
    const error = this.validateProfile(profile.data);
    if (error) { alert(error); return; }
    const report = this.createReport(profile);
    this.persist();
    this.render();
    this.openModule('reportsModule');
    this.openReport(report.id);
  }

  renderFoodFilters() {
    const select = this.q('adminFoodCategory');
    if (!select) return;
    const categories = [...new Set(this.state.foods.map(food => food.category))].sort();
    const options = '<option value="all">All categories</option>' + categories.map(category => `<option value="${this.escape(category)}">${this.escape(category)}</option>`).join('');
    select.innerHTML = options;
  }

  renderProfileFoodFilters() {
    const categories = [...new Set(this.state.foods.map(food => food.category))].sort();
    this.q('profileFoodCategory').innerHTML = '<option value="all">All categories</option>' + categories.map(category => `<option value="${this.escape(category)}">${this.escape(category)}</option>`).join('');
  }

  refreshBundledFoods() {
    if (!confirm('Refresh all bundled foods with the latest English/Bengali names and nutrition values? Custom foods will remain unchanged.')) return;
    const customFoods = this.state.foods.filter(food => food.custom || !this.defaultFoods.some(item => item.id === food.id));
    this.state.foods = [
      ...this.defaultFoods.map(food => this.normalizeFood({ ...food, custom: false })),
      ...customFoods.map(food => this.normalizeFood(food))
    ];
    this.state.schemaVersion = 4;
    this.persist();
    this.renderFoodFilters();
    this.renderFoods();
    alert('Bundled food names and values were refreshed.');
  }

  renderFoods() {
    const list = this.q('foodAdminList');
    const search = this.q('adminFoodSearch');
    const categorySelect = this.q('adminFoodCategory');
    if (!list || !search || !categorySelect) return;
    this.renderFoodFilters();
    const term = (search.value || '').toLowerCase();
    const category = categorySelect.value || 'all';
    const foods = this.state.foods.filter(food =>
      (category === 'all' || food.category === category) &&
      `${food.title} ${food.englishName} ${food.bengaliName} ${food.category} ${food.serving} ${food.energyKcal}`.toLowerCase().includes(term)
    );

    list.innerHTML = foods.length ? foods.map(food => `<article class="hp-food-admin-row">
      <div class="hp-food-admin-icon">🍽</div>
      <div class="hp-food-identity">
        <span>${this.escape(food.category)}</span>
        <h3>${this.escape(this.foodDisplayName(food))}</h3>
        <dl>
          <div><dt>English</dt><dd>${this.escape(food.englishName)}</dd></div>
          <div><dt>বাংলা</dt><dd lang="bn">${this.escape(food.bengaliName)}</dd></div>
        </dl>
      </div>
      <div class="hp-food-serving">
        <b>${this.escape(food.serving)}</b>
        <span>${this.round(food.servingWeight)} g</span>
        <strong>${this.round(food.energyKcal)} kcal</strong>
      </div>
      <div class="hp-food-nutrients">
        <span><b>Protein</b>${this.round(food.nutrients.protein)} g</span>
        <span><b>Carbohydrate</b>${this.round(food.nutrients.carbohydrate)} g</span>
        <span><b>Fat</b>${this.round(food.nutrients.fat)} g</span>
        <span><b>Fiber</b>${this.round(food.nutrients.fiber)} g</span>
        <span><b>Sodium</b>${this.round(food.nutrients.sodium)} mg</span>
        <span><b>Calcium</b>${this.round(food.nutrients.calcium)} mg</span>
        <span><b>Iron</b>${this.round(food.nutrients.iron,2)} mg</span>
        <span><b>Potassium</b>${this.round(food.nutrients.potassium)} mg</span>
      </div>
      <div class="hp-profile-actions">
        <button data-food-edit="${food.id}">Edit</button>
        <button data-food-copy="${food.id}">Copy</button>
        <button data-food-delete="${food.id}" class="hp-danger">Delete</button>
      </div>
    </article>`).join('') : '<div class="hp-empty">No matching foods.</div>';

    list.querySelectorAll('[data-food-edit]').forEach(button => button.addEventListener('click', () => this.openFoodWorkspace(button.dataset.foodEdit)));
    list.querySelectorAll('[data-food-copy]').forEach(button => button.addEventListener('click', () => this.copyFood(button.dataset.foodCopy)));
    list.querySelectorAll('[data-food-delete]').forEach(button => button.addEventListener('click', () => this.deleteFood(button.dataset.foodDelete)));
  }

  syncFoodTitle() {
    const english = this.q('foodEnglishName').value.trim();
    const bengali = this.q('foodBengaliName').value.trim();
    this.q('foodTitle').value = english && bengali
      ? `${english} (${bengali})`
      : (english || bengali || '');
  }

  openFoodWorkspace(foodId=null) {
    this.editingFoodId = foodId;
    const food = this.normalizeFood(foodId ? this.state.foods.find(item => item.id === foodId) : {
      title:'', englishName:'', bengaliName:'', category:'', serving:'', servingWeight:100,
      energyKcal:0, ingredients:'', nutrients:{}, notes:''
    });
    this.q('foodWorkspaceTitle').textContent = foodId ? 'Edit Food Nutrition' : 'Add Food Nutrition';
    this.q('foodId').value = foodId || '';
    this.q('foodTitle').value = this.foodDisplayName(food);
    this.q('foodEnglishName').value = food.englishName || '';
    this.q('foodBengaliName').value = food.bengaliName || '';
    this.q('foodCategoryInput').value = food.category || '';
    this.q('foodServing').value = food.serving || '';
    this.q('foodServingWeight').value = food.servingWeight || '';
    this.q('foodEnergyKcal').value = food.energyKcal || '';
    this.q('foodIngredients').value = food.ingredients || '';
    this.q('foodNotes').value = food.notes || '';
    this.syncFoodTitle();
    this.foodNutrientFields.forEach(name => {
      const key = name.charAt(0).toLowerCase() + name.slice(1);
      const element = this.q(`food${name}`);
      if (element) element.value = food.nutrients[key] || 0;
    });
    this.openWorkspace('foodWorkspace');
  }

  saveFood() {
    const englishName = this.q('foodEnglishName').value.trim();
    const bengaliName = this.q('foodBengaliName').value.trim();
    const title = englishName && bengaliName ? `${englishName} (${bengaliName})` : (englishName || bengaliName);
    const category = this.q('foodCategoryInput').value.trim();
    const serving = this.q('foodServing').value.trim();
    const servingWeight = this.number(this.q('foodServingWeight').value);
    const energyKcal = this.number(this.q('foodEnergyKcal').value);
    const ingredients = this.q('foodIngredients').value.trim();
    const notes = this.q('foodNotes').value.trim();
    const nutrients = {};
    this.foodNutrientFields.forEach(name => {
      const key = name.charAt(0).toLowerCase() + name.slice(1);
      nutrients[key] = this.number(this.q(`food${name}`).value);
    });

    if (!englishName || !bengaliName || !category || !serving || servingWeight <= 0) {
      alert('Title, English name, Bengali name, category, serving and serving weight are required.');
      return;
    }

    const record = this.normalizeFood({
      id: this.editingFoodId || this.uid('food'),
      title, englishName, bengaliName, name: bengaliName, category, serving,
      servingWeight, energyKcal, energy: `${energyKcal} kcal`, ingredients,
      nutrients, notes, custom: true
    });

    if (this.editingFoodId) {
      const index = this.state.foods.findIndex(item => item.id === this.editingFoodId);
      this.state.foods[index] = record;
    } else {
      this.state.foods.unshift(record);
    }
    this.persist();
    this.renderFoods();
    this.renderStandaloneFoods();
    this.closeWorkspace('foodWorkspace');
  }

  copyFood(id) {
    const source = this.state.foods.find(food => food.id === id);
    if (!source) return;
    this.state.foods.unshift({ ...JSON.parse(JSON.stringify(source)), id: this.uid('food'), englishName: `${source.englishName} Copy`, title: `${source.englishName} Copy (${source.bengaliName})`, custom: true });
    this.persist();
    this.renderFoods();
  }

  deleteFood(id) {
    const food = this.state.foods.find(item => item.id === id);
    if (!food || !confirm(`Delete food “${this.foodDisplayName(food)}”?`)) return;
    this.state.foods = this.state.foods.filter(item => item.id !== id);
    this.state.profiles.forEach(profile => {
      profile.data.selectedFoods = (profile.data.selectedFoods || []).filter(foodId => foodId !== id);
    });
    this.persist();
    this.renderFoods();
  }

  getVisibleProfileFoods() {
    const term = (this.q('profileFoodSearch')?.value || '').trim().toLowerCase();
    const category = this.q('profileFoodCategory')?.value || 'all';
    const filter = this.q('profileFoodSelectionFilter')?.value || 'all';
    return this.state.foods.filter(food => {
      const selected = this.selectedFoods.has(food.id);
      const haystack = `${food.title} ${food.englishName} ${food.bengaliName} ${food.category} ${food.serving}`.toLowerCase();
      return (category === 'all' || food.category === category)
        && (!term || haystack.includes(term))
        && (filter === 'all' || (filter === 'selected' && selected) || (filter === 'unselected' && !selected));
    });
  }

  renderProfileFoods() {
    const list = this.q('profileFoodList');
    if (!list) return;
    const foods = this.getVisibleProfileFoods();
    const visibleCount = this.q('availableFoodVisibleCount');
    const selectedCount = this.q('availableFoodSelectedCount');
    const clearButton = this.q('clearProfileFoodSearch');
    if (visibleCount) visibleCount.textContent = String(foods.length);
    if (selectedCount) selectedCount.textContent = String(this.selectedFoods.size);
    if (clearButton) clearButton.hidden = !(this.q('profileFoodSearch')?.value);

    if (!foods.length) {
      list.innerHTML = `<div class="hp-af2-empty"><span>🥗</span><h3>No foods found</h3><p>Change the filters or add a new food to the shared catalogue.</p><button data-af2-add type="button">＋ Add Food</button></div>`;
      list.querySelector('[data-af2-add]')?.addEventListener('click', () => parent.postMessage({type:'ait-pha-open-data-center-food',mode:'create'}, '*'));
      return;
    }

    list.innerHTML = foods.map(food => {
      const selected = this.selectedFoods.has(food.id);
      const n = food.nutrients || {};
      return `<article class="hp-af2-card${selected ? ' is-selected' : ''}" data-food-id="${food.id}">
        <label class="hp-af2-card__select" title="${selected ? 'Remove from profile' : 'Add to profile'}">
          <input type="checkbox" value="${food.id}" ${selected ? 'checked' : ''}>
          <span>✓</span>
        </label>
        <div class="hp-af2-card__main">
          <div class="hp-af2-card__top"><span>${this.escape(food.category)}</span><button data-edit-food="${food.id}" type="button" title="Edit in Data Center" aria-label="Edit ${this.escape(food.englishName)}">✎</button></div>
          <h3>${this.escape(this.foodDisplayName(food))}</h3>
          <div class="hp-af2-card__serving"><span>${this.escape(food.serving)}</span><span>${this.round(food.servingWeight)} g</span><strong>${this.round(food.energyKcal)} kcal</strong></div>
          <div class="hp-af2-card__macros"><span><b>Protein</b>${this.round(n.protein)} g</span><span><b>Carbs</b>${this.round(n.carbohydrate)} g</span><span><b>Fat</b>${this.round(n.fat)} g</span><span><b>Fiber</b>${this.round(n.fiber)} g</span></div>
        </div>
      </article>`;
    }).join('');

    list.querySelectorAll('input[type="checkbox"]').forEach(input => input.addEventListener('change', () => {
      input.checked ? this.selectedFoods.add(input.value) : this.selectedFoods.delete(input.value);
      this.renderProfileFoods();
    }));
    list.querySelectorAll('[data-edit-food]').forEach(button => button.addEventListener('click', event => {
      event.preventDefault();
      event.stopPropagation();
      parent.postMessage({type:'ait-pha-open-data-center-food',foodId:button.dataset.editFood}, '*');
    }));
  }

  createReport(profile) {
    const plan = this.generatePlan(profile.data);
    const report = {
      id: this.uid('report'),
      profileId: profile.id,
      profileName: profile.name,
      generatedAt: new Date().toISOString(),
      plan
    };
    this.state.reports.unshift(report);
    return report;
  }

  bmi(weight, height) { return weight / ((height / 100) ** 2); }
  bmr(data, weight) {
    const age = Number(data.age), height = Number(data.height);
    if (['baby','child','teen'].includes(data.lifeStage)) return 22.5 * weight + 499;
    return 10 * weight + 6.25 * height - 5 * age + (data.sex === 'female' ? -161 : 5);
  }

  generatePlan(data) {
    const height = Number(data.height), currentWeight = Number(data.currentWeight), weeks = Number(data.planWeeks);
    const targetBmi = Number(data.targetBmi) || this.bmi(currentWeight, height);
    const targetWeight = Number(data.targetWeight) || targetBmi * ((height / 100) ** 2);
    const currentWaist = Number(data.currentWaist) || 0;
    const targetWaist = Number(data.targetWaist) || Number(data.targetBsr) * height || currentWaist;
    const currentFat = Number(data.currentFat) || 0, targetFat = Number(data.targetFat) || currentFat;
    const currentBmr = Number(data.currentBmr) || this.bmr(data, currentWeight);
    const targetBmr = Number(data.targetBmr) || this.bmr(data, targetWeight);
    const selectedFoods = this.state.foods.filter(food => (data.selectedFoods || []).includes(food.id));
    const milestones = [];
    for (let week = 0; week <= weeks; week += 4) {
      milestones.push(this.milestone(week, week / weeks, data, { height,currentWeight,targetWeight,currentWaist,targetWaist,currentFat,targetFat,currentBmr,targetBmr,selectedFoods }));
    }
    if (milestones.at(-1)?.week !== weeks) milestones.push(this.milestone(weeks, 1, data, { height,currentWeight,targetWeight,currentWaist,targetWaist,currentFat,targetFat,currentBmr,targetBmr,selectedFoods }));
    const nutritionTargets = this.calculateNutritionTargets(data, currentWeight, targetWeight, currentBmr);
    const balancedDiet = this.buildBalancedDiet(data, selectedFoods, nutritionTargets);
    return {
      cycle: data.cycle, weeks,
      current: { weight: currentWeight, bmi: this.bmi(currentWeight,height), bmr: currentBmr, bsr: currentWaist/height, fat: currentFat },
      target: { weight: targetWeight, bmi: this.bmi(targetWeight,height), bmr: targetBmr, bsr: targetWaist/height, fat: targetFat },
      nutritionTargets, balancedDiet,
      milestones, daily: this.dailyTemplate(data, selectedFoods, balancedDiet)
    };
  }

  calculateNutritionTargets(data, currentWeight, targetWeight, currentBmr) {
    const activity = this.number(data.activity, 1.375);
    const tdee = currentBmr * activity;
    const difference = targetWeight - currentWeight;
    const adjustment = Math.max(-600, Math.min(400, difference * 35));
    const calories = Math.max(['baby','child','teen'].includes(data.lifeStage) ? 1000 : 1200, tdee + adjustment);
    let proteinPerKg = data.dietStyle === 'higher-protein' ? 1.6 : 1.2;
    if (['baby','child','teen','older'].includes(data.lifeStage)) proteinPerKg = 1.25;
    const protein = Math.max(35, targetWeight * proteinPerKg);
    const fat = Math.max(35, calories * 0.27 / 9);
    const carbohydrate = Math.max(100, (calories - protein * 4 - fat * 9) / 4);
    const fiber = data.sex === 'female' ? 25 : 30;
    return {
      calories: Math.round(calories), protein: Math.round(protein),
      carbohydrate: Math.round(carbohydrate), fat: Math.round(fat),
      fiber, sodium: 2300, calcium: 1000, iron: data.sex === 'female' && Number(data.age) < 51 ? 18 : 8
    };
  }

  nutrientTotals(items) {
    return items.reduce((totals, item) => {
      const servings = this.number(item.servings, 1);
      totals.calories += item.food.energyKcal * servings;
      Object.keys(totals.nutrients).forEach(key => {
        totals.nutrients[key] += this.number(item.food.nutrients[key]) * servings;
      });
      return totals;
    }, {
      calories: 0,
      nutrients: { protein:0, carbohydrate:0, fat:0, fiber:0, sugar:0, sodium:0, calcium:0, iron:0, potassium:0, vitaminC:0, vitaminA:0, cholesterol:0 }
    });
  }

  buildBalancedDiet(data, foods, targets) {
    const meals = Math.max(2, this.number(data.mealCount, 3));
    const groups = {
      protein: foods.filter(food => ['Protein','Protein/Fiber','Protein/Fat','Protein/Mineral','Dairy'].includes(food.category)),
      carbohydrate: foods.filter(food => ['Carbohydrate','Mixed meal'].includes(food.category)),
      vegetable: foods.filter(food => food.category === 'Vegetable'),
      fruit: foods.filter(food => food.category === 'Fruit'),
      fat: foods.filter(food => ['Healthy fat','Fat'].includes(food.category)),
      drink: foods.filter(food => food.category === 'Drink')
    };
    const all = foods.length ? foods : this.state.foods;
    Object.keys(groups).forEach(key => { if (!groups[key].length) groups[key] = all; });

    const portions = [];
    const pick = (group, index) => group[index % group.length];
    for (let index = 0; index < meals; index++) {
      const items = [];
      const add = (food, servings=1) => {
        if (food && !items.some(item => item.food.id === food.id)) items.push({ food, servings });
      };
      if (index === 0) {
        add(pick(groups.carbohydrate,index), .75);
        add(pick(groups.protein,index), 1);
        add(pick(groups.fruit,index), 1);
        add(pick(groups.drink,index), 1);
      } else {
        add(pick(groups.carbohydrate,index), index === meals-1 ? .6 : .8);
        add(pick(groups.protein,index), 1);
        add(pick(groups.vegetable,index), 1);
        if (index < 2) add(pick(groups.fruit,index), .5);
        if (index === meals-1) add(pick(groups.fat,index), .4);
      }
      portions.push({ label: `Meal ${index + 1}`, items });
    }

    // Scale all selected portions toward the daily calorie target.
    let flat = portions.flatMap(meal => meal.items);
    let totals = this.nutrientTotals(flat);
    const scale = totals.calories > 0 ? Math.max(.5, Math.min(2.2, targets.calories / totals.calories)) : 1;
    portions.forEach(meal => meal.items.forEach(item => item.servings = Math.round(item.servings * scale * 4) / 4));
    flat = portions.flatMap(meal => meal.items);
    totals = this.nutrientTotals(flat);

    return {
      meals: portions.map(meal => ({
        label: meal.label,
        foods: meal.items.map(item => ({
          id: item.food.id,
          title: this.foodDisplayName(item.food),
          serving: item.food.serving,
          servingWeight: item.food.servingWeight,
          servings: item.servings,
          calories: item.food.energyKcal * item.servings,
          nutrients: Object.fromEntries(Object.entries(item.food.nutrients).map(([key,value]) => [key, this.number(value) * item.servings]))
        }))
      })),
      totals,
      targets,
      coverage: {
        calories: targets.calories ? totals.calories / targets.calories : 0,
        protein: targets.protein ? totals.nutrients.protein / targets.protein : 0,
        carbohydrate: targets.carbohydrate ? totals.nutrients.carbohydrate / targets.carbohydrate : 0,
        fat: targets.fat ? totals.nutrients.fat / targets.fat : 0,
        fiber: targets.fiber ? totals.nutrients.fiber / targets.fiber : 0
      }
    };
  }

  milestone(week, ratio, data, values) {
    const lerp = (a,b) => a + (b-a) * ratio;
    const weight = lerp(values.currentWeight, values.targetWeight);
    return {
      week, weight, bmi: this.bmi(weight, values.height),
      waist: lerp(values.currentWaist, values.targetWaist),
      bsr: lerp(values.currentWaist, values.targetWaist) / values.height,
      fat: lerp(values.currentFat, values.targetFat),
      bmr: lerp(values.currentBmr, values.targetBmr),
      walk: Math.round(Number(data.walkMinutes) * (.75 + .25 * ratio)),
      walkDays: Number(data.walkDays), breath: Number(data.breathMinutes), breathDays: Number(data.breathDays),
      sun: Number(data.sunMinutes), sunDays: Number(data.sunDays), fast: Number(data.fastingHours),
      meals: Number(data.mealCount), foodFocus: this.foodFocus(values.selectedFoods, data.dietStyle, week)
    };
  }

  foodFocus(foods, style, offset) {
    if (!foods.length) return 'No foods selected';
    const preferred = style === 'higher-protein' ? ['Protein','Protein/Fiber','Protein/Fat'] :
      style === 'higher-fiber' ? ['Vegetable','Fruit','Protein/Fiber'] :
      style === 'lower-carb' ? ['Protein','Vegetable','Healthy fat'] :
      ['Protein','Vegetable','Carbohydrate','Fruit'];
    const pool = foods.filter(food => preferred.includes(food.category));
    const source = pool.length ? pool : foods;
    const start = offset % source.length;
    return [...source.slice(start), ...source.slice(0,start)].slice(0,4).map(food => this.foodDisplayName(food)).join(', ');
  }

  dailyTemplate(data, foods, balancedDiet=null) {
    return ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'].map((day,index) => ({
      day,
      walk: index < Number(data.walkDays) ? `${data.walkMinutes} min walking` : 'Recovery / mobility',
      breath: index < Number(data.breathDays) ? `${data.breathMinutes} min breathing` : 'Optional breathing',
      sun: index < Number(data.sunDays) ? `${data.sunMinutes} min sun exposure` : 'No planned sun exposure',
      fast: `${data.fastingHours}h fasting`,
      meals: `${data.mealCount} meals`,
      foods: balancedDiet ? balancedDiet.meals.map(meal => meal.foods.map(food => `${food.title} × ${food.servings}`).join(', ')).join(' | ') : this.foodFocus(foods, data.dietStyle, index)
    }));
  }

  renderReports() {
    const list = this.q('reportList');
    if (!list) return;
    list.innerHTML = this.state.reports.length ? this.state.reports.map(report => `<article class="hp-report-row">
      <div class="hp-report-icon">📊</div>
      <div><span>${new Date(report.generatedAt).toLocaleString()}</span><h3>${this.escape(report.profileName)}</h3><p>${report.plan.weeks} weeks · ${this.escape(report.plan.cycle)} cycle · target BMI ${this.round(report.plan.target.bmi)}</p></div>
      <div class="hp-profile-actions"><button data-report-open="${report.id}" class="is-primary">Open Report</button><button data-report-delete="${report.id}" class="hp-danger">Delete</button></div>
    </article>`).join('') : '<div class="hp-empty">No generated reports yet.</div>';
    list.querySelectorAll('[data-report-open]').forEach(button => button.addEventListener('click', () => this.openReport(button.dataset.reportOpen)));
    list.querySelectorAll('[data-report-delete]').forEach(button => button.addEventListener('click', () => this.deleteReport(button.dataset.reportDelete)));
  }

  openReport(id) {
    const report = this.state.reports.find(item => item.id === id);
    if (!report) return;
    const plan = report.plan;
    this.q('reportWorkspaceTitle').textContent = `${report.profileName} — Health Plan`;
    this.q('reportIntro').textContent = `Generated ${new Date(report.generatedAt).toLocaleString()} · ${plan.weeks}-week ${plan.cycle} plan`;
    const cards = [
      ['BMI', this.round(plan.current.bmi), `Target ${this.round(plan.target.bmi)}`],
      ['Weight', `${this.round(plan.current.weight)} kg`, `Target ${this.round(plan.target.weight)} kg`],
      ['BMR', `${Math.round(plan.current.bmr)} kcal`, `Target ${Math.round(plan.target.bmr)} kcal`],
      ['BSR', this.round(plan.current.bsr,3), `Target ${this.round(plan.target.bsr,3)}`],
      ['Body fat', `${this.round(plan.current.fat)}%`, `Target ${this.round(plan.target.fat)}%`]
    ];
    this.q('reportSummary').innerHTML = cards.map(card => `<article class="hp-plan-card"><small>${card[0]}</small><strong>${card[1]}</strong><span>${card[2]}</span></article>`).join('');
    this.q('reportMilestones').innerHTML = plan.milestones.map(item => `<tr>
      <td><b>${item.week === 0 ? 'Start' : `Week ${item.week}`}</b><small>${item.week === 0 ? 'Baseline' : `Month ${Math.ceil(item.week/4)}`}</small></td>
      <td><b>${this.round(item.weight)} kg · BMI ${this.round(item.bmi)}</b><small>Waist ${this.round(item.waist)} cm · BSR ${this.round(item.bsr,3)} · Fat ${this.round(item.fat)}% · BMR ${Math.round(item.bmr)}</small></td>
      <td><b>${item.walk} min × ${item.walkDays} walking</b><small>${item.breath} min × ${item.breathDays} breathing</small></td>
      <td><b>${item.sun} min × ${item.sunDays}</b><small>${item.fast}h fasting</small></td>
      <td><b>${item.meals} meals/day</b><small>${this.escape(item.foodFocus)}</small></td>
    </tr>`).join('');
    const nutrition = plan.balancedDiet;
    if (nutrition) {
      const t = nutrition.targets, a = nutrition.totals;
      this.q('reportNutritionSummary').innerHTML = [
        ['Energy', `${Math.round(a.calories)} kcal`, `Target ${t.calories} kcal`],
        ['Protein', `${this.round(a.nutrients.protein)} g`, `Target ${t.protein} g`],
        ['Carbohydrate', `${this.round(a.nutrients.carbohydrate)} g`, `Target ${t.carbohydrate} g`],
        ['Fat', `${this.round(a.nutrients.fat)} g`, `Target ${t.fat} g`],
        ['Fiber', `${this.round(a.nutrients.fiber)} g`, `Target ${t.fiber} g`]
      ].map(item => `<article class="hp-plan-card"><small>${item[0]}</small><strong>${item[1]}</strong><span>${item[2]}</span></article>`).join('');
      this.q('reportBalancedMeals').innerHTML = nutrition.meals.map(meal => `<article class="hp-balanced-meal">
        <header><h3>${meal.label}</h3><span>${Math.round(meal.foods.reduce((sum,food)=>sum+food.calories,0))} kcal</span></header>
        <div>${meal.foods.map(food => `<p><b>${this.escape(food.title)}</b><span>${food.servings} × ${this.escape(food.serving)} · ${this.round(food.servingWeight * food.servings)} g · P ${this.round(food.nutrients.protein)} / C ${this.round(food.nutrients.carbohydrate)} / F ${this.round(food.nutrients.fat)} g</span></p>`).join('')}</div>
      </article>`).join('');
    } else {
      this.q('reportNutritionSummary').innerHTML = '<div class="hp-empty">This older report has no nutrient-based meal plan.</div>';
      this.q('reportBalancedMeals').innerHTML = '';
    }
    this.q('reportDaily').innerHTML = plan.daily.map(day => `<article class="day-card"><b>${day.day}</b><span>${day.walk}</span><span>${day.breath}</span><span>${day.sun}</span><span>${day.fast}</span><span>${day.meals}</span><span>${this.escape(day.foods)}</span></article>`).join('');
    this.openWorkspace('reportWorkspace');
  }

  deleteReport(id) {
    if (!confirm('Delete this report?')) return;
    this.state.reports = this.state.reports.filter(report => report.id !== id);
    this.persist();
    this.renderReports();
  }
}

document.addEventListener('DOMContentLoaded', () => new HealthPlanner());
})();