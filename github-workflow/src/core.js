export function element(tag, attributes = {}, ...children) {
  const node = document.createElement(tag);
  Object.entries(attributes).forEach(([key, value]) => {
    if (key === 'className') node.className = value;
    else if (key.startsWith('on')) node.addEventListener(key.slice(2).toLowerCase(), value);
    else node.setAttribute(key, value);
  });
  children.flat().filter(child => child !== null && child !== undefined).forEach(child => node.append(child));
  return node;
}
export class Component {
  constructor(root) { if (!root) throw new Error('Component root is required'); this.root = root; }
  render(...nodes) { this.root.replaceChildren(...nodes); }
}
export class BrowserStorage {
  constructor(key, provider = () => window.localStorage) { this.key = key; this.provider = provider; }
  read() { try { return JSON.parse(this.provider().getItem(this.key)) || {}; } catch { return {}; } }
  write(value) { try { this.provider().setItem(this.key, JSON.stringify(value)); return true; } catch { return false; } }
}
export class ReleaseStore {
  constructor(storage, ids) {
    this.storage = storage; this.ids = ids; const saved = storage.read();
    this.state = {reference:typeof saved.reference === 'string' ? saved.reference.slice(0,120) : '', completed:Array.isArray(saved.completed) ? [...new Set(saved.completed.filter(id => ids.includes(id)))] : []};
  }
  setReference(reference) { this.state.reference = reference.slice(0,120); return this.persist(); }
  toggle(id, checked) { if (!this.ids.includes(id)) return false; this.state.completed = this.state.completed.filter(item => item !== id); if (checked) this.state.completed.push(id); return this.persist(); }
  reset() { this.state = {reference:'',completed:[]}; return this.persist(); }
  persist() { return this.storage.write(this.state); }
  get progress() { return {done:this.state.completed.length,total:this.ids.length,percent:this.ids.length ? Math.round(this.state.completed.length/this.ids.length*100) : 0}; }
}
export class ClipboardService {
  async copy(text) { if (!navigator.clipboard?.writeText) throw new Error('Clipboard unavailable'); await navigator.clipboard.writeText(text); }
}
export function filterSteps(playbooks, selected, query = '') {
  const term = query.trim().toLowerCase();
  return playbooks.filter(book => term || book.id === selected).flatMap(book => book.steps.map(step => ({...step,category:book.label}))).filter(step => !term || [step.title,step.body,step.command,step.category].filter(Boolean).join(' ').toLowerCase().includes(term));
}
