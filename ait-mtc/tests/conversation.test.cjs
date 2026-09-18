const test=require('node:test');
const assert=require('node:assert/strict');
const fs=require('node:fs');
const path=require('node:path');
const vm=require('node:vm');
const {ConversationFlow}=require('../assets/js/model.js');
const Csv=require('../assets/js/csv.js');
const context={window:{}};
vm.runInNewContext(fs.readFileSync(path.join(__dirname,'../assets/js/data.js'),'utf8'),context);
vm.runInNewContext(fs.readFileSync(path.join(__dirname,'../assets/js/library.js'),'utf8'),context);
const data=JSON.parse(JSON.stringify(context.window.CONVERSATION_DATA));
const flow=()=>new ConversationFlow(data);
function firstTopic(f){f.next();f.chooseTopic(0);f.chooseSubtopic(0);}
function finishSubtopic(f){for(let i=0;i<f.data[f.current.t].subtopics[f.current.s].questionAnswers.length+2;i++)f.next();}
test('branching has one greeting, keeps completed dialogue and closes with selected ending/goodbye',()=>{
  const f=flow();f.selectPattern(1);f.selectMood(2);firstTopic(f);f.selectPattern(2);f.selectMood(1);finishSubtopic(f);
  f.branch('subtopic');f.chooseSubtopic(1);finishSubtopic(f);f.branch('topic');assert.equal(f.current.g,6);f.next();f.chooseTopic(1);f.chooseSubtopic(2);finishSubtopic(f);f.branch('finish');assert.equal(f.current.g,7);f.next();assert.equal(f.current.g,8);f.selectPattern(4);f.next();
  assert.equal(f.current.type,'complete');assert.equal(f.transcript().filter(n=>n.g===0).length,1);assert.equal(f.transcript().filter(n=>n.g===8).length,1);assert.equal(f.nodes[0].pattern,1);assert.equal(f.nodes[0].mood,2);assert.equal(f.transcript().at(-1).pattern,4);
});
test('editing pattern or mood preserves the route; changing topic replaces only later steps',()=>{
  const f=flow();firstTopic(f);f.next();const length=f.nodes.length,question=f.nodes[3];f.visit(question.id);f.selectMood(4);assert.equal(f.nodes.length,length);assert.equal(f.nodes[4].g,1);assert.equal(f.nodes[4].qaIndex,1);
  f.visit(f.nodes[1].id);f.chooseTopic(2);assert.equal(f.nodes.length,3);assert.equal(f.nodes[0].confirmed,true);assert.equal(f.current.t,2);assert.equal(f.current.type,'subtopic');
});
test('future nodes cannot be visited before earlier speaking steps are completed',()=>{
  const f=flow();firstTopic(f);const current=f.current;f.visit(f.nodes.at(-1).id);assert.equal(f.current,current);f.selectMood(-1);f.selectPattern(999);assert.equal(f.current.pattern,0);assert.equal(f.current.mood,0);
});
test('every subtopic has at least three linked Question & Answer rounds',()=>{
  assert.ok(data.every(topic=>topic.subtopics.every(subtopic=>subtopic.questionAnswers.length>=3)));
  const f=flow();firstTopic(f);
  assert.equal(f.title(f.current),'Question & Answer 1');
  const before=f.lines();f.selectPattern(1);const after=f.lines();
  assert.notEqual(after[0].text,before[0].text);
  assert.notEqual(after[1].text,before[1].text);
  assert.deepEqual(after.map(line=>line.speaker),['Parent','Child']);
  f.next();assert.equal(f.title(f.current),'Question & Answer 2');
  f.next();assert.equal(f.title(f.current),'Question & Answer 3');
  f.next();assert.equal(f.title(f.current),'Invitation');
});
test('a fourth Question & Answer round can be imported without splitting its reply',()=>{
  const source=Csv.libraryRecords(data).filter(row=>row.topic===data[0].title&&row.subtopic===data[0].subtopics[0].title&&row.step==='Question & Answer 3'&&row.pattern==='What');
  assert.equal(source.length,2);
  const extra=source.map(row=>({...row,step:'Question & Answer 4'}));
  const extended=Csv.importLibrary(data,Csv.parse(Csv.stringify(extra)).records,'merge');
  assert.equal(extended[0].subtopics[0].questionAnswers.length,4);
  const f=new ConversationFlow(extended);firstTopic(f);
  f.next();f.next();f.next();
  assert.equal(f.title(f.current),'Question & Answer 4');
  assert.deepEqual(f.lines().map(line=>line.speaker),['Parent','Child']);
});
test('full supplied library round trips with identical dialogue lines',()=>{
  const rows=Csv.libraryRecords(data),parsed=Csv.parse(Csv.stringify(rows));
  assert.equal(parsed.records.length,13122);
  const restored=Csv.importLibrary(data,parsed.records,'replace');
  assert.deepEqual(Csv.libraryRecords(restored),rows);
});
test('CSV supports commas, quotes, multiline, Bengali and formula-safe reversible text',()=>{
  const row=Csv.libraryRecords(data)[0];
  for(const text of ['Hello, "friend"!\nকেমন আছ?','=SUM(A1:A2)',"'quoted",'@name','-1','\tvalue']){
    const csv=Csv.stringify([{...row,text}]);assert.equal(Csv.parse(csv).records[0].text,text);
    if(text.startsWith('='))assert.ok(csv.includes("'=SUM"));
  }
});
test('malformed, duplicate, missing and mixed rows are rejected',()=>{
  const row=Csv.libraryRecords(data)[0];
  assert.throws(()=>Csv.parse('bad,headers\n1,2'));
  assert.throws(()=>Csv.parse(Csv.stringify([row,row])),/duplicate/);
  assert.throws(()=>Csv.parse(Csv.stringify([{...row,line_order:2}])),/consecutive/);
  assert.throws(()=>Csv.parse(Csv.stringify([{...row,mood:'Unknown'}])),/unknown/);
  assert.throws(()=>Csv.parse(Csv.stringify([row,{...row,kind:'conversation',sequence:1}])),/one kind/);
  const qa=Csv.libraryRecords(data).find(row=>row.step==='Question & Answer 1');
  assert.throws(()=>Csv.parse(Csv.stringify([qa])),/both speakers/);
  assert.throws(()=>Csv.parse('"unterminated'),/Unclosed/);
});
test('legacy Question, Answer and Follow-up CSV labels map to paired rounds',()=>{
  const qa=Csv.libraryRecords(data).filter(row=>row.topic===data[0].title&&row.subtopic===data[0].subtopics[0].title&&row.step==='Question & Answer 1'&&row.pattern==='Simple');
  const legacy=qa.map(row=>({...row,step:'Question'}));
  const merged=Csv.importLibrary(data,Csv.parse(Csv.stringify(legacy)).records,'merge');
  assert.deepEqual(merged[0].subtopics[0].questionAnswers[0].candidates[0].lines,data[0].subtopics[0].questionAnswers[0].candidates[0].lines);
});
test('partial library merge supports exact mood overrides; incomplete replacement is atomic',()=>{
  const original=JSON.stringify(data),rows=Csv.libraryRecords(data).slice(0,2).map(r=>({...r,mood:'Happy',text:'Custom '+r.speaker}));
  const result=Csv.importLibrary(data,rows,'merge'),f=new ConversationFlow(result);f.selectMood(1);assert.equal(f.lines()[0].text,'Custom Parent');
  assert.throws(()=>Csv.importLibrary(data,rows,'replace'),/at least three paired Question & Answer rounds/);assert.equal(JSON.stringify(data),original);
});
test('selected conversation round trip preserves order, mood, text and supports append',()=>{
  const f=flow();f.selectMood(2);firstTopic(f);f.selectPattern(2);f.selectMood(4);f.next();
  const rows=Csv.conversationRecords(f),restored=flow();Csv.importConversation(restored,Csv.parse(Csv.stringify(rows)).records,'replace');
  assert.deepEqual(Csv.conversationRecords(restored).slice(0,rows.length),rows);
  assert.equal(restored.current.g,1);assert.equal(restored.current.qaIndex,2);
  const before=restored.transcript().length;Csv.importConversation(restored,rows,'merge');assert.equal(restored.transcript().length,before+f.transcript().length+1);
  const snapshot=JSON.stringify(restored.nodes);assert.throws(()=>Csv.importConversation(restored,rows.map(r=>({...r,topic:'Unknown'})),'replace'),/unknown/);assert.equal(JSON.stringify(restored.nodes),snapshot);
});
