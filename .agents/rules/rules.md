# Agent Rules

## 1. Project Scope

EduQuiz is a Laravel Mini Quiz LMS for a recruitment pre-test.

Use:

* Laravel
* MySQL
* Blade Template
* Laravel Breeze Blade
* MVC
* Simple admin/student role

Do not use:

* React
* Vue
* Inertia
* API-only architecture
* Spatie Permission
* Extra packages unless the user explicitly approves

## 2. Agent Workflow

Before coding any phase, read these files in order:

1. `.agents/workflow/plan.md`
2. `.agents/workflow/progress.md`
3. `.agents/workflow/decisions.md`
4. `.agents/workflow/commands.md`
5. `.agents/rules/rules.md`
6. Relevant `.agents/skills/*.md` files if needed
7. `.agents/workflow/test-log.md`

Then:

1. Identify the first incomplete phase.
2. Choose the smallest useful set of skills.
3. Implement only the current phase or requested slice.
4. Review the change.
5. Run the narrowest useful checks.
6. Update `.agents/workflow/progress.md`.
7. Update `.agents/workflow/test-log.md` if checks were run.
8. Update `.agents/workflow/plan.md` only when phase checklist status changes.
9. Continue only if there is no blocking error and the user asked for continued work.

## 3. Skill Usage Rules

Use skills only when they improve quality or reduce mistakes.

Do not load too many skills at once. Prefer 1-3 skills per phase.

Skills should never expand scope beyond the pre-test requirements.

### Skill Selection Matrix

Planning:

* `using-agent-skills`
* `planning-and-task-breakdown`
* `spec-driven-development`
* `incremental-implementation`

Fullstack workflow:

* `fullstack-delivery-workflow`
* `incremental-implementation`

Database, migration, relationships:

* `database-data-modeling`

Backend Laravel logic:

* `backend-api-engineering`

Blade UI:

* `frontend-application-engineering`
* `frontend-ui-engineering`

Review:

* `code-review-and-quality`
* `code-simplification`

Debugging:

* `debugging-and-error-recovery`

Testing:

* `test-driven-development`
* `unit-integration-testing`

Security/auth/authorization:

* `security-and-hardening`
* `security-best-practices`

Browser/UI testing:

* `playwright`
* `playwright-interactive`

Git:

* `git-workflow-and-versioning`

Final shipping:

* `shipping-and-launch`

Performance:

* `performance-optimization`

Deprecation/migration:

* `deprecation-and-migration`

## 4. Skill Usage by EduQuiz Phase

Phase 1: Project setup

* `fullstack-delivery-workflow`
* `debugging-and-error-recovery`

Phase 2: Role admin/student

* `backend-api-engineering`
* `security-and-hardening`
* `code-review-and-quality`

Phase 3: Core database schema

* `database-data-modeling`
* `code-review-and-quality`

Phase 4: Admin Course CRUD

* `backend-api-engineering`
* `frontend-ui-engineering`
* `code-review-and-quality`

Phase 5: Admin Quiz CRUD

* `backend-api-engineering`
* `database-data-modeling`
* `frontend-ui-engineering`

Phase 6: Admin Question & Answer CRUD

* `backend-api-engineering`
* `database-data-modeling`
* `frontend-ui-engineering`
* `security-and-hardening`

Phase 7: Student course/quiz browsing

* `frontend-ui-engineering`
* `backend-api-engineering`

Phase 8: Quiz taking and scoring

* `backend-api-engineering`
* `test-driven-development`
* `security-and-hardening`
* `code-review-and-quality`

Phase 9: Student result history

* `backend-api-engineering`
* `security-and-hardening`
* `frontend-ui-engineering`

Phase 10: Admin attempt review

* `backend-api-engineering`
* `frontend-ui-engineering`
* `security-and-hardening`

Phase 11: UI polish

* `frontend-ui-engineering`
* `code-simplification`

Phase 12: Demo seed data

