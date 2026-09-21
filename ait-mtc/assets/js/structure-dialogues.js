/* Stage-specific sentence forms. The order matches CONVERSATION_STRUCTURES.
   Branch responses deliberately preserve the user's continue/finish decision. */
(function(root){
  'use strict';
  const shared={
    greeting:[
      ['Hello! How has your day been so far?','Hello! I had a busy morning, and now I have time to talk.'],
      ['Hello! Would you like to start with how you feel or how your day has been?','Hello! I would like to tell you about my day.'],
      ['Hello! Are you ready for a chat {setting}?','Yes, hello! I have a little time to talk with you.'],
      ['Hello! Would you prefer a short chat or a longer one? Why?','A short chat to begin with, please. I would like time to think.'],
      ['Hello again! What have you been doing since we last talked?','Hello! I have been reading a story and would like to tell you about it.'],
      ['Hello! If you need a moment before we talk, would you let me know?','Hello! Yes, I will. I am ready to begin now.'],
      ['Hello! Shall we take a moment to talk {setting}?','Hello! Yes, let us make time for a chat.'],
      ['Hello! How are you feeling, and what would help us start comfortably?','Hello! I feel ready to talk. Let us take turns and listen.']
    ],
    proposal:[
      ['What would you enjoy discussing today?','I would like to look at the topics and choose an idea.'],
      ['Would you like a suggested topic, or would you prefer to choose from the full list?','I would like to choose from the full list.'],
      ['Would suggestions help you choose? We could discuss {suggestions}.','Yes, they would help. I will compare those with the other topics.'],
      ['Would you prefer something familiar or something new? Why?','Something familiar first, because I have an example to share.'],
      ['What have you done recently that could give us a topic?','I have some everyday experiences to share. Let me choose a matching topic.'],
      ['If you cannot decide on a topic, how could we begin?','We could look at the suggestions and choose one together.'],
      ['Shall we look at {suggestions}, then choose what interests you?','Yes, let us look at the choices before deciding.'],
      ['What would you like to understand better, and which topic could help?','I will choose a topic that lets me ask questions and share an idea.']
    ],
    continue:[
      ['What would you like to do with our conversation now?','I would like to keep talking and explore another idea.'],
      ['Would you like to keep talking or finish for now?','Keep talking, please. I have time for another discussion.'],
      ['Would you like to continue our conversation?','Yes, I would. I am ready to choose what to discuss next.'],
      ['Would you prefer to continue or stop, and why?','I would prefer to continue because I still have ideas to share.'],
      ['How did that discussion feel? Would you like another one?','I enjoyed sharing an example. Yes, I would like to continue.'],
      ['If we have time for another discussion, would you like to continue?','Yes, I have time. Let us keep talking.'],
      ['Shall we keep talking and choose our next direction?','Yes, let us decide what to explore next.'],
      ['What could we do next after that discussion?','We could explore another idea. I would like to continue.']
    ],
    'change-topic':[
      ['What direction would you like to take next?','I would like a new topic. Please show me the choices.'],
      ['Would you like a new topic or another part of {topic}?','A new topic, please.'],
      ['Are you ready to change to a new topic?','Yes, I am. Let us look at the topic list.'],
      ['Would you prefer a new topic, and why?','Yes, I would like to explore a different everyday situation.'],
      ['Did our last discussion give you an idea for a different topic?','Yes, it did. I would like to choose a new topic now.'],
      ['If you want to explore a different subject, what should we do?','Let us return to the topic choices and pick a new subject.'],
      ['Shall we change topics and look at the suggestions again?','Yes, let us choose something different.'],
      ['We have explored this idea. Where would you like to go next?','I would like to move to a new topic and start a fresh discussion.']
    ],
    'change-subtopic':[
      ['Which direction would you like to explore within {topic}?','I would like to look at another subtopic in the same topic.'],
      ['Would you like a different topic or another part of {topic}?','Another part of {topic}, please.'],
      ['Would you like to stay with {topic}?','Yes, but I would like to choose another subtopic.'],
      ['Why would you prefer another subtopic in {topic}?','I still have questions about this topic and want to explore it further.'],
      ['Did this discussion remind you of another part of {topic}?','Yes. Let me look at the other subtopics and choose one.'],
      ['If you want to stay with {topic} but explore a new idea, what could we do?','We could choose another subtopic from the same topic.'],
      ['Shall we explore another part of {topic}?','Yes, show me the subtopics so I can choose.'],
      ['What is our next step if we want to learn more about {topic}?','Choose another subtopic and begin a new discussion about it.']
    ],
    'finish-choice':[
      ['What would you like to do now?','I would like to finish our conversation for now, thank you.'],
      ['Would you like to continue or finish here?','Finish here, please. I am ready to stop for now.'],
      ['Are you ready to finish our conversation?','Yes, thank you. I have enjoyed our time together.'],
      ['Would you prefer to finish now, and why?','Yes. I would like a break and time to think about our discussion.'],
      ['How has the conversation been, and are you ready to finish?','I enjoyed sharing my ideas. I am ready to finish now.'],
      ['If you need to stop for now, how could you say that?','I would like to finish now, please. Thank you for talking with me.'],
      ['Shall we bring our conversation to a close?','Yes, let us finish for now.'],
      ['We have shared several ideas. What would you like to do next?','I would like to finish and think about what we discussed.']
    ],
    finishing:[
      ['What would you like to say as we finish?','Thank you for listening and giving me time to share my ideas.'],
      ['As we finish, would you like to share a takeaway or simply say thank you?','I would like to say thank you for the conversation.'],
      ['Was our conversation useful to you?','Yes, it helped me practise explaining an idea. Thank you.'],
      ['Which part of our conversation did you value most, and why?','I valued taking turns because we both had time to speak.'],
      ['How did it feel to practise this conversation?','I felt more comfortable when I had time to think before replying.'],
      ['If we practise again another day, what could help us?','We could keep taking turns and give each other time to answer.'],
      ['Shall we finish by thanking each other for listening?','Yes. Thank you for listening to me today.'],
      ['What went well, and what could you practise next time?','We listened to each other. Next time I could explain my reasons more clearly.']
    ],
    goodbye:[
      ['Before we go, what would you like to say?','Thank you for the chat. Goodbye, and take care!'],
      ['Would you like to say “goodbye” or “see you next time”?','See you next time! Take care.'],
      ['Shall we say goodbye for now?','Yes. Goodbye, and thank you for talking with me.'],
      ['Would you prefer to say “see you next time”?','Yes, because I hope we can talk again. See you next time!'],
      ['It was good talking with you today. Goodbye!','I enjoyed our chat too. Goodbye!'],
      ['If we do not meet again today, take care. Goodbye!','You too. See you another day!'],
      ['Let us say goodbye for now. Take care!','Goodbye! Take care too.'],
      ['We have finished for today. Until our next conversation, take care!','Thank you. I will remember what we practised. Goodbye!']
    ]
  };

  function topical(part,c){
    const {focus,a,b,reason,experience,obstacle,solution,action,takeaway}=c;
    const forms={
      introduction:[
        [`What would you like to tell me about ${focus}?`,`I would like to ${a}. ${reason}`],
        [`Would you rather talk about how to ${a} or how to ${b}?`,`Let us talk about how to ${a}.`],
        [`Is ${focus} something you would like to discuss?`,`Yes. ${reason}`],
        [`Which part of ${focus} interests you most, and why?`,`I would like to ${a}. ${reason}`],
        [`What experience could you share about ${focus}?`,experience],
        [`Imagine ${obstacle}. What would you do?`,solution],
        [`Let us talk about ${focus}. Shall we start with an example?`,`Yes. ${experience}`],
        [`What do you already know about ${focus}, and what would you like to explore?`,`${takeaway} I would like to ${action}.`]
      ],
      'description-1':[
        [`What have you noticed about ${focus}?`,`${experience} ${reason}`],
        [`Would you rather ${a} or ${b}?`,`I would rather ${a}. ${reason}`],
        [`Have you had an experience related to ${focus}?`,`Yes. ${experience}`],
        [`Why does the idea of ${focus} matter to you?`,reason],
        [`Can you describe a time when you explored ${focus}?`,experience],
        [`If ${obstacle}, what could you try first?`,solution],
        [`Could we ${action} to work through your idea?`,`Yes, let us talk through it one step at a time.`],
        [`What have you tried, and what could you try next?`,`${experience} Next, we could ${action}.`]
      ],
      'description-2':[
        [`What would help if ${obstacle}?`,solution],
        [`If ${obstacle}, would you ask for help or try a different approach?`,`I would ask for help if I needed it. ${solution}`],
        [`Could we find a solution if ${obstacle}?`,`Yes. ${solution}`],
        [`Would you prefer help or time to think if ${obstacle}? Why?`,`Time to think first, so I can explain my idea. ${solution}`],
        [`What idea from your experience would you remember next time?`,takeaway],
        [`If your first idea did not work, how could you ask for help?`,`Could you help me ${action}, please?`],
        [`Shall we compare the ideas of how to ${a} and how to ${b}?`,`Yes. I would start with how to ${a}. ${reason}`],
        [`What needs more discussion, and how could we explore it?`,`We could discuss what to do if ${obstacle}. ${solution}`]
      ],
      conclusion:[
        [`How would you sum up our discussion about ${focus}?`,takeaway],
        [`Which should we remember: how to ${a}, or what to do if ${obstacle}?`,`I would remember what to do if ${obstacle}. ${solution}`],
        [`Have we found a useful idea about ${focus}?`,`Yes. ${takeaway}`],
        [`Which idea about ${focus} would you keep, and why?`,`${takeaway} ${reason}`],
        [`What can we learn from the experience you shared?`,takeaway],
        [`If ${obstacle} in the future, what could you do?`,solution],
        [`Shall we keep this lesson: “${takeaway}”?`,`Yes, that sums up a useful idea from our discussion.`],
        [`What have we learned, and what could we explore next?`,`${takeaway} Next, we could ${action}.`]
      ],
      invitation:[
        [`How would you like us to keep exploring ${focus}?`,`We could ${action} together.`],
        [`Shall we ${action} together, or would you like to explain your idea first?`,`Let us ${action} together.`],
        [`Would you like to ${action} with me?`,`Yes, please. We can take turns sharing our ideas.`],
        [`Would you rather ${action} together or start on your own? Why?`,`Together, please. We can listen to each other’s ideas.`],
        [`Could we ${action} and use what you learned from your experience?`,`Yes. ${takeaway}`],
        [`If ${obstacle}, could we ${action} together?`,`Yes, we could. ${solution}`],
        [`Shall we ${action} together?`,`Yes, let us start with one small step.`],
        [`Now that we have discussed ${focus}, would you like to ${action} with me?`,`Yes. That would help us explore this idea further.`]
      ]
    };
    return forms[part]||forms['description-2'];
  }
  root.buildConversationStructures=(stage,scenario)=>{
    const direct=stage.candidates[0].lines;
    const rest=shared[stage.slug]||topical(stage.slug,scenario);
    return [direct,...rest.map(([q,a])=>[['Parent',q],['Child',a]])].map((lines,i)=>({
      label:root.CONVERSATION_STRUCTURES[i].label,structure:root.CONVERSATION_STRUCTURES[i].id,lines,
      pattern:lines[0][1],response:lines[1][1],moods:{}
    }));
  };
})(typeof window!=='undefined'?window:globalThis);
