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
