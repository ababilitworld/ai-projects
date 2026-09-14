# Conversation Terminal

An interactive speaking workspace with a branching roadmap. The original V15 conversation library is preserved in `assets/js/data.js` (9 topics, 81 subtopics, 6,561 patterns / 13,122 dialogue lines). No AI service, account or backend is required.

## Use the workspace

1. Open `index.html` through a static web server. Use **Workspace → Speaking → Dialog**.
2. At **Greeting**, choose a dialogue pattern and mood. The dialogue is generated immediately from these selections. Continue to the topic list.
3. Select a topic and then a subtopic. The context is selected before its dialogue patterns, so every pattern belongs to the right conversation step.
4. Move through **Question → Answer → Follow-up → Invitation → Response**. Each step has independent pattern and mood selections.
5. Choose **Another subtopic**, **Change topic**, or **Wrap up**. Changing topics includes a selectable transition dialogue before opening the topic list.
6. At **Ending** and **Goodbye**, select the wording and mood, then finish. There is one greeting and one goodbye in the normal guided flow.
7. The lower panel contains completed dialogue plus the currently selected speaking step. Future unvisited steps are not included.

Click an available roadmap node to revisit it. Editing a speaking step preserves the route. Choosing a different topic, subtopic or branch replaces the downstream route; the editor displays this effect before the selection. Keeping the same choice retains later steps. Future nodes remain unavailable until preceding steps are completed.

## Messenger conversation layout

The active dialogue and full transcript share the same message component. Parent bubbles align left and Child bubbles align right. Each bubble shows small uppercase speaker, `STAGE`, `PATTERN` and `MOOD` metadata, followed by a small topic/subtopic breadcrumb when applicable, then the larger dialogue text. Metadata uses muted theme colors; the message remains the visual focus.

Topic headers group consecutive exchanges, with subtopic dividers inside each topic. Changing topic inserts a transition divider without sorting or rearranging the conversation. Greeting, ending and goodbye are standalone groups with no topic breadcrumb. The current exchange is outlined; completed messages retain their own pattern and mood. Print styling preserves the grouped bubble layout. CSV fields and import/export behavior are unchanged.

**Settings → Theme** offers nine themes. Only the theme is persisted in browser storage. Conversation paths and imported libraries are session-only: export before refreshing or leaving. Start fresh asks before clearing the path. Print exports only the conversation transcript, without navigation or controls.

## CSV import and export

Open **Workspace → Import / export CSV**.

- **Export library CSV** exports the neutral library and any imported mood-specific overrides. The other moods are generated using the original app's phrasing rules, so those generated variants are not repeated in the library export.
- **Export conversation CSV** exports the exact visible dialogue, ordered by speaking step, with its selected pattern and mood.
- Choose a file to validate it and preview five rows. Nothing changes until **Apply import**.
- Library **Merge** adds records and replaces matching topic/subtopic/step/pattern/mood groups. Library **Replace** rebuilds the whole library. Both start a fresh conversation. Each subtopic requires all nine steps and every pattern requires neutral lines; use Merge for partial updates.
- Conversation **Replace** restores its speaking path. **Merge** appends it to the current transcript (including any repeated greetings/goodbyes). The library stays unchanged. Its referenced topics, subtopics and patterns must already exist; import the corresponding library first.
- Imported conversations retain exact text. Selecting a new pattern or mood regenerates that step from the library. Imported paths contain speaking nodes, not the original topic-choice nodes. A partial path offers continuation; a completed path remains reviewable and printable.

Use an export as the editing template. UTF-8 CSV uses these exact headers in order:

```csv
kind,sequence,topic,subtopic,step,pattern,mood,line_order,speaker,text
```

| Field | Meaning |
| --- | --- |
| kind | `library` or `conversation`; one kind per file |
| sequence | Empty for library; consecutive speaking-step numbers from 1 for conversation |
| topic / subtopic | Exact names; case-sensitive |
| step | Greeting, Question, Answer, Follow-up, Invitation, Response, Change topic, Ending, Goodbye |
| pattern | Pattern label, such as Simple or Warm |
| mood | Neutral, Happy, Excited, Curious, Friendly, Polite, Calm, Surprised, Confident |
| line_order | Consecutive line numbers from 1 within each dialogue |
| speaker / text | Speaker label and dialogue text, including Unicode or multiline text |

Limits: 15 MB, 100,000 rows, 100 lines per dialogue and 10,000 conversation sequences. Missing fields, invalid labels, duplicate lines and malformed quoting are rejected. Failed imports leave active data unchanged. CSV quotes commas, quotes and newlines. Spreadsheet formula-like values receive a reversible apostrophe prefix. Imports run locally in the browser; nothing is uploaded to a server.

## Components

- `model.js`: independent conversation state and branch transitions.
- `csv.js`: CSV codec, validation and library/conversation transformations.
- `app.js`: MessageView shared bubble rendering; RoadmapView, WorkspaceView, TranscriptView, CsvPanel and application wiring.
- `data.js`: original library, separate from layout and application code.
- `css.css`: responsive terminal shell, branch lanes, controls and print layout.

Rendering escapes imported text. Theme storage failures do not block the app. Buttons support keyboard navigation, active selections use `aria-pressed`, current nodes use `aria-current`, and step changes announce status. No package dependencies or build step are needed.

## Validation

```sh
node --test ait-mtc/tests/conversation.test.cjs
node --check ait-mtc/assets/js/app.js
node --check ait-mtc/assets/js/model.js
node --check ait-mtc/assets/js/csv.js
```

The tests cover branch completion, revisiting and truncation, full-library CSV round trips, Unicode/quoting, invalid inputs, mood overrides and exact conversation restore/append. Browser smoke testing covers menus, dialogue controls, responsive layout, CSV preview/apply and theme selection. The repository Pages manifest already includes `ait-mtc`; feature changes are reviewed through a development PR before release promotion.
