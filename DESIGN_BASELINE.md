# NEXUS design baseline

This branch starts from the captured Neo 3 presentation layer only.

## Rules

- Preserve the captured DOM and visual hierarchy while components are extracted.
- Do not introduce Laravel, database access, authentication, or API calls yet.
- Keep every page usable from local relative assets.
- Replace static content with application data only after visual parity is approved.
- Rebuild one module at a time and verify desktop and mobile states before continuing.

## Captured pages

- `index.html`
- `leaderboard.html`
- `punishment.html`
- `store.html`
- `faq.html`
- `help.html`
- `tickets.html`
- `skinchanger.html`

The authenticated profile state will be reconstructed from the supplied recordings in a later design phase.
