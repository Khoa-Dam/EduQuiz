# EduQuiz Technical Decisions

This file records fixed technical decisions so future agent runs do not drift.

## TD-001: Tech Stack

Use:

* Laravel
* MySQL
* Blade Template
* Laravel Breeze Blade
* Tailwind/simple Blade styling

Do not use:

* React
* Vue
* Inertia
* API-only architecture
* Spatie Permission

## TD-002: Authentication

Use Laravel Breeze Blade for:

* Register
* Login
* Logout
* Dashboard
* Profile if available

## TD-003: Authorization

Use a simple `role` field in the `users` table.

Allowed roles:

* `admin`
* `student`

Do not implement a complex permission package.

## TD-004: Role Storage

Store role as a simple string column in `users.role`.

Default role:

* `student`

Admin role:

* `admin`

## TD-005: Admin Access

Admin pages must be protected by:

* `auth` middleware
* custom `admin` middleware

Students must not access `/admin/*`.

## TD-006: Quiz Scoring

Each correct answer adds points from `questions.points`.

If `questions.points` is missing or not set, default to 1 point.

Store:

* score
* total_questions
* correct_answers
* started_at
* submitted_at

## TD-007: Route Organization

Use route groups:

* public routes
* auth routes from Breeze
* student routes under `auth`
* admin routes under `auth` + `admin`

Admin routes should use:

* URL prefix: `/admin`
* route name prefix: `admin.`

## TD-008: UI Direction

UI should be simple, clean, readable, and demo-friendly.

Priority:

* Clear navigation
* Usable tables
* Clear forms
* Validation errors
* Success messages

Do not spend too much time on advanced design.

## TD-009: Testing Database

Use MySQL for automated tests.

Testing database:

* `eduquiz_test`

Do not use SQLite for this project.

`phpunit.xml` should set:

* `DB_CONNECTION=mysql`
* `DB_HOST=127.0.0.1`
* `DB_PORT=3306`
* `DB_DATABASE=eduquiz_test`

Keep database credentials in local environment files only.

Do not commit:

* `.env`
* `.env.testing`
* `.env.*`

## TD-010: Core Schema Defaults and Cascades

Use simple string statuses for course and quiz publishing state.

Default status:

* `active`

Use default question points:

* `1`

Use cascade deletes from parent learning content to child records:

* Course deletes its quizzes.
* Quiz deletes its questions and attempts.
* Question deletes its answers and attempt answers.
* QuizAttempt deletes its attempt answers.

Use one selected answer per question per attempt:

* Unique key on `quiz_attempt_id` and `question_id`.

## TD-011: Question Correct Answer Rule

Questions may be created before answers are added.

After a question has answers, it must keep at least one correct answer.

Answer CRUD must prevent:

* Creating the first answer as incorrect.
* Updating the only correct answer to incorrect.
* Deleting the only correct answer when other answers remain.

Deleting the only answer for a question is allowed because the question returns to having no answers.

## TD-012: Quiz Submission Completeness

Students must select one answer for every question before submitting a quiz.

Reason:

* `quiz_attempt_answers.answer_id` is required.
* Attempt detail should have one saved answer per question.
* Missing answers should be corrected before scoring.

If partial submissions are needed later, change `quiz_attempt_answers.answer_id` to nullable and update scoring rules.

## TD-013: Taste Skill Frontend Design Skills

Installed project-local Taste Skill frontend design skills from:

```text
https://github.com/Leonxlnx/taste-skill
```

Installed skills:

* `.agents/skills/redesign-existing-projects`
* `.agents/skills/design-taste-frontend`
* `.agents/skills/gpt-taste`

Purpose:

* `redesign-existing-projects`: audit and improve the existing Laravel Blade UI.
* `design-taste-frontend`: general frontend design taste rules.
* `gpt-taste`: stricter Codex/GPT-oriented frontend polish rules.

These skills are available for future UI redesign work. Installation did not include Laravel app code changes.

## TD-014: Frontend UI Stack

Frontend UI polish must use:

* Laravel Blade
* Laravel Breeze layouts/components
* Tailwind/simple styling

Do not use:

* React
* Vue
* Inertia
* SPA architecture
* Spatie Permission

Small controller changes are allowed only when they provide display data for existing pages, such as dashboard stats, and do not change business behavior.
