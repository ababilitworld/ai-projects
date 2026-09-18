/* Conversation state is independent of rendering, themes and browser storage. */
(function (root) {
  'use strict';
  const MOODS = [
    {label:'Neutral',icon:'●',lead:'',reply:''},
    {label:'Happy',icon:'😊',lead:'Happily, ',reply:'I’m happy to say '},
    {label:'Excited',icon:'🤩',lead:'Excitedly, ',reply:'I’m really excited! '},
    {label:'Curious',icon:'🤔',lead:'Curiously, ',reply:'I’m curious too. '},
    {label:'Friendly',icon:'🙂',lead:'In a friendly way, ',reply:'Sure! '},
    {label:'Polite',icon:'🙏',lead:'Politely, ',reply:'Of course. '},
    {label:'Calm',icon:'😌',lead:'Calmly, ',reply:'Okay. '},
    {label:'Surprised',icon:'😮',lead:'With surprise, ',reply:'Oh, wow! '},
    {label:'Confident',icon:'💪',lead:'Confidently, ',reply:'Absolutely. '}
  ];
  const TITLES = {0:'Greeting',4:'Invitation',5:'Response',6:'Change topic',7:'Ending',8:'Goodbye'};
  const STAGE_INDEX = {0:0,4:1,5:2,6:3,7:4,8:5};
  class ConversationFlow {
    constructor(data) { this.data=data; this.reset(); }
    reset() { this.sequence=0; this.nodes=[this.speech(0,0,0),this.node('topic',{t:null,s:null})]; this.cursor=0; }
    node(type,fields={}) { return {id:++this.sequence,type,confirmed:false,...fields}; }
    speech(t,s,g,qaIndex=null) { return this.node('speech',{t,s,g,qaIndex,pattern:0,mood:0}); }
    get current() { return this.nodes[this.cursor]; }
    stage(node=this.current) { const subtopic=this.data[node.t].subtopics[node.s];return node.g===1?subtopic.questionAnswers[node.qaIndex]:subtopic.stages[STAGE_INDEX[node.g]]; }
    title(node) { return node.type==='speech'?(node.g===1?`Question & Answer ${node.qaIndex+1}`:TITLES[node.g]):({topic:'Choose a topic',subtopic:'Choose a subtopic',decision:'Where next?',complete:'Conversation complete'})[node.type]; }
    visit(id) { const i=this.nodes.findIndex(n=>n.id===id); if(i>=0 && (i<=this.cursor || this.nodes.slice(0,i).every(n=>n.confirmed))) this.cursor=i; }
    replaceAfter(nodes) { this.nodes.splice(this.cursor+1,this.nodes.length,...nodes); }
    next() {
      if(this.current.type!=='speech') return;
      this.current.confirmed=true;
      if(this.cursor===this.nodes.length-1) this.nodes.push(this.node('complete'));
      this.cursor++;
    }
    chooseTopic(t) {
      if(this.current.type!=='topic' || !Number.isInteger(t) || !this.data[t]) return;
      if(this.current.t!==t || !this.nodes[this.cursor+1]) this.replaceAfter([this.node('subtopic',{t,s:null})]);
      this.current.t=t; this.current.confirmed=true; this.cursor++;
    }
    chooseSubtopic(s) {
      const n=this.current;
      if(n.type!=='subtopic'||!Number.isInteger(s)||!this.data[n.t].subtopics[s]) return;
      if(n.s!==s || !this.nodes[this.cursor+1]) this.replaceAfter([
        ...this.data[n.t].subtopics[s].questionAnswers.map((_,i)=>this.speech(n.t,s,1,i)),
        this.speech(n.t,s,4),this.speech(n.t,s,5),this.node('decision',{t:n.t,s})
      ]);
      n.s=s; n.confirmed=true; this.cursor++;
    }
    branch(choice) {
      const n=this.current;
      if(n.type!=='decision'||!['subtopic','topic','finish'].includes(choice)) return;
      if(n.choice!==choice || !this.nodes[this.cursor+1]) {
        const next=choice==='subtopic'?[this.node('subtopic',{t:n.t,s:null})]:choice==='topic'?
          [this.speech(n.t,n.s,6),this.node('topic',{t:null,s:null})]:
          [this.speech(n.t,n.s,7),this.speech(n.t,n.s,8),this.node('complete')];
        this.replaceAfter(next);
      }
      n.choice=choice; n.confirmed=true; this.cursor++;
    }
    selectPattern(i) { if(this.current.type==='speech'&&Number.isInteger(i)&&this.stage().candidates[i]) {this.current.pattern=i; delete this.current.customLines;} }
    selectMood(i) { if(this.current.type==='speech'&&Number.isInteger(i)&&MOODS[i]) {this.current.mood=i; delete this.current.customLines;} }
    lines(n=this.current) {
      if(n.customLines) return n.customLines.map(l=>({...l}));
      const mood=MOODS[n.mood];
      const candidate=this.stage(n).candidates[n.pattern];
      const override=candidate.moods?.[mood.label];
      return (override||candidate.lines).map(([speaker,text],i)=>({speaker,text:!override&&n.mood?(i===0?mood.lead:mood.reply)+text:text}));
    }
    transcript() { return this.nodes.filter(n=>n.type==='speech'&&(n.confirmed||n===this.current)); }
  }
  root.ConversationFlow=ConversationFlow; root.CONVERSATION_MOODS=MOODS;
  if(typeof module!=='undefined') module.exports={ConversationFlow,MOODS};
})(typeof window!=='undefined'?window:globalThis);
