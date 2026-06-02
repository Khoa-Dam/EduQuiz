# EduQuiz

EduQuiz is a small Laravel mini quiz LMS built for a recruitment pre-test. It demonstrates Laravel MVC, Breeze Blade authentication, role-based access, relational database design, CRUD management, quiz scoring, and result review.

## Tech Stack

- PHP 8.3
- Laravel 13
- Laravel Breeze Blade
- MySQL
- Blade, Tailwind CSS, Alpine.js
- Vite
- PHPUnit

## Features

- Student registration, login, logout, and profile management
- Admin and student roles
- Admin dashboard
- Admin CRUD for courses, quizzes, questions, and answers
- Correct-answer validation for question answers
- Student course and quiz browsing
- Quiz taking with scored submissions
- Saved quiz attempts and selected answers
- Student attempt history and result detail pages
- Admin attempt review with student, quiz, course, score, and answer details
- Idempotent demo seed data for quick local testing

## Demo Accounts

The database seeder creates these accounts:

| Role | Email | Password |
| --- | --- | --- |
| Admin | `admin@example.com` | `password` |
| Student | `student@example.com` | `password` |

## Requirements

- PHP 8.3 or newer
- Composer
- Node.js and npm
- MySQL

## Installation

Clone the repository and install dependencies:

```bash
composer install
npm install
```

Create the environment file and application key:

```bash
cp .env.example .env
php artisan key:generate
```

Configure MySQL in `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=eduquiz_db
DB_USERNAME=root
DB_PASSWORD=
```

Create the database, then run migrations and seed demo data:

```bash
php artisan migrate
php artisan db:seed
```

Build frontend assets:

```bash
npm run build
```

## Running Locally

Start the Laravel server:

```bash
php artisan serve
```

For frontend development, run Vite in a second terminal:

```bash
npm run dev
```

Open the app at:

```text
http://127.0.0.1:8000
```

## Testing

The project test suite is configured to run against a MySQL testing database named `eduquiz_test`.

Create that database, then run:

```bash
php artisan migrate --env=testing
php artisan test
```

Useful verification commands:

```bash
php artisan route:list
npm run build
```

## Main Routes

Student routes:

- `/dashboard`
- `/courses`
- `/courses/{course}`
- `/quizzes/{quiz}`
- `/quizzes/{quiz}/start`
- `/my-attempts`
- `/my-attempts/{attempt}`

Admin routes:

- `/admin/dashboard`
- `/admin/courses`
- `/admin/quizzes`
- `/admin/questions`
- `/admin/answers`
- `/admin/attempts`

## Demo Flow

1. Log in as `admin@example.com`.
2. Create a course.
3. Create a quiz for that course.
4. Create a question and at least one correct answer.
5. Log out.
6. Register or log in as a student.
7. Browse courses and open the quiz.
8. Submit answers and view the result.
9. Log back in as admin.
10. Review the student's attempt from the admin attempts page.

## Project Notes

- New registered users default to the student role.
- Admin pages are protected by the `admin` middleware.
- Only active courses and active quizzes are visible in student browsing pages.
- Quiz scoring adds each correctly answered question's `points` value.
- The seeder is idempotent and can be run repeatedly without duplicating demo records.

