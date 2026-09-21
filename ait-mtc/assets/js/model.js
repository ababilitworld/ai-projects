/* Explicit choices own place and mood. Speaking nodes keep context snapshots. */
(function(root){
  'use strict';
  const MOODS=['Neutral','Happy','Excited','Curious','Friendly','Polite','Calm','Surprised','Confident'].map((label,i)=>({label,icon:['●','😊','🤩','🤔','🙂','🙏','😌','😮','💪'][i]}));
  const PLACES=[
    {label:'Home',setting:'at home',topics:['Family & Home','Daily Life & Routine','Toys & Play']},
    {label:'School',setting:'at school',topics:['School & Learning','Games & Sports']},
    {label:'Playground',setting:'at the playground',topics:['Games & Sports','Toys & Play']},
    {label:'Park',setting:'at the park',topics:['Games & Sports','Travel & Places','Toys & Play']},
    {label:'Shop',setting:'at the shop',topics:['Shopping & Choices','Food & Drinks']},
    {label:'Restaurant',setting:'at the restaurant',topics:['Food & Drinks','Family & Home']},
    {label:'Travelling',setting:'on our journey',topics:['Travel & Places','Cartoons & Stories']}
  ];
  const SUBPARTS=['introduction','conclusion','invitation'];
  const hasTopic=n=>n.t!=null&&n.s!=null&&(SUBPARTS.includes(n.part)||n.part?.startsWith('description-'));
  class ConversationFlow {
    constructor(data){this.data=data;this.reset();}
    node(type,fields={}){return {id:++this.sequence,type,confirmed:false,...fields};}
    speech(part,context={}){return this.node('speech',{t:0,s:0,pattern:0,mood:0,place:'Home',...context,part});}
    reset(){this.sequence=0;this.nodes=[this.node('place',{place:'Home',mood:0})];this.cursor=0;}
    get current(){return this.nodes[this.cursor];}
    context(n=this.current){return {t:n.t??0,s:n.s??0,place:n.place||'Home',mood:n.mood??0};}
    stage(n=this.current){return n.importedStage||this.data[n.t??0]?.subtopics[n.s??0]?.stages.find(g=>g.slug===n.part);}
    title(n){return n.type==='speech'?this.stage(n)?.title||n.part:({place:'Choose a place',mood:n.scope==='greeting'?'Choose greeting mood':'Place & subtopic mood',topic:'Choose a topic',subtopic:'Choose a subtopic',decision:'Continue or finish?',direction:'Choose your direction',complete:'Conversation complete'})[n.type];}
    visit(id){const i=this.nodes.findIndex(n=>n.id===id);if(i>=0&&(i<=this.cursor||this.nodes.slice(0,i).every(n=>n.confirmed)))this.cursor=i;}
    replaceAfter(nodes){this.nodes.splice(this.cursor+1,this.nodes.length,...nodes);}
    advance(){this.current.confirmed=true;this.cursor++;}
    choosePlace(place){
      if(this.current.type!=='place'||!this.validPlace(place))return;
      place=place.trim();const n=this.current;
      if(n.place!==place||!this.nodes[this.cursor+1])this.replaceAfter([this.node('mood',{scope:'greeting',place,mood:0})]);
      n.place=place;this.advance();
    }
    validPlace(place){return typeof place==='string'&&place.trim().length>0&&place.trim().length<=80&&!/[\x00-\x1f]/.test(place);}
    chooseMood(mood,place=this.current.place){
      const n=this.current;if(n.type!=='mood'||!Number.isInteger(mood)||!MOODS[mood]||!this.validPlace(place))return;
      place=place.trim();const context={...this.context(),mood,place};
      if(n.mood!==mood||n.place!==place||!this.nodes[this.cursor+1]){
        const next=n.scope==='greeting'?[this.speech('greeting',context),this.speech('proposal',context),this.node('topic',{...context,t:null,s:null})]:[
          ...this.subtopicParts(n.t,n.s).map(part=>this.speech(part,context)),this.node('decision',context)
        ];this.replaceAfter(next);
      }
      n.mood=mood;n.place=place;this.advance();
    }
    subtopicParts(t,s){return ['introduction',...this.data[t].subtopics[s].stages.filter(g=>/^description-\d+$/.test(g.slug)).sort((a,b)=>Number(a.slug.split('-')[1])-Number(b.slug.split('-')[1])).map(g=>g.slug),'conclusion','invitation'];}
    chooseTopic(t){const n=this.current;if(n.type!=='topic'||!Number.isInteger(t)||!this.data[t])return;
      if(n.t!==t||!this.nodes[this.cursor+1])this.replaceAfter([this.node('subtopic',{...this.context(),t,s:null})]);
      n.t=t;this.advance();}
    chooseSubtopic(s){const n=this.current;if(n.type!=='subtopic'||!Number.isInteger(s)||!this.data[n.t]?.subtopics[s])return;
      if(n.s!==s||!this.nodes[this.cursor+1])this.replaceAfter([this.node('mood',{...this.context(),s,scope:'subtopic'})]);
      n.s=s;this.advance();}
    branch(choice){
      const n=this.current;if(n.type!=='decision'||!['continue','finish'].includes(choice))return;
      if(n.choice!==choice||!this.nodes[this.cursor+1]){
        const c=this.context();this.replaceAfter(choice==='continue'?[this.speech('continue',c),this.node('direction',c)]:[this.speech('finish-choice',c),this.speech('finishing',c),this.speech('goodbye',c),this.node('complete',c)]);
      }n.choice=choice;this.advance();
    }
    chooseDirection(choice){
      const n=this.current;if(n.type!=='direction'||!['topic','subtopic'].includes(choice))return;
      if(n.choice!==choice||!this.nodes[this.cursor+1]){
        const c=this.context();this.replaceAfter(choice==='topic'?[this.speech('change-topic',c),this.speech('proposal',c),this.node('topic',{...c,t:null,s:null})]:[this.speech('change-subtopic',c),this.node('subtopic',{...c,s:null})]);
      }n.choice=choice;this.advance();
    }
    next(){if(this.current.type!=='speech')return;if(this.cursor===this.nodes.length-1)this.replaceAfter(this.continuation(this.current));this.advance();}
    continuation(n){
      const c=this.context(n),p=n.part,parts=this.subtopicParts(c.t,c.s),i=parts.indexOf(p);
      if(i>=0)return [...parts.slice(i+1).map(part=>this.speech(part,c)),this.node('decision',c)];
      if(p==='goodbye')return [this.node('complete',c)];
      if(p==='finishing')return [this.speech('goodbye',c),this.node('complete',c)];
      if(p==='finish-choice')return [this.speech('finishing',c),this.speech('goodbye',c),this.node('complete',c)];
      if(p==='continue')return [this.node('direction',c)];
      if(p==='change-subtopic')return [this.node('subtopic',{...c,s:null})];
      if(p==='proposal')return [this.node('topic',{...c,t:null,s:null})];
      if(['greeting','change-topic'].includes(p))return [this.speech('proposal',c),this.node('topic',{...c,t:null,s:null})];
      return [this.node('decision',c)];
    }
    selectPattern(i){if(this.current.type==='speech'&&Number.isInteger(i)&&this.stage()?.candidates[i]){this.current.pattern=i;delete this.current.customLines;}}
    suggestions(place=this.current.place){return (PLACES.find(p=>p.label===place)?.topics||this.data.slice(0,3).map(t=>t.title)).filter(title=>this.data.some(t=>t.title===title));}
    lines(n=this.current){
      if(n.customLines)return n.customLines.map(line=>({...line}));
      const candidate=this.stage(n).candidates[n.pattern],mood=MOODS[n.mood].label;
      const vars={setting:PLACES.find(p=>p.label===n.place)?.setting||'here',topic:this.data[n.t].title.toLowerCase(),suggestions:this.suggestions(n.place).map(t=>t.toLowerCase()).join(', ')||'a topic you enjoy'};
      return (candidate.moods?.[mood]||candidate.lines).map(([speaker,text])=>({speaker,text:text.replace(/\{(setting|topic|suggestions)\}/g,(_,key)=>vars[key])}));
    }
    transcript(){return this.nodes.filter(n=>n.type==='speech'&&(n.confirmed||n===this.current));}
  }
  root.ConversationFlow=ConversationFlow;root.CONVERSATION_MOODS=MOODS;root.CONVERSATION_PLACES=PLACES;root.conversationHasTopic=hasTopic;
  if(typeof module!=='undefined')module.exports={ConversationFlow,MOODS,PLACES,hasTopic};
})(typeof window!=='undefined'?window:globalThis);
