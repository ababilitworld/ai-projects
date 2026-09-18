/* RFC-style CSV quoting, validated records and atomic import transformations. */
(function(root){
  'use strict';
  const HEADERS=['kind','sequence','topic','subtopic','step','pattern','mood','line_order','speaker','text'];
  const FIXED_STEPS=['Greeting','Invitation','Response','Change topic','Ending','Goodbye'];
  const FIXED_G=[0,4,5,6,7,8];
  const stepInfo=step=>{
    const fixed=FIXED_STEPS.indexOf(step);
    if(fixed>=0)return {g:FIXED_G[fixed],stageIndex:fixed,qaIndex:null};
    const legacy={'Question':0,'Answer':1,'Follow-up':2};
    const qaIndex=Object.hasOwn(legacy,step)?legacy[step]:(/^Question & Answer ([1-9]\d*)$/.exec(step)?.[1]||0)-1;
    return Number.isInteger(qaIndex)&&qaIndex>=0&&qaIndex<20?{g:1,stageIndex:null,qaIndex}:null;
  };
  const stepName=(g,qaIndex)=>g===1?`Question & Answer ${qaIndex+1}`:FIXED_STEPS[FIXED_G.indexOf(g)];
  const stageFor=(subtopic,info)=>info.g===1?subtopic.questionAnswers[info.qaIndex]:subtopic.stages[info.stageIndex];
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
      if(!rows.length||rows[0].join(',')!==HEADERS.join(','))throw Error('CSV headers must match an exported template.');
      if(rows.length<2)throw Error('The CSV contains no dialogue rows.');
      if(rows.length>100001)throw Error('CSV exceeds 100,000 dialogue rows.');
      const seen=new Set();let kind;
      const records=rows.slice(1).map((values,i)=>{
        if(values.length!==HEADERS.length)throw Error(`Row ${i+2}: expected ${HEADERS.length} fields.`);
        const r=Object.fromEntries(HEADERS.map((h,j)=>[h,values[j]]));
        if(!['library','conversation'].includes(r.kind)||(kind&&kind!==r.kind))throw Error('Use one kind per file: library or conversation.');kind=r.kind;
        if(!r.topic.trim()||!r.subtopic.trim()||!r.pattern.trim()||!r.speaker.trim()||!r.text.trim())throw Error(`Row ${i+2}: missing topic, subtopic, pattern, speaker or text.`);
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
        if(rows.some(r=>['topic','subtopic','step','pattern','mood'].some(h=>r[h]!==rows[0][h])))throw Error('A conversation sequence must describe one dialogue selection.');
        if(stepInfo(rows[0].step)?.g===1&&(rows.length<2||rows[0].speaker===rows[1].speaker))throw Error('A Question & Answer dialogue needs both speakers in one paired selection.');
        return rows;
      });
    }
    static libraryRecords(data){
      const rows=[];
      data.forEach(t=>t.subtopics.forEach(s=>{
        const stages=[{step:'Greeting',stage:s.stages[0]},...s.questionAnswers.map((stage,i)=>({step:stepName(1,i),stage})),...s.stages.slice(1).map((stage,i)=>({step:FIXED_STEPS[i+1],stage}))];
        stages.forEach(({step,stage})=>stage.candidates.forEach(c=>{
          for(const [mood,lines] of Object.entries({Neutral:c.lines,...c.moods}))lines.forEach(([speaker,text],j)=>rows.push({kind:'library',sequence:'',topic:t.title,subtopic:s.title,step,pattern:c.label,mood,line_order:j+1,speaker,text}));
        }));
      }));return rows;
    }
    static conversationRecords(flow){
      return flow.transcript().flatMap((n,i)=>flow.lines(n).map((l,j)=>({kind:'conversation',sequence:i+1,topic:flow.data[n.t].title,subtopic:flow.data[n.t].subtopics[n.s].title,step:stepName(n.g,n.qaIndex),pattern:flow.stage(n).candidates[n.pattern].label,mood:MOODS[n.mood],line_order:j+1,...l})));
    }
    static importLibrary(data,records,mode){
      const result=mode==='replace'?[]:clone(data);
      for(const rows of this.groups(records)){
        const r=rows[0];let t=result.find(t=>t.title===r.topic);
        if(!t){t={title:r.topic,subtopics:[]};result.push(t);}
        let s=t.subtopics.find(s=>s.title===r.subtopic);
        if(!s){s={title:r.subtopic,questionAnswers:[],stages:FIXED_STEPS.map(title=>({title,candidates:[]}))};t.subtopics.push(s);}
        const info=stepInfo(r.step);
        if(info.g===1)while(s.questionAnswers.length<=info.qaIndex){const number=s.questionAnswers.length+1;s.questionAnswers.push({title:`Question & Answer ${number}`,candidates:[]});}
        const g=stageFor(s,info);let c=g.candidates.find(c=>c.label===r.pattern);
        if(!c){c={label:r.pattern,lines:[],moods:{}};g.candidates.push(c);}
        const lines=rows.map(r=>[r.speaker,r.text]);
        if(r.mood==='Neutral'){c.lines=lines;c.pattern=lines[0][1];c.response=lines[1]?.[1]||'';}
        else{c.moods??={};c.moods[r.mood]=lines;}
      }
      if(!result.length)throw Error('The library cannot be empty.');
      for(const t of result)for(const s of t.subtopics){
        if(s.questionAnswers.length<3)throw Error(`${t.title} / ${s.title}: provide at least three paired Question & Answer rounds.`);
        for(const g of [...s.stages,...s.questionAnswers]){
        if(!g.candidates.length||g.candidates.some(c=>!c.lines.length))throw Error(`${t.title} / ${s.title}: provide every conversation step and a Neutral version of each pattern. Merge a partial update, or export the full library first.`);
        }
        for(const round of s.questionAnswers)if(round.candidates.some(c=>[c.lines,...Object.values(c.moods||{})].some(lines=>lines.length<2||lines[0][0]===lines[1][0])))throw Error(`${t.title} / ${s.title}: each Question & Answer pattern and mood needs both speakers.`);
      }
      return result;
    }
    static importConversation(flow,records,mode){
      const groups=this.groups(records).sort((a,b)=>+a[0].sequence-+b[0].sequence);
      if(groups.some((g,i)=>+g[0].sequence!==i+1))throw Error('Conversation sequences must start at 1 without gaps.');
      // Validate all references before changing the active flow.
      const selections=groups.map(rows=>{
        const r=rows[0],t=flow.data.findIndex(t=>t.title===r.topic),s=flow.data[t]?.subtopics.findIndex(s=>s.title===r.subtopic),info=stepInfo(r.step);
        const p=stageFor(flow.data[t]?.subtopics[s]||{questionAnswers:[],stages:[]},info)?.candidates.findIndex(c=>c.label===r.pattern);
        if(t<0||s==null||s<0||p==null||p<0)throw Error('Conversation references an unknown topic, subtopic or pattern. Import its library first.');
        return {t,s,g:info.g,qaIndex:info.qaIndex,pattern:p,mood:MOODS.indexOf(r.mood),customLines:rows.map(r=>({speaker:r.speaker,text:r.text}))};
      });
      const nodes=mode==='merge'?flow.transcript().map(n=>({...n,confirmed:true})):[];
      selections.forEach(n=>nodes.push(flow.node('speech',{...n,confirmed:true})));
      const last=nodes.at(-1);
      const cursor=nodes.length;
      if(last.g===1){
        const rounds=flow.data[last.t].subtopics[last.s].questionAnswers;
        for(let i=last.qaIndex+1;i<rounds.length;i++)nodes.push(flow.speech(last.t,last.s,1,i));
        nodes.push(flow.speech(last.t,last.s,4),flow.speech(last.t,last.s,5));
      }else if(last.g===4)nodes.push(flow.speech(last.t,last.s,5));
      nodes.push(last.g===8?flow.node('complete'):last.g===7?flow.speech(last.t,last.s,8):last.g===0||last.g===6?flow.node('topic',{t:null,s:null}):flow.node('decision',{t:last.t,s:last.s}));
      flow.nodes=nodes;flow.cursor=cursor;
    }
  }
  root.ConversationCsv=ConversationCsv;
  if(typeof module!=='undefined')module.exports=ConversationCsv;
})(typeof window!=='undefined'?window:globalThis);
