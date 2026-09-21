'use strict';
const test=require('node:test'),assert=require('node:assert/strict'),vm=require('node:vm'),fs=require('node:fs'),path=require('node:path');
require('../assets/js/content.js');require('../assets/js/structures.js');require('../assets/js/structure-dialogues.js');require('../assets/js/library.js');
const {ConversationFlow,MOODS}=require('../assets/js/model.js'),Csv=require('../assets/js/csv.js'),data=global.CONVERSATION_DATA;
const fresh=()=>new ConversationFlow(data);
function select(f,i=0){assert.equal(f.current.type,'structure');f.previewStructure(i);f.useStructure();assert.equal(f.current.type,'speech');}
function exchange(f,i=0){if(f.current.type==='structure')select(f,i);f.next();}
function start(f=fresh()){f.choosePlace('Park');f.chooseMood(1);exchange(f);exchange(f);f.chooseTopic(0);f.chooseSubtopic(0);f.chooseMood(6);select(f);return f;}
function speak(f){while(['speech','structure'].includes(f.current.type))exchange(f);}
const parsed=rows=>Csv.parse(Csv.stringify(rows)).records;
test('all original topics and 81 subtopics have practical four-part paired dialogue',()=>{
 const old={window:{}};vm.runInNewContext(fs.readFileSync(path.join(__dirname,'../assets/js/data.js'),'utf8'),old);
 assert.equal(data.length,9);assert.equal(data.flatMap(t=>t.subtopics).length,81);
 assert.deepEqual(data.map(t=>[t.title,t.subtopics.map(s=>s.title)]),JSON.parse(JSON.stringify(old.window.CONVERSATION_DATA.map(t=>[t.title,t.subtopics.map(s=>s.title)]))));
 const intros=new Set();for(const t of data)for(const s of t.subtopics){assert.deepEqual(fresh().subtopicParts(data.indexOf(t),t.subtopics.indexOf(s)),['introduction','description-1','description-2','conclusion','invitation']);for(const g of s.stages)for(const c of g.candidates)for(const lines of [c.lines,...Object.values(c.moods)]){assert.equal(lines.length,2);assert.notEqual(lines[0][0],lines[1][0]);assert(lines.every(l=>l[1].trim()));}intros.add(s.stages.find(g=>g.slug==='introduction').candidates[0].lines[0][1]);}assert(intros.size>75);
});
test('place and mood gate the greeting and every subtopic',()=>{
 const f=fresh();assert.equal(f.transcript().length,0);f.next();assert.equal(f.current.type,'place');f.choosePlace('Library');assert.equal(f.current.scope,'greeting');f.chooseMood(3);assert.equal(f.current.part,'greeting');assert.equal(f.current.type,'structure');assert.equal(f.current.place,'Library');select(f);assert(!f.lines()[0].text.includes('{setting}'));f.next();assert.equal(f.current.part,'proposal');exchange(f);f.chooseTopic(2);f.chooseSubtopic(1);assert.equal(f.current.type,'mood');assert.equal(f.current.place,'Library');f.next();assert.equal(f.current.type,'mood');f.chooseMood(5,'School');assert.equal(f.current.part,'introduction');assert.equal(f.current.type,'structure');assert.equal(f.current.place,'School');assert.equal(f.current.mood,5);assert.equal(f.transcript()[0].place,'Library');
});
test('same-topic invitation leads to explicit continue, direction and fresh mood',()=>{
 const f=start();speak(f);assert.equal(f.transcript().at(-1).part,'invitation');assert.equal(f.current.type,'decision');f.branch('continue');assert.equal(f.current.part,'continue');exchange(f);assert.equal(f.current.type,'direction');f.chooseDirection('subtopic');assert.equal(f.current.part,'change-subtopic');exchange(f);assert.equal(f.current.type,'subtopic');assert.equal(f.current.t,0);f.chooseSubtopic(1);assert.equal(f.current.scope,'subtopic');assert.equal(f.current.mood,6);f.chooseMood(6);assert.equal(f.current.part,'introduction');assert.equal(f.current.type,'structure');assert.equal(f.transcript().filter(n=>n.part==='greeting').length,1);
});
test('new-topic route repeats proposal and finish speaks its response, finishing, goodbye',()=>{
 const f=start();speak(f);f.branch('continue');exchange(f);f.chooseDirection('topic');exchange(f);assert.equal(f.current.part,'proposal');exchange(f);f.chooseTopic(1);f.chooseSubtopic(1);f.chooseMood(4,'Restaurant');speak(f);f.branch('finish');assert.equal(f.current.part,'finish-choice');exchange(f);assert.equal(f.current.part,'finishing');exchange(f);assert.equal(f.current.part,'goodbye');exchange(f);assert.equal(f.current.type,'complete');assert.equal(f.transcript().filter(n=>n.part==='greeting').length,1);assert.equal(f.transcript().at(-1).place,'Restaurant');
});
test('roadmap preserves identical choices and truncates changed context without rewriting history',()=>{
 const f=start();speak(f);f.branch('finish');speak(f);const nodes=JSON.stringify(f.nodes),mood=f.nodes.find(n=>n.scope==='subtopic');f.visit(mood.id);f.chooseMood(6);assert.equal(JSON.stringify(f.nodes),nodes);f.visit(mood.id);f.chooseMood(2,'Home');assert.equal(f.current.part,'introduction');assert(!f.nodes.some(n=>n.part==='goodbye'));assert.equal(f.transcript()[0].place,'Park');assert.equal(f.current.place,'Home');
});
test('invalid choices and locked roadmap nodes do not advance',()=>{
 const f=fresh();for(const p of ['', ' '.repeat(3),'a'.repeat(81),'bad\nplace'])f.choosePlace(p);assert.equal(f.current.type,'place');f.chooseMood(2);assert.equal(f.current.type,'place');f.choosePlace('Home');f.chooseMood(99);assert.equal(f.current.type,'mood');f.chooseMood(0);f.visit(f.nodes.at(-1).id);assert.equal(f.current.part,'greeting');
});
test('library CSV roundtrip preserves every stage, pattern and mood',()=>{
 const rows=Csv.libraryRecords(data),restored=Csv.importLibrary(data,parsed(rows),'replace');assert.deepEqual(Csv.libraryRecords(restored),rows);
});
test('conversation CSV preserves place, moods and exact text and resumes unfinished sections',()=>{
 const f=start();f.next();select(f,2);const rows=parsed(Csv.conversationRecords(f)),g=fresh();Csv.importConversation(g,rows,'replace');assert.equal(g.current.part,'description-2');assert.equal(g.current.type,'structure');assert.equal(g.current.place,'Park');assert.equal(g.current.mood,6);assert.deepEqual(Csv.conversationRecords(g).map(r=>r.text),rows.map(r=>r.text));assert.equal(g.transcript().at(-1).pattern,2);speak(g);g.branch('finish');speak(g);const h=fresh();Csv.importConversation(h,parsed(Csv.conversationRecords(g)),'replace');assert.equal(h.current.type,'complete');
});
test('legacy headers, stage names and unknown old pattern labels preserve dialogue',()=>{
 const f=start(),rows=Csv.conversationRecords(f).slice(-2).map(r=>({...r,sequence:1,step:'Question & Answer 1',pattern:'Old pattern'}));let csv=Csv.stringify(rows).split('\r\n').filter(Boolean).map(line=>line.replace(/,"[^"]*"$/,'')).join('\r\n');const records=Csv.parse(csv).records;const g=fresh();Csv.importConversation(g,records,'replace');assert.equal(g.transcript()[0].place,'Home');assert.equal(g.current.part,'description-1');assert.deepEqual(g.lines(g.transcript()[0]).map(l=>l.text),rows.map(r=>r.text));
});
test('legacy library stages migrate with structural defaults and response alternatives',()=>{
 const map={'Introduction':'Question & Answer 1','Description 1':'Question & Answer 2','Description 2':'Question & Answer 3','Finishing':'Ending'};
 const allowed=['Greeting','Introduction','Description 1','Description 2','Invitation','Change topic','Finishing','Goodbye'];let rows=Csv.libraryRecords(data).filter(r=>r.topic===data[0].title&&r.subtopic===data[0].subtopics[0].title&&allowed.includes(r.step)).map(r=>({...r,step:map[r.step]||r.step}));rows.push(...rows.filter(r=>r.step==='Invitation').map(r=>({...r,step:'Response'})));
 const migrated=Csv.importLibrary(data,parsed(rows),'replace');assert.equal(migrated[0].subtopics[0].stages.length,13);assert(migrated[0].subtopics[0].stages.find(g=>g.slug==='invitation').candidates.some(c=>c.label==='Response: Simple and direct'));
});
test('CSV quoting, Unicode and formula text roundtrip without execution',()=>{
 const rows=Csv.conversationRecords(start()).slice(-2).map((r,i)=>({...r,sequence:1,text:i?'বাংলা, "hello"\nsecond line':'=SUM(1,2)',place:'Reading room'}));assert.deepEqual(parsed(rows).map(r=>r.text),rows.map(r=>r.text));assert(Csv.stringify(rows).includes("'=SUM"));
});
test('malformed CSV and failed import leave the active conversation unchanged',()=>{
 const f=start(),before=JSON.stringify(f),rows=parsed(Csv.conversationRecords(f));assert.throws(()=>Csv.parse('bad headers\na,b'));assert.throws(()=>Csv.parse(Csv.stringify([rows[0]])),/two speakers/);assert.throws(()=>Csv.parse(Csv.stringify([...rows,rows[0]])),/duplicate/);assert.throws(()=>Csv.importConversation(f,rows.map(r=>({...r,topic:'missing'})),'replace'),/Unknown/);assert.equal(JSON.stringify(f),before);assert.throws(()=>Csv.importLibrary(data,Csv.libraryRecords(data).filter(r=>r.step==='Introduction'),'replace'),/all conversation stages/);
});
test('merging conversation preserves earlier exchanges and context',()=>{const f=start(),rows=parsed(Csv.conversationRecords(f)).slice(-2).map(r=>({...r,sequence:'1',place:'Home'})),count=f.transcript().length;Csv.importConversation(f,rows,'merge');assert.equal(f.transcript().filter(n=>n.confirmed).length,count+1);assert.equal(f.transcript()[0].place,'Park');assert.equal(f.current.place,'Home');});
test('full archived library migrates without losing any original pattern text',()=>{
 const old={window:{}};vm.runInNewContext(fs.readFileSync(path.join(__dirname,'../assets/js/data.js'),'utf8'),old);
 const labels=['Greeting','Question & Answer 1','Question & Answer 2','Question & Answer 3','Invitation','Response','Change topic','Ending','Goodbye'];
 const rows=old.window.CONVERSATION_DATA.flatMap(t=>t.subtopics.flatMap(s=>s.stages.flatMap((g,i)=>g.candidates.flatMap(c=>c.lines.map(([speaker,text],j)=>({kind:'library',sequence:'',topic:t.title,subtopic:s.title,step:labels[i],pattern:c.label,mood:'Neutral',line_order:j+1,speaker,text}))))));
 const migrated=Csv.importLibrary(data,parsed(rows),'replace');const exported=Csv.libraryRecords(migrated);assert.equal(migrated.flatMap(t=>t.subtopics).length,81);const texts=new Set(exported.map(r=>r.text));assert(rows.every(r=>texts.has(r.text)));
});

test('all 81 scenarios supply nine distinct named structures for every speaking stage',()=>{
 const labels=global.CONVERSATION_STRUCTURES.map(s=>s.label);
 assert.equal(global.CONVERSATION_SCENARIOS.flat().length,81);
 let count=0;
 for(const [t,topic] of data.entries())for(const [s,subtopic] of topic.subtopics.entries())for(const stage of subtopic.stages){
   assert.deepEqual(stage.candidates.map(c=>c.label),labels);
   assert.equal(new Set(stage.candidates.map(c=>JSON.stringify(c.lines))).size,9,`${topic.title}/${subtopic.title}/${stage.slug}`);
   for(const [pattern,c] of stage.candidates.entries())for(let mood=0;mood<MOODS.length;mood++){
     const f=fresh(),lines=f.lines({t,s,part:stage.slug,pattern,mood,place:'Park'});
     assert.equal(lines.length,2);assert(lines.every(l=>!l.text.includes('undefined')&&!/\{\w+\}/.test(l.text)));
   }
   count+=stage.candidates.length;
 }
 assert.equal(count,9477);
});

test('preview is separate from confirmation and cannot leak into the transcript',()=>{
 const f=fresh();f.choosePlace('Home');f.chooseMood(0);
 assert.equal(f.current.type,'structure');const id=f.current.id;
 f.next();f.useStructure();f.previewStructure(-1);f.previewStructure(9);f.previewStructure(1.5);
 assert.equal(f.current.id,id);assert.equal(f.current.preview,null);assert.equal(f.transcript().length,0);
 f.previewStructure(2);assert.equal(f.current.type,'structure');assert.equal(f.transcript().length,0);
 const preview=f.lines({...f.current,pattern:f.current.preview});f.useStructure();
 assert.deepEqual(f.lines(),preview);assert.equal(f.transcript().length,1);assert.equal(f.current.pattern,2);
 f.next();assert.equal(f.current.type,'structure');assert.equal(f.current.part,'proposal');assert.equal(f.current.preview,null);
});

test('all normal speech has a confirmed matching structure selector and context',()=>{
 const f=start();speak(f);f.branch('continue');speak(f);f.chooseDirection('topic');speak(f);
 f.chooseTopic(5);f.chooseSubtopic(2);f.chooseMood(2,'Playground');speak(f);f.branch('finish');speak(f);
 for(const speech of f.transcript()){
   const i=f.nodes.indexOf(speech),selector=f.nodes[i-1];
   assert.equal(selector.type,'structure');assert(selector.confirmed);
   assert.equal(selector.id,speech.selectorId);assert.equal(selector.part,speech.part);
   assert.equal(selector.pattern,speech.pattern);assert.equal(selector.place,speech.place);assert.equal(selector.mood,speech.mood);
 }
});

test('editing a confirmed structure updates one exchange without duplicating or erasing later speech',()=>{
 const f=start();speak(f);f.branch('finish');speak(f);const introduction=f.nodes.find(n=>n.type==='speech'&&n.part==='introduction');
 const future=f.transcript().filter(n=>n.id!==introduction.id).map(n=>[n.id,f.lines(n)]),length=f.nodes.length;
 f.visit(introduction.id);f.editStructure();f.previewStructure(6);f.useStructure();
 assert.equal(f.current.id,introduction.id);assert.equal(f.current.pattern,6);assert.equal(f.nodes.length,length);
 assert.deepEqual(f.transcript().filter(n=>n.id!==introduction.id).map(n=>[n.id,f.lines(n)]),future);
 f.editStructure();f.useStructure();assert.equal(f.nodes.length,length);
});

test('imported legacy wording stays exact and can be changed using the nine built-in structures',()=>{
 const f=start(),rows=parsed(Csv.conversationRecords(f)).slice(-2).map(r=>({...r,sequence:'1',pattern:'Everyday',text:r.speaker==='Parent'?'My saved question?':'My saved answer.'}));
 const g=fresh();Csv.importConversation(g,rows,'replace');g.visit(g.transcript()[0].id);g.editStructure();
 assert.equal(g.stage().candidates.length,10);assert.deepEqual(g.transcript()[0].customLines.map(l=>l.text),rows.map(r=>r.text));
 g.previewStructure(7);g.useStructure();assert.equal(g.current.type,'speech');assert.equal(g.current.customLines,undefined);
 assert.equal(g.stage().candidates[g.current.pattern].label,'Suggestion and agreement');g.next();assert.equal(g.current.type,'structure');
});

test('older Everyday-only library imports retain wording and gain missing structure choices',()=>{
 const oldRows=Csv.libraryRecords(data).filter(r=>r.pattern==='Simple and direct').map(r=>({...r,pattern:'Everyday'}));
 const restored=Csv.importLibrary(data,parsed(oldRows),'replace');
 for(const t of restored)for(const s of t.subtopics)for(const g of s.stages){
   assert.equal(g.candidates.length,10);assert(g.candidates.some(c=>c.label==='Everyday'));
   for(const structure of global.CONVERSATION_STRUCTURES)assert(g.candidates.some(c=>c.label===structure.label));
 }
});
