# Conversation Terminal

A static speaking workspace with 9 topics and 81 subtopics. Every subtopic now contains practical Parent/Child exchanges organized into **Introduction → Description → Conclusion → Invitation**. No backend, account or AI service is required.

## Conversation flow

1. Choose where the speakers are: Home, School, Playground, Park, Shop, Restaurant, Travelling, or a custom place.
2. Choose a mood before the greeting. Choose a structure, review its paired preview and press **Use this structure** before practising the greeting. Repeat structure selection for the topic proposal.
3. Choose a topic (place-based suggestions are marked; all topics remain available), then a subtopic.
4. Confirm or change the place and explicitly select the subtopic mood. **Keep previous mood** confirms the inherited mood.
5. Before Introduction, each of the two Description exchanges, Conclusion and Invitation, select and confirm a structure. Each exchange includes both speakers. The invitation stays within the current topic.
6. Choose **Continue talking** or **Finish**, select its structure, then practise the corresponding question and response.
7. Continuing offers **New topic** (transition → proposal → topic selection) or **Another subtopic** (transition → subtopic selection in the current topic). Either route requires mood confirmation before the next subtopic.
8. Finishing runs **Finishing → Goodbye → Conversation complete**, with a separate structure choice before Finishing and Goodbye. Transitions also have their own structure choices. The normal guided route has one greeting, and no goodbye until the user finishes.

## Nine conversation structures

Every built-in speaking stage offers the same nine structures, with wording adapted to the stage and subtopic:

1. Simple and direct
2. Open question
3. Choice question
4. Yes/no with detail
5. Preference and reason
6. Experience sharing
7. Situation and response
8. Suggestion and agreement
9. Reflection and next step

Structure cards show the current place, mood and both speakers' wording. Selecting a card only previews it; **Use this structure** confirms the exchange. There is no automatic selection on a new stage. Previews and unvisited speaking stages do not enter the transcript. **Change conversation structure** reopens the selector for the active exchange, preserving the later conversation path.

The mood remains selected throughout a subtopic. The first structure choice after its mood is the Introduction choice, so the app does not ask twice for the same exchange. There are 81 practical scenarios with choices, reasons, experiences, obstacles, solutions and takeaways. Stage-specific sentence forms compile those details into nine alternatives per stage. Shared greetings, proposals, transitions and closing exchanges have separately authored forms. Continue/finish wording preserves the branch already chosen by the learner.

Place means the speakers' setting, not a topic restriction. Mood provides delivery guidance throughout an exchange and natural wording changes in greetings, introductions and some invitations. It does not mechanically prefix every sentence or change factual answers. Context choices are saved on each speaking step, so a later change does not rewrite earlier dialogue.

The roadmap unlocks steps in order. Revisiting and keeping the same choice preserves the route; changing a place, mood, topic, subtopic or branch replaces later steps. Structure changes affect only their exchange. The transcript includes completed speech and the active speech, not unvisited future steps.

## Dataset and components

- `assets/js/content.js`: authored practical scenarios, retaining the original 9 topic names and 81 subtopic names. Each row contains a title and five paired exchanges: Introduction, Description 1, Description 2, Conclusion and Invitation.
- `structures.js`: the nine structure definitions and practical scenario details for all 81 subtopics.
- `structure-dialogues.js`: stage-specific question/answer forms and shared social exchanges. Invitations always stay within the current topic.
- `library.js`: compiles each stage into nine structures and adds mood variants. The original paired exchange remains the Simple and direct choice.
- `model.js`: conversation state, context snapshots and branching rules.
- `csv.js`: local CSV validation and import/export transformations.
- `app.js`: roadmap, setup choices, paired messages and transcript rendering.
- `panels.js`: CSV preview/apply/export panel and app startup.
- `data.js`: unchanged original library archive; no longer loaded by the app.

Nine themes, printing and CSV remain available through the menus. Only theme preference is persisted. **Conversations and imported libraries are session-only; export before refreshing or leaving.** Printing shows the transcript without navigation. Imported strings are escaped before rendering, controls support keyboard navigation, and step changes announce their title.

## CSV

Open **Workspace → Import / export CSV**. Export a template or backup, edit it, then choose a file to validate and preview. Applying a library import starts a fresh conversation. Merge adds or updates matching patterns/moods; Replace rebuilds the library. Every pattern must include Neutral lines. A new-format complete library needs all 13 built-in stages per subtopic, with at least two consecutive Description rounds. Use Merge for partial edits.

Conversation exports retain exact wording, structure (in the existing `pattern` column), mood and place. Replace restores speaking steps; Merge appends them, retaining any repeated greetings or goodbyes. Choice screens themselves are not serialized. A partial import resumes at the next stage's structure selector; a finished conversation remains complete. Unknown topics/subtopics require importing their library first; unknown pattern labels are preserved as imported exchanges. Selecting a different structure replaces that step's imported wording. Merely reopening a selector preserves the text.

Older libraries for the built-in topics gain missing structure choices from the built-in dataset while retaining their imported patterns as additional choices. New custom topics and new stages must provide all nine named structures, including a Neutral version of each, to keep the structure-selection flow complete. Additional imported patterns appear as extra cards and remain available for export.

Headers, in order:

```csv
kind,sequence,topic,subtopic,step,pattern,mood,line_order,speaker,text,place
```

- `kind`: library or conversation; one kind per file.
- `sequence`: empty for library; consecutive speaking-step numbers from 1 for conversation.
- `topic`, `subtopic`, `pattern`: case-sensitive labels; `pattern` stores the selected structure label or an older imported pattern label.
- `step`: Greeting, Topic proposal, Introduction, Description 1, Description 2 (up to 20), Conclusion, Invitation, Continue talking, Change topic, Another subtopic, Choose to finish, Finishing, Goodbye.
- `mood`: Neutral, Happy, Excited, Curious, Friendly, Polite, Calm, Surprised, Confident.
- `line_order`: consecutive numbers starting at 1 within each paired exchange.
- `speaker`, `text`: speaker label and dialogue, including Unicode and multiline text. Each exchange needs at least two speakers.
- `place`: setting, up to 80 characters; blank for library templates. An omitted/blank conversation place defaults to Home.

Older ten-column exports are accepted. Question / Answer / Follow-up (or Question & Answer 1–3) map to Introduction / Description 1 / Description 2; Ending maps to Finishing. Legacy library Response patterns become alternative Invitation patterns prefixed with `Response:`. Missing structural stages in a legacy library are supplied from the built-in library, with its Ending reused as the subtopic Conclusion. Exact legacy conversation text remains unchanged, including standalone Response steps, after which the app offers continue/finish.

Limits: 15 MB, 100,000 rows, 100 lines per exchange, 10,000 conversation sequences. Malformed quoting, duplicates, missing fields and invalid stage/mood labels are rejected before applying changes. CSV formula-like values receive a reversible apostrophe prefix. Imports run in the browser; nothing is uploaded.

## Validation

```sh
node ait-mtc/tests/conversation.test.cjs
node --check ait-mtc/assets/js/app.js
node --check ait-mtc/assets/js/panels.js
node --check ait-mtc/assets/js/model.js
node --check ait-mtc/assets/js/csv.js
node --check ait-mtc/assets/js/structures.js
node --check ait-mtc/assets/js/structure-dialogues.js
```

The tests cover topic preservation, nine distinct paired forms at every stage, all mood renderings, preview/confirmation gates, both continuation branches, finishing, structure edits, context inheritance, CSV roundtrips, legacy migration, Unicode/formula escaping, partial continuation and atomic rejection. Browser testing covers the conversation route and setup controls.
