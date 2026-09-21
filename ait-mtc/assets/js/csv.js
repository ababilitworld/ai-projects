/* RFC-style CSV quoting, validated records and atomic import transformations. */
(function(root){
  'use strict';
  const HEADERS=['kind','sequence','topic','subtopic','step','pattern','mood','line_order','speaker','text','place'];
  const TITLES={'greeting':'Greeting','proposal':'Topic proposal','introduction':'Introduction','conclusion':'Conclusion','invitation':'Invitation','continue':'Continue talking','change-topic':'Change topic','change-subtopic':'Another subtopic','finish-choice':'Choose to finish','finishing':'Finishing','goodbye':'Goodbye','legacy-response':'Response'};
  const stepInfo=step=>{
    const slug=Object.keys(TITLES).find(k=>TITLES[k]===step);if(slug)return slug;
    const desc=/^Description ([1-9]\d*)$/.exec(step);if(desc&&+desc[1]<=20)return 'description-'+desc[1];
    const legacy={Question:'introduction',Answer:'description-1','Follow-up':'description-2',Ending:'finishing'};if(legacy[step])return legacy[step];
    const qa=/^Question & Answer ([1-9]\d*)$/.exec(step);if(qa&&+qa[1]<=20)return +qa[1]===1?'introduction':'description-'+(+qa[1]-1);
    return null;
  };
  const stepName=slug=>TITLES[slug]||'Description '+slug.split('-')[1];
  const MOODS=['Neutral','Happy','Excited','Curious','Friendly','Polite','Calm','Surprised','Confident'];
  const clone=value=>JSON.parse(JSON.stringify(value));
  // Protect spreadsheet formulas, preserving a reversible leading apostrophe.
  const protect=value=>/^[=+\-@\t\r\n']/.test(String(value))?"'"+value:String(value);
  const unprotect=value=>/^'[=+\-@\t\r\n']/.test(value)?value.slice(1):value;
  class ConversationCsv {
    static stringify(records){
      return '\uFEFF'+[HEADERS,...records.map(r=>HEADERS.map(h=>r[h]??''))].map(row=>row.map(v=>'"'+protect(v).replace(/"/g,'""')+'"').join(',')).join('\r\n')+'\r\n';
    }
    static parse(text){
      if(text.length>15*1024*1024) throw Error('CSV exceeds 15 MB.');
      text=text.replace(/^\uFEFF/,'');
      const rows=[];let row=[],field='',quoted=false,closed=false;
      const endField=()=>{row.push(unprotect(field));field='';closed=false;};
      for(let i=0;i<text.length;i++){
        const c=text[i];
        if(quoted){if(c==='"'){if(text[i+1]==='"'){field+='"';i++;}else{quoted=false;closed=true;}}else field+=c;}
        else if(c==='"'){if(field||closed)throw Error('Unexpected quote in CSV.');quoted=true;}
        else if(c===','){endField();}
        else if(c==='\n'||c==='\r'){if(c==='\r'&&text[i+1]==='\n')i++;endField();if(row.some(v=>v!==''))rows.push(row);row=[];}
        else {if(closed)throw Error('Unexpected text after a closing quote.');field+=c;}
      }
      if(quoted)throw Error('Unclosed quoted field.');
      if(field||row.length||closed){endField();rows.push(row);}
      const headers=rows[0]||[];
      if(headers.join(',')!==HEADERS.join(',')&&headers.join(',')!==HEADERS.slice(0,-1).join(','))throw Error('CSV headers must match an exported template.');
      if(rows.length<2)throw Error('The CSV contains no dialogue rows.');
      if(rows.length>100001)throw Error('CSV exceeds 100,000 dialogue rows.');
      const seen=new Set();let kind;
      const records=rows.slice(1).map((values,i)=>{
        if(values.length!==headers.length)throw Error(`Row ${i+2}: expected ${headers.length} fields.`);
        const r=Object.fromEntries(headers.map((h,j)=>[h,values[j]]));r.place=r.place||(r.kind==='conversation'?'Home':'');
        if(!['library','conversation'].includes(r.kind)||(kind&&kind!==r.kind))throw Error('Use one kind per file: library or conversation.');kind=r.kind;
        if(!r.topic.trim()||!r.subtopic.trim()||!r.pattern.trim()||!r.speaker.trim()||!r.text.trim())throw Error(`Row ${i+2}: missing topic, subtopic, pattern, speaker or text.`);
        if(r.kind==='conversation'&&(r.place.trim().length>80||/[\x00-\x1f]/.test(r.place)))throw Error('Invalid place.');
        if(!stepInfo(r.step)||!MOODS.includes(r.mood))throw Error(`Row ${i+2}: unknown step or mood. Use the exported spelling.`);
        if(!/^[1-9]\d*$/.test(r.line_order)||+r.line_order>100)throw Error(`Row ${i+2}: line_order must be between 1 and 100.`);
        if(r.kind==='conversation'&&(!/^[1-9]\d*$/.test(r.sequence)||+r.sequence>10000))throw Error(`Row ${i+2}: invalid sequence.`);
        if(r.kind==='library'&&r.sequence!=='')throw Error(`Row ${i+2}: library sequence must be empty.`);
        if(HEADERS.filter(h=>h!=='text').some(h=>r[h].length>200)||r.text.length>20000)throw Error(`Row ${i+2}: field too long.`);
        const key=JSON.stringify([r.kind,r.sequence,r.topic,r.subtopic,r.step,r.pattern,r.mood,r.line_order]);
        if(seen.has(key))throw Error(`Row ${i+2}: duplicate dialogue line.`);seen.add(key);
        return r;
      });
      this.groups(records);return {kind,records};
    }
    static groups(records){
      const map=new Map();
      for(const r of records){
        const key=r.kind==='conversation'?r.sequence:JSON.stringify([r.topic,r.subtopic,r.step,r.pattern,r.mood]);
        if(!map.has(key))map.set(key,[]);map.get(key).push(r);
      }
      return [...map.values()].map(rows=>{
        rows.sort((a,b)=>+a.line_order-+b.line_order);
        if(rows.some((r,i)=>+r.line_order!==i+1))throw Error('Each dialogue must have consecutive line_order values starting at 1.');
        if(rows.some(r=>['topic','subtopic','step','pattern','mood','place'].some(h=>r[h]!==rows[0][h])))throw Error('A conversation sequence must describe one dialogue selection.');
        if(rows.length<2||new Set(rows.map(r=>r.speaker)).size<2)throw Error('Each exchange needs a question or prompt and a response from two speakers.');
        return rows;
      });
    }
    static libraryRecords(data){
      const rows=[];data.forEach(t=>t.subtopics.forEach(s=>s.stages.forEach(g=>g.candidates.forEach(c=>{
        for(const [mood,lines] of Object.entries({Neutral:c.lines,...c.moods}))lines.forEach(([speaker,text],j)=>rows.push({kind:'library',sequence:'',topic:t.title,subtopic:s.title,step:stepName(g.slug),pattern:c.label,mood,line_order:j+1,speaker,text,place:''}));
      }))));return rows;
    }
    static conversationRecords(flow){return flow.transcript().flatMap((n,i)=>flow.lines(n).map((l,j)=>({kind:'conversation',sequence:i+1,topic:flow.data[n.t].title,subtopic:flow.data[n.t].subtopics[n.s].title,step:stepName(n.part),pattern:flow.stage(n).candidates[n.pattern].label,mood:MOODS[n.mood],line_order:j+1,...l,place:n.place})));}
    static importLibrary(data,records,mode){
      const result=mode==='replace'?[]:clone(data);
      const legacy=records.some(r=>/^(Question|Answer|Follow-up|Ending|Response)/.test(r.step));
      for(const rows of this.groups(records)){
        const r=rows[0];let t=result.find(t=>t.title===r.topic);if(!t){t={title:r.topic,subtopics:[]};result.push(t);}
        let s=t.subtopics.find(s=>s.title===r.subtopic);if(!s){s={title:r.subtopic,stages:[]};t.subtopics.push(s);}
        let slug=stepInfo(r.step),label=r.pattern;
        if(slug==='legacy-response'){slug='invitation';label='Response: '+label;}
        let g=s.stages.find(g=>g.slug===slug);if(!g){g={slug,title:stepName(slug),candidates:[]};s.stages.push(g);}
        let c=g.candidates.find(c=>c.label===label);if(!c){c={label,lines:[],moods:{}};g.candidates.push(c);}
        const lines=rows.map(r=>[r.speaker,r.text]);if(r.mood==='Neutral'){c.lines=lines;c.pattern=lines[0][1];c.response=lines[1]?.[1]||'';}else c.moods[r.mood]=lines;
      }
      const required=['greeting','proposal','introduction','description-1','description-2','conclusion','invitation','continue','change-topic','change-subtopic','finish-choice','finishing','goodbye'];
      if(!result.length)throw Error('The library cannot be empty.');
      for(const [ti,t] of result.entries()){t.id=ti;for(const [si,s] of t.subtopics.entries()){
        s.id=si;
        if(legacy){
          const defaults=data.find(x=>x.title===t.title)?.subtopics.find(x=>x.title===s.title)||data[0].subtopics[0];
          for(const slug of required)if(!s.stages.some(g=>g.slug===slug)){
            const source=slug==='conclusion'?s.stages.find(g=>g.slug==='finishing'):defaults.stages.find(g=>g.slug===slug);
            if(source)s.stages.push({...clone(source),slug,title:stepName(slug)});
          }
        }
        if(required.some(slug=>!s.stages.some(g=>g.slug===slug)))throw Error(t.title+' / '+s.title+': provide all conversation stages, or merge a partial update.');
        const descriptions=s.stages.filter(g=>g.slug.startsWith('description-')).map(g=>+g.slug.split('-')[1]).sort((a,b)=>a-b);
        if(descriptions.some((n,i)=>n!==i+1))throw Error('Description rounds must be consecutive.');
        for(const g of s.stages)if(!g.candidates.length||g.candidates.some(c=>!c.lines.length))throw Error('Every pattern needs a Neutral version.');
      }}return result;
    }
    static importConversation(flow,records,mode){
      const groups=this.groups(records).sort((a,b)=>+a[0].sequence-+b[0].sequence);
      if(!groups.length||groups.some((g,i)=>+g[0].sequence!==i+1))throw Error('Conversation sequences must start at 1 without gaps.');
      const selections=groups.map(rows=>{
        const r=rows[0],t=flow.data.findIndex(t=>t.title===r.topic),s=flow.data[t]?.subtopics.findIndex(s=>s.title===r.subtopic),part=stepInfo(r.step);
        if(t<0||s==null||s<0)throw Error('Unknown topic or subtopic. Import its library first.');
        const stage=flow.data[t].subtopics[s].stages.find(g=>g.slug===part),index=stage?.candidates.findIndex(c=>c.label===r.pattern)??-1;
        const extra=index<0?{importedStage:{slug:part,title:stepName(part),candidates:[{label:r.pattern,lines:rows.map(r=>[r.speaker,r.text]),moods:{}}]}}:{};
        return {t,s,part,pattern:index<0?0:index,mood:MOODS.indexOf(r.mood),place:r.place||'Home',customLines:rows.map(r=>({speaker:r.speaker,text:r.text})),...extra};
      });
      const nodes=mode==='merge'?flow.transcript().map(n=>({...n,confirmed:true})):[];
      selections.forEach(n=>nodes.push(flow.node('speech',{...n,confirmed:true})));
      const cursor=nodes.length;nodes.push(...flow.continuation(nodes.at(-1)));flow.nodes=nodes;flow.cursor=cursor;
    }
  }
  root.ConversationCsv=ConversationCsv;
  if(typeof module!=='undefined')module.exports=ConversationCsv;
})(typeof window!=='undefined'?window:globalThis);
