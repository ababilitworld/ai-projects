# Conversation Terminal

A static speaking workspace with 9 topics and 81 subtopics. Every subtopic now contains practical Parent/Child exchanges organized into **Introduction → Description → Conclusion → Invitation**. No backend, account or AI service is required.

## Conversation flow

1. Choose where the speakers are: Home, School, Playground, Park, Shop, Restaurant, Travelling, or a custom place.
2. Choose a mood before the greeting, then practise the greeting and topic proposal.
3. Choose a topic (place-based suggestions are marked; all topics remain available), then a subtopic.
4. Confirm or change the place and explicitly select the subtopic mood. **Keep previous mood** confirms the inherited mood.
5. Practise Introduction, two Description exchanges, Conclusion and Invitation. Each exchange includes both speakers. The invitation stays within the current topic.
6. Choose **Continue talking** or **Finish**, then practise the corresponding question and response.
7. Continuing offers **New topic** (transition → proposal → topic selection) or **Another subtopic** (transition → subtopic selection in the current topic). Either route requires mood confirmation before the next subtopic.
8. Finishing runs **Finishing → Goodbye → Conversation complete**. The normal guided route has one greeting, and no goodbye until the user finishes.

Place means the speakers' setting, not a topic restriction. Mood provides delivery guidance throughout an exchange and natural wording changes in greetings, introductions and some invitations. It does not mechanically prefix every sentence or change factual answers. Context choices are saved on each speaking step, so a later change does not rewrite earlier dialogue.

The roadmap unlocks steps in order. Revisiting and keeping the same choice preserves the route; changing a place, mood, topic, subtopic or branch replaces later steps. Pattern changes affect only their exchange. The transcript includes completed speech and the active speech, not unvisited future steps.

## Dataset and components

- `assets/js/content.js`: authored practical scenarios, retaining the original 9 topic names and 81 subtopic names. Each row contains a title and five paired exchanges: Introduction, Description 1, Description 2, Conclusion and Invitation.
- `library.js`: compiles scenarios into named stages, adds shared greeting/transition/closing exchanges and mood variants. Each built-in stage has an Everyday pattern; imports can add alternatives and Description rounds.
- `model.js`: conversation state, context snapshots and branching rules.
- `csv.js`: local CSV validation and import/export transformations.
- `app.js`: roadmap, setup choices, paired messages and transcript rendering.
- `panels.js`: CSV preview/apply/export panel and app startup.
- `data.js`: unchanged original library archive; no longer loaded by the app.

Nine themes, printing and CSV remain available through the menus. Only theme preference is persisted. **Conversations and imported libraries are session-only; export before refreshing or leaving.** Printing shows the transcript without navigation. Imported strings are escaped before rendering, controls support keyboard navigation, and step changes announce their title.

## CSV

Open **Workspace → Import / export CSV**. Export a template or backup, edit it, then choose a file to validate and preview. Applying a library import starts a fresh conversation. Merge adds or updates matching patterns/moods; Replace rebuilds the library. Every pattern must include Neutral lines. A new-format complete library needs all 13 built-in stages per subtopic, with at least two consecutive Description rounds. Use Merge for partial edits.

Conversation exports retain exact wording, pattern, mood and place. Replace restores speaking steps; Merge appends them, retaining any repeated greetings or goodbyes. Choice screens themselves are not serialized. A partial import resumes from its final speaking stage; a finished conversation remains complete. Unknown topics/subtopics require importing their library first; unknown pattern labels are preserved as imported exchanges. Choosing a library pattern replaces that step's imported wording.

Headers, in order:

```csv
kind,sequence,topic,subtopic,step,pattern,mood,line_order,speaker,text,place
```

- `kind`: library or conversation; one kind per file.
- `sequence`: empty for library; consecutive speaking-step numbers from 1 for conversation.
- `topic`, `subtopic`, `pattern`: case-sensitive labels.
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
```

The tests cover topic preservation, paired stages, setup gates, both continuation branches, finishing, route edits, context inheritance, CSV roundtrips, legacy migration, Unicode/formula escaping, partial continuation and atomic rejection. Browser testing covers the full conversation route and setup controls.
