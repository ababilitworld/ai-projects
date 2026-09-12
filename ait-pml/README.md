# Real-Time Multi-Topic Conversation Pro V15

Restored hierarchy:
Topic → Subtopic → Conversation Stage → Candidate Structure

9 topics × 9 subtopics × 9 stages × 9 candidates = 6,561 selectable structure states.

Conversation stages:
1. Greeting / Feeling
2. Question
3. Answer
4. Follow-up
5. Invitation
6. Response
7. Change Topic
8. Ending
9. Goodbye

All 9 themes, dynamic dialogue replacement, active highlighting, and Print/Save PDF remain.

## V6 Refinement
- Exact hierarchy titles: Topic → Sub Topic → Conversation Stage
- Live conversation shows only the currently active conversation slice
- Active summary also reflects only the current selection
- Highlighting is limited to active topic, sub topic, stage, candidate structure, and active dialogue lines

## V7 Summary Behavior
- Active Conversation still shows only the currently active stage.
- Active Conversation Summary shows the complete selected Topic + Sub Topic conversation across all 9 Conversation Stages.
- Each stage uses its currently selected Candidate Structure.
- The currently active Conversation Stage label and its Parent/Child lines are highlighted.

## V8 Navigation Styling
- Topic, Sub Topic, and Conversation Stage now share the same card-pill visual language.
- Active Topic and Conversation Stage use the same soft-background + accent-border state as active Sub Topic.
- Candidate Structures remain compact rounded pills because they are secondary choices.

## V9 Mood Layer
Hierarchy is now:
Topic → Sub Topic → Conversation Stage → Mood → Candidate Structure

9 moods:
1. Neutral
2. Happy
3. Excited
4. Curious
5. Friendly
6. Polite
7. Calm
8. Surprised
9. Confident

Mood navigation uses the same responsive card-pill visual language as Topic, Sub Topic, and Conversation Stage.
The active mood modifies the active stage's spoken delivery and is reflected in the Active Conversation and active-stage portion of the Conversation Summary.

## V10 Connected Summary
- Summary now renders all 9 Topics.
- Under every Topic it renders all 9 Sub Topics.
- Under every Sub Topic it renders all 9 Conversation Stages.
- Each stage uses its selected Candidate Structure.
- The currently active Topic/Sub Topic/Conversation Stage stays highlighted.
- Topic-transition separators visually connect one Topic to the next.

## V11 Conversation Summary Lifecycle
The connected summary now follows a natural conversation lifecycle:

Greeting / Feeling — shown once at the beginning.
Connected Topics and Sub Topics — internal stages repeat as needed.
Ending — shown once after all connected topics.
Goodbye — shown once at the very end.

Greeting / Feeling, Ending, and Goodbye are no longer repeated under every Sub Topic in the summary.

## V12 UI Reorganization
- Candidate Structure is now directly below Conversation Stage in the main navigation hierarchy.
- Separate Active Path section was removed.
- Active path is now shown inside the Active Conversation panel.
- Added Previous Mood and Next Mood controls inside Active Conversation.
- Active mood name/icon is shown between mood navigation controls.
- Selected structure details remain in the stage details card.

## V13 Simplification
- Removed Active Stage Details card.
- Active Conversation is now the sole trainer card.
- Candidate Structure remains directly below Conversation Stage in the main hierarchy.
- Mood controls remain inside Active Conversation.
- Connected Conversation Summary corrected:
  - Greeting / Feeling once at the beginning.
  - All connected Topics and Sub Topics with internal conversation stages.
  - Ending once after all connected topics.
  - Goodbye once at the end.
  - Current active stage remains highlighted.

## V14 Summary Scope
Conversation Summary is now scoped to the selected Topic only.

It shows:
- Greeting / Feeling once
- Selected Topic
- All 9 connected Sub Topics of that Topic
- Relevant internal Conversation Stages for each Sub Topic
- Sub Topic transition markers
- Ending once
- Goodbye once
- Active Sub Topic and active Conversation Stage highlighting

## V15 Candidate Structure Styling
Candidate Structure now uses the same card-style navigation design as Sub Topic:
- 9-column responsive horizontal grid
- same minimum width and height
- same 16px rounded corners
- same padding and left alignment
- same hover lift
- same soft active background
- same accent active border
