/* Adapt the preserved V15 source into paired, repeatable Question & Answer rounds. */
(function(root){
  'use strict';
  root.CONVERSATION_DATA.forEach(topic=>topic.subtopics.forEach(subtopic=>{
    if(Array.isArray(subtopic.questionAnswers))return;
    const original=subtopic.stages;
    subtopic.questionAnswers=original.slice(1,4).map((round,index)=>({
      id:index+1,
      title:`Question & Answer ${index+1}`,
      slug:`question-answer-${index+1}`,
      candidates:round.candidates
    }));
    subtopic.stages=[original[0],...original.slice(4)];
  }));
})(typeof window!=='undefined'?window:globalThis);
