/* Compile the authored library into named conversation sections. */
(function(root){
  'use strict';
  const pair=(question,answer)=>[['Parent',question],['Child',answer]];
  const stage=(slug,title,question,answer,label='Everyday')=>({slug,title,candidates:[{label,lines:pair(question,answer)}]});
  const globalStages=()=>[
    stage('greeting','Greeting','Hello! It is nice to have a moment to talk {setting}. How are you?','I am well, thank you. How are you?'),
    stage('proposal','Topic proposal','What would you like to talk about? We could discuss {suggestions}, or choose something else.','Let me choose a topic that interests me.'),
    stage('continue','Continue talking','Would you like to keep talking, or shall we finish?','I would like to keep talking.'),
    stage('change-topic','Change topic','Would you like a new topic or another part of this topic?','Let us choose a new topic.'),
    stage('change-subtopic','Another subtopic','Would you like a new topic or another part of this topic?','I would like to explore another part of {topic}.'),
    stage('finish-choice','Choose to finish','Would you like to keep talking, or shall we finish?','I am ready to finish now, thank you.'),
    stage('finishing','Finishing','Thank you for sharing your ideas. Did you enjoy our conversation?','Yes, I enjoyed talking with you.'),
    stage('goodbye','Goodbye','See you next time. Take care!','You too. Goodbye!')
  ];
  const directions={Neutral:'Speak in your usual voice and listen to the reply.',Happy:'Let your voice sound warm and cheerful.',Excited:'Show enthusiasm while leaving room for the other speaker.',Curious:'Ask with interest and listen closely to the details.',Friendly:'Use a welcoming voice and an easy pace.',Polite:'Speak respectfully and give the other person time.',Calm:'Use a gentle voice and an unhurried pace.',Surprised:'Show interest or surprise without changing the facts.',Confident:'Speak clearly and steadily; avoid rushing.'};
  const openings={Happy:'I am glad we have time to talk. ',Excited:'I have been looking forward to this! ',Curious:'I would like to hear what you think. ',Friendly:'Let us share some ideas. ',Polite:'If you do not mind, I would like to ask you something. ',Calm:'We can take our time. ',Surprised:'There is more to talk about than I expected! ',Confident:'I am ready to explore this with you. '};
  root.CONVERSATION_DATA=root.CONVERSATION_SEEDS.map((topic,t)=>({id:t+1,title:topic.title,subtopics:topic.subtopics.map((row,s)=>{
    if(row.length!==11)throw Error(`Invalid authored dialogue: ${topic.title} / ${row[0]}`);
    const [title,...lines]=row;
    const stages=[...globalStages(),stage('introduction','Introduction',lines[0],lines[1]),stage('description-1','Description 1',lines[2],lines[3]),stage('description-2','Description 2',lines[4],lines[5]),stage('conclusion','Conclusion',lines[6],lines[7]),stage('invitation','Invitation',lines[8],lines[9])];
    for(const g of stages)for(const c of g.candidates){
      c.pattern=c.lines[0][1];c.response=c.lines[1][1];c.moods={};
      // Mood alters social wording where it fits. Factual exchanges retain their
      // meaning and use the delivery direction, rather than adverb prefixes.
      if(['greeting','introduction'].includes(g.slug))for(const [mood,opening]of Object.entries(openings)){
        c.moods[mood]=c.lines.map(line=>[...line]);c.moods[mood][0][1]=opening+c.lines[0][1];
      }
      if(g.slug==='invitation')for(const mood of ['Happy','Excited','Friendly','Confident']){
        c.moods[mood]=c.lines.map(line=>[...line]);c.moods[mood][1][1]=c.lines[1][1].replace(/^Yes[,!.]?\s*/,mood==='Confident'?'Certainly. ':'Yes! ');
      }
      if(g.slug==='greeting'){
        const replies={Happy:'I feel happy today. It is good to see you!',Excited:'I am excited to talk with you!',Curious:'I am curious about what we will discuss.',Friendly:'I am doing well. It is nice to see you too.',Polite:'I am well, thank you for asking. How are you?',Calm:'I feel calm and ready for a quiet conversation.',Surprised:'Oh, hello! I did not expect a chat, but I would like one.',Confident:'I feel ready to share my ideas. How are you?'};
        for(const [mood,reply]of Object.entries(replies))c.moods[mood][1][1]=reply;
      }
    }
    return {id:s+1,title,stages};
  })}));
  root.CONVERSATION_DIRECTIONS=directions;
})(typeof window!=='undefined'?window:globalThis);
