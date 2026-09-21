class CsvPanel {
  constructor(flow,onChange) {
    this.flow=flow;this.onChange=onChange;this.pending=null;this.readVersion=0;
    this.dialog=document.getElementById('csvDialog');
    document.getElementById('openCsv').onclick=()=>{document.querySelectorAll('.menubar details').forEach(d=>d.open=false);this.dialog.showModal();};
    document.getElementById('closeCsv').onclick=()=>this.dialog.close();
    document.getElementById('exportLibrary').onclick=()=>this.download('conversation-library.csv',window.ConversationCsv.libraryRecords(flow.data));
    document.getElementById('exportConversation').onclick=()=>this.download('selected-conversation.csv',window.ConversationCsv.conversationRecords(flow));
    document.getElementById('csvFile').onchange=event=>this.preview(event.target.files[0]);
    this.dialog.querySelectorAll('[name="importMode"]').forEach(r=>r.onchange=()=>this.validate());
    document.getElementById('applyCsv').onclick=()=>this.apply();
  }
  mode() {return this.dialog.querySelector('[name="importMode"]:checked').value;}
  status(message,error=false) {const el=document.getElementById('csvStatus');el.textContent=message;el.classList.toggle('error',error);}
  download(name,records) {
    if(!records.length){this.status('Choose a dialogue before exporting.',true);return;}
    const url=URL.createObjectURL(new Blob([window.ConversationCsv.stringify(records)],{type:'text/csv;charset=utf-8'}));
    const a=document.createElement('a');a.href=url;a.download=name;document.body.append(a);a.click();a.remove();setTimeout(()=>URL.revokeObjectURL(url),1000);
    this.status(`Exported ${records.length.toLocaleString()} dialogue lines.`);
  }
  async preview(file) {
    const version=++this.readVersion;this.pending=null;
    document.getElementById('importControls').hidden=true;document.getElementById('csvPreview').replaceChildren();this.status('');
    if(!file)return;
    try {
      if(file.size>15*1024*1024)throw Error('Choose a CSV file smaller than 15 MB.');
      const text=await file.text();if(version!==this.readVersion)return;
      this.pending=window.ConversationCsv.parse(text);
      const rows=this.pending.records;
      document.getElementById('csvPreview').innerHTML=`<h3>${rows.length.toLocaleString()} lines · ${e(this.pending.kind)}</h3><p class="small muted">Preview of the first ${Math.min(5,rows.length)} lines. Nothing has been applied yet.</p><div class="table-scroll"><table><thead><tr><th>Topic / step</th><th>Pattern / mood</th><th>Speaker</th><th>Text</th></tr></thead><tbody>${rows.slice(0,5).map(r=>`<tr><td>${e(r.topic)}<br>${e(r.step)}</td><td>${e(r.pattern)}<br>${e(r.mood)}</td><td>${e(r.speaker)}</td><td>${e(r.text)}</td></tr>`).join('')}</tbody></table></div>`;
      document.getElementById('importControls').hidden=false;this.validate();
    } catch(error){if(version===this.readVersion)this.status(error.message,true);}
  }
  validate() {
    if(!this.pending)return false;
    const mode=this.mode(),library=this.pending.kind==='library';
    document.getElementById('importEffect').textContent=library?
      `${mode==='merge'?'Merge adds patterns and replaces matching pattern/mood lines.':'Replace replaces the entire library.'} Applying starts a fresh conversation. Export a backup first if you want to keep your current path.`:
      `${mode==='merge'?'Merge appends imported dialogue to your current conversation. Repeated greetings or goodbyes are retained.':'Replace replaces your current conversation path.'} The library is unchanged. Imported steps remain editable; an imported path contains speaking steps rather than its original choice nodes.`;
    try {
      if(library)this.prepared=window.ConversationCsv.importLibrary(this.flow.data,this.pending.records,mode);
      else{const trial=new window.ConversationFlow(this.flow.data);trial.nodes=JSON.parse(JSON.stringify(this.flow.nodes));trial.cursor=this.flow.cursor;trial.sequence=this.flow.sequence;window.ConversationCsv.importConversation(trial,this.pending.records,mode);}
      document.getElementById('applyCsv').disabled=false;this.status('Validated. Review the preview and apply when ready.');return true;
    }catch(error){document.getElementById('applyCsv').disabled=true;this.status(error.message,true);return false;}
  }
  apply() {
    if(!this.validate())return;
    if(this.pending.kind==='library'){this.flow.data=this.prepared;this.flow.reset();}
    else window.ConversationCsv.importConversation(this.flow,this.pending.records,this.mode());
    this.pending=null;document.getElementById('csvFile').value='';document.getElementById('importControls').hidden=true;
    document.getElementById('csvPreview').replaceChildren();this.status('Import applied to this session. Export to keep a copy.');
    this.onChange();
  }
}
document.addEventListener('DOMContentLoaded',()=>new App(window.CONVERSATION_DATA).init());