* `database-data-modeling`
* `fullstack-delivery-workflow`

Phase 13: Manual testing

* `test-driven-development`
* `unit-integration-testing`
* `playwright`
* `debugging-and-error-recovery`

Phase 14: README and GitHub

* `shipping-and-launch`
* `git-workflow-and-versioning`

Phase 15: Demo video

* `shipping-and-launch`

## 5. Project-Local Skill Notes

If a repeated workflow needs a project-local note, create it only in:

```text
.agents/skills/
```

Do not install system skills.
Do not edit installed skills.
Do not create a local skill for one-time work.
Do not let local skill writing slow down feature delivery.

Project-local skill notes should be short and directly useful to EduQuiz.

## 6. Progress Report Format

After each implementation run, include this section in the progress update:

```md
### Skills
Considered:
- ...

Used:
- ...

Reason:
- ...
```

## 7. Priority Order

If instructions conflict, follow this order:

1. The pre-test requirements.
2. `.agents/workflow/plan.md`.
3. `.agents/workflow/progress.md`.
4. `.agents/workflow/decisions.md`.
5. `.agents/rules/rules.md`.
6. The selected skill.
7. Agent judgment.

## 8. Encoding and Text Safety Rules

### Purpose

Prevent mojibake and broken Vietnamese text in agent workflow files, source files, Markdown files, Blade files, and reports.

### Required Encoding

All project files must be saved as UTF-8.

When creating or updating files, use tools or commands that preserve UTF-8.

If writing files through scripts, explicitly use UTF-8 encoding.

Example in Python:

```python
from pathlib import Path

Path("path/to/file.md").write_text(content, encoding="utf-8")
```

### ASCII-Safe Agent Files

For agent control files, prefer ASCII-only English headings and labels.

This applies to:

```text
.agents/workflow/plan.md
.agents/workflow/progress.md
.agents/workflow/test-log.md
.agents/workflow/decisions.md
.agents/workflow/commands.md
.agents/rules/rules.md
.agents/skills/*.md
```

Do not use Vietnamese diacritics in important agent headings.

Use:

```md
## Agent Skills Usage Rules
## Progress Log
## Test Log
## Technical Decisions
## Commands
```

Avoid Vietnamese headings in agent files because some terminals, shells, editors, or agent tools may corrupt UTF-8 text into mojibake.

### Path and Filename Rules

Use ASCII-only file and folder names.

Allowed examples:

```text
.agents/workflow/plan.md
.agents/workflow/progress.md
.agents/workflow/test-log.md
.agents/workflow/decisions.md
.agents/workflow/commands.md
.agents/rules/rules.md
.agents/skills/quiz-scoring-review.md
```

Do not create files with Vietnamese names or spaces.

### Content Rules

Agent workflow files should use English or ASCII Vietnamese without diacritics. Prefer English.

Preferred:

```md
## Phase 2: Role admin/student
## Database schema
## Quiz scoring
## Manual testing
```

### Laravel App UI Exception

Blade UI text may use Vietnamese if saved correctly as UTF-8.

If mojibake appears in Blade views, convert the affected text to UTF-8 or replace it with ASCII-safe English text.

### Mojibake Detection

Before finishing any task, scan changed Markdown and Blade files for common mojibake patterns:

```text
Ã
Â
áº
á»
â€
```

If these patterns appear in normal text, treat it as an encoding issue and fix it before marking the phase complete.

### Fixing Existing Mojibake

If corrupted text is found, replace it with clean ASCII-safe text.

### Reporting

If an encoding issue is found and fixed, record it in:

```text
.agents/workflow/test-log.md
.agents/workflow/progress.md
```

Use this format:

```md
Encoding Check:
- Found mojibake: Yes/No
- Files affected: ...
- Fixed: Yes/No
```

### Final Rule

For reliability, all agent workflow files should be ASCII-safe unless Vietnamese text is absolutely necessary.
