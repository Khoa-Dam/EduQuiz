# EduQuiz - Implementation Plan

## 1. Project Overview

EduQuiz is a Mini Quiz LMS for a Laravel recruitment pre-test. The app lets students register, log in, browse courses, take quizzes, submit answers, view scores, and review attempt history. Admin users can manage courses, quizzes, questions, answers, and review student quiz results.

The project should stay small, clear, and demo-friendly. It must show practical Laravel MVC skills, MySQL database design, Blade UI, authentication, authorization, CRUD, relationships, and quiz scoring logic.

## 2. Pre-Test Goals

The project should demonstrate:

* Database design
* Laravel MVC structure
* Eloquent relationships
* CRUD implementation
* Quiz scoring logic
* Blade UI
* Laravel Breeze Blade authentication
* Simple admin/student roles
* Clear demo flow

## 3. Project Scope

### Must-have

* Auth with Laravel Breeze Blade
* Role admin/student
* Admin dashboard
* Student dashboard
* Course CRUD
* Quiz CRUD
* Question CRUD
* Answer CRUD
* Student quiz taking
* Score calculation
* Quiz attempt history
* Student history pages
* Admin attempt review

### Nice-to-have

* Course/quiz search
* Course filter
* Score percentage display
* Detailed correct/wrong result page
* Clean demo seed data
* UI polish

### Out of scope

* Payments
* Video lesson upload
* Realtime chat
* Notifications
* Mobile API
* Complex multi-teacher features
* Permission packages
* Over-designed UI

## 4. Expected Database Design

### users

Fields:

* id
* name
* email
* password
* role: admin/student
* timestamps

Relationship:

* User hasMany QuizAttempt

### courses

Fields:

* id
* title
* description
* status
* timestamps

Relationship:

* Course hasMany Quiz

### quizzes

Fields:

* id
* course_id
* title
* description
* duration_minutes
* status
* timestamps

Relationship:

* Quiz belongsTo Course
* Quiz hasMany Question
* Quiz hasMany QuizAttempt

### questions

Fields:

* id
* quiz_id
* question_text
* points
* timestamps

Relationship:

* Question belongsTo Quiz
* Question hasMany Answer

### answers

Fields:

* id
* question_id
* answer_text
* is_correct
* timestamps

Relationship:

* Answer belongsTo Question

### quiz_attempts

Fields:

* id
* user_id
* quiz_id
* score
* total_questions
* correct_answers
* started_at
* submitted_at
* timestamps

Relationship:

* QuizAttempt belongsTo User
* QuizAttempt belongsTo Quiz
* QuizAttempt hasMany QuizAttemptAnswer

### quiz_attempt_answers

Fields:

* id
* quiz_attempt_id
* question_id
* answer_id
* is_correct
* timestamps

Relationship:

* QuizAttemptAnswer belongsTo QuizAttempt
* QuizAttemptAnswer belongsTo Question
* QuizAttemptAnswer belongsTo Answer

## 5. Model Relationships

User:

* quizAttempts()

Course:

* quizzes()

Quiz:

* course()
* questions()
* attempts()

Question:

* quiz()
* answers()

Answer:

* question()

QuizAttempt:

* user()
* quiz()
* attemptAnswers()

QuizAttemptAnswer:

* attempt()
* question()
* answer()

## 6. Route Plan

### Public routes

* `/`
* `/login`
* `/register`

### Authenticated routes

* `/dashboard`
* `/profile`

### Student routes

* `GET /courses`
* `GET /courses/{course}`
* `GET /quizzes/{quiz}`
* `GET /quizzes/{quiz}/start`
* `POST /quizzes/{quiz}/submit`
* `GET /my-attempts`
* `GET /my-attempts/{attempt}`

### Admin routes

Prefix: `/admin`

* `GET /admin/dashboard`
* `Resource /admin/courses`
* `Resource /admin/quizzes`
* `Resource /admin/questions`
* `Resource /admin/answers`
* `GET /admin/attempts`
* `GET /admin/attempts/{attempt}`

## 7. Controller Plan

* DashboardController: redirect or render dashboard by role.
* Admin/DashboardController: admin overview metrics.
* Admin/CourseController: course CRUD.
* Admin/QuizController: quiz CRUD by course.
* Admin/QuestionController: question CRUD by quiz.
* Admin/AnswerController: answer CRUD by question.
* Admin/AttemptController: admin attempt list and detail.
* Student/CourseController: active course list and detail.
* Student/QuizController: quiz detail and start page.
* Student/QuizAttemptController: submit quiz, score answers, save attempts, show history.

## 8. Blade View Plan

Expected view tree:

```text
resources/views/
|-- layouts/
|   |-- app.blade.php
|   `-- admin.blade.php
|-- dashboard.blade.php
|-- admin/
|   |-- dashboard.blade.php
|   |-- courses/
|   |-- quizzes/
|   |-- questions/
|   |-- answers/
|   `-- attempts/
`-- student/
    |-- courses/
    |-- quizzes/
    `-- attempts/
```

View groups:

* `layouts/app.blade.php`: shared student and Breeze layout.
* `layouts/admin.blade.php`: admin layout with management navigation.
* `dashboard.blade.php`: role-aware or student dashboard.
* `admin/dashboard.blade.php`: admin overview.
* `admin/courses/`: course list, forms, detail.
* `admin/quizzes/`: quiz list, forms, detail.
* `admin/questions/`: question management by quiz.
* `admin/answers/`: answer management by question.
* `admin/attempts/`: attempt list and detail.
* `student/courses/`: course list and detail.
* `student/quizzes/`: quiz detail and taking form.
* `student/attempts/`: student history and attempt detail.

## 9. Feature Implementation Plan

### Phase 1: Project setup

Goal:

* Laravel project runs.
* Breeze Blade works.
* MySQL connection works.
* Auth routes work.

Checklist:

* `php artisan serve` runs.
* `npm run dev` runs.
* Register/login/logout work.
* Dashboard is accessible after login.

Status:

* Completed.
* Verified with MySQL testing database `eduquiz_test`.
* `php artisan route:list`, `php artisan migrate --env=testing`, `php artisan test`, and `npm run build` passed.

### Phase 2: Role admin/student

Goal:

* Add role to users.
* New registered users default to student.
* Create admin account.
* Admin middleware works.
* Dashboard routes by role.

Checklist:

* Student sees Student Dashboard.
* Admin sees Admin Dashboard.
* Student cannot access `/admin`.
* Admin can access `/admin/dashboard`.

Status:

* Completed.
* Added simple `users.role` support with `admin` and `student` roles.
* New registered users default to `student`.
* Admin middleware protects `/admin/dashboard`.
* Verified with MySQL testing database `eduquiz_test`.
* `php artisan migrate --env=testing`, `php artisan route:list`, `php artisan test`, and `npm run build` passed.

### Phase 3: Core database schema

Goal:

* Create migrations for courses, quizzes, questions, answers, quiz_attempts, quiz_attempt_answers.
* Add correct foreign keys.
* Add model relationships.
* Run migrations successfully.

Checklist:

* Database has all required tables.
* Foreign keys are correct.
* Relationships work.

Status:

* Completed.
* Added migrations for courses, quizzes, questions, answers, quiz_attempts, and quiz_attempt_answers.
* Added Eloquent models and relationships for the core quiz domain.
* Added schema and relationship tests.
* Verified with MySQL testing database `eduquiz_test`.
* `php artisan migrate --env=testing`, `php artisan test`, `php artisan route:list`, and `npm run build` passed.

### Phase 4: Admin Course CRUD

Goal:

* Admin can create, update, delete, and view courses.
* Data is validated.
* Blade UI is clear.

Checklist:

* Course creation works.
* Course update works.
* Course deletion works.
* Course list displays correctly.

Status:

* Completed.
* Added admin-only Course resource routes and controller.
* Added course list, create, edit, show, and delete Blade UI.
* Added validation for course title, description, and status.
* Added feature tests for admin Course CRUD and student access denial.
* `php artisan migrate --env=testing`, `php artisan route:list`, `php artisan test`, and `npm run build` passed.

### Phase 5: Admin Quiz CRUD

Goal:

* Admin can create quizzes under courses.
* Admin can update, delete, and view quizzes.
* Quiz has duration and status.

Checklist:

* Create quiz for a course.
* Quiz list shows related course.
* Quiz detail works.

Status:

* Completed.
* Added admin-only Quiz resource routes and controller.
* Added quiz list, create, edit, show, and delete Blade UI.
* Added validation for course, title, duration, status, and description.
* Added feature tests for admin Quiz CRUD and student access denial.
* `php artisan migrate --env=testing`, `php artisan route:list`, `php artisan test`, and `npm run build` passed.

### Phase 6: Admin Question & Answer CRUD

Goal:

* Admin can add questions to quizzes.
* Each question can have multiple answers.
* Admin can mark correct answer.
* Validate at least one correct answer where applicable.

Checklist:

* Question creation works.
* Answer creation works.
* Correct answer marking works.
* Questions display by quiz.

Status:

* Completed.
* Added admin-only Question and Answer resource routes and controllers.
* Added question list, create, edit, show, and delete Blade UI.
* Added answer list, create, edit, show, and delete Blade UI.
* Added validation so each question with answers keeps at least one correct answer.
* Added feature tests for question CRUD, answer CRUD, correct-answer marking, validation, and student access denial.
* `php artisan migrate --env=testing`, `php artisan route:list`, `php artisan test`, and `npm run build` passed.

### Phase 7: Student course/quiz browsing

Goal:

* Student can view course list.
* Student can view course detail.
* Student can view quizzes under a course.
* Student can open quiz start page.

Checklist:

* Student sees active courses.
* Student sees active quizzes.
* Student does not see admin pages.

Status:

* Completed.
* Added authenticated student course list and course detail pages.
* Added active quiz detail and quiz start pages.
* Added active-only visibility rules for student browsing.
* Added feature tests for active course/quiz visibility, quiz start page, and admin denial.
* `php artisan migrate --env=testing`, `php artisan route:list`, `php artisan test`, and `npm run build` passed.

### Phase 8: Quiz taking and scoring

Goal:

* Student selects answers.
* Student submits quiz.
* System counts correct answers.
* System calculates score.
* System saves quiz_attempt.
* System saves quiz_attempt_answers.

Scoring logic:

* Each correct answer adds `questions.points`.
* If points is not set, default to 1.
* Save total_questions.
* Save correct_answers.
* Save score.

Checklist:

* Submit works without errors.
* Score is correct.
* Attempt is saved.
* Attempt answer detail is saved.

### Phase 9: Student result history

Goal:

* Student can view own attempt history.
* Student can view one attempt detail.
* Student can only view own attempts.

Checklist:

* Student sees own attempt list.
* Student cannot view another user's attempt.
* Detail shows score and correct/wrong counts.

### Phase 10: Admin attempt review

Goal:

* Admin can view all attempts.
* Admin can filter by quiz or student if time allows.
* Admin can view attempt detail.

Checklist:

* Admin sees all attempts.
* Admin sees attempt detail.
* User, quiz, and score are clear.

### Phase 11: UI polish

Goal:

* Clean layout.
* Clear navigation.
* Consistent buttons and links.
* Success/error alerts.
* Empty states for blank lists.

Checklist:

* No broken layout.
* Forms are easy to use.
* Tables are readable.
* Back links exist where needed.

### Phase 12: Demo seed data

Goal:

* Create data for demo video.
* Include admin.
* Include student.
* Include at least 2 courses.
* Each course has quiz data.
* Each quiz has questions and answers.

Checklist:

* Seeder runs successfully.
* Demo data is enough for immediate demo.

### Phase 13: Manual testing

Checklist:

* Register student.
* Login student.
* Login admin.
* Admin creates course.
* Admin creates quiz.
* Admin creates question/answer.
* Student takes quiz.
* Student sees score.
* Admin sees result.
* Logout works.
* Role middleware works.

### Phase 14: README and GitHub

README should include:

* Project name.
* Description.
* Tech stack.
* Features.
* Install guide.
* Run guide.
* Demo accounts.
* Database setup.
* Screenshots if available.

### Phase 15: Demo video

Demo script:

1. Introduce EduQuiz.
2. Login as admin.
3. Admin creates course/quiz/question/answer.
4. Login as student.
5. Student browses courses.
6. Student takes quiz.
7. Student sees score.
8. Admin reviews result.
9. Close with short summary.

## 10. Seven-Day Schedule

### Day 1

* Project setup
* Breeze Blade
* MySQL
* Role admin/student
* Dashboard

### Day 2

* Database schema
* Model relationships
* Admin Course CRUD

### Day 3

* Admin Quiz CRUD
* Admin Question CRUD

### Day 4

* Answer CRUD
* Question/answer validation
* Initial demo seed data

### Day 5

* Student course/quiz browsing
* Quiz taking
* Score calculation
* Attempt storage

### Day 6

* Student history
* Admin results
* UI polish
* Manual testing

### Day 7

* README
* GitHub cleanup
* Demo video
* Final test

## 11. Commit Plan

Suggested commits:

* `chore: initialize Laravel Breeze project`
* `feat: add user roles and dashboards`
* `feat: add core database schema`
* `feat: implement admin course management`
* `feat: implement admin quiz management`
* `feat: implement question and answer management`
* `feat: implement student quiz taking`
* `feat: add quiz attempt history`
* `feat: add admin attempt review`
* `chore: add seeders and demo data`
* `docs: add README and setup guide`
* `style: polish Blade UI`

## 12. Definition of Done

Project is complete when:

* It runs locally.
* Database migration succeeds.
* Login/register/logout exist.
* Admin/student roles exist.
* Admin can CRUD courses/quizzes/questions/answers.
* Student can take quizzes.
* Score calculation is correct.
* Student can view history.
* Admin can view results.
* UI has no serious layout issues.
* README is complete.
* GitHub repo is ready.
* Demo video is ready.

## 13. Risks and Scope Cuts

If time is short, keep:

1. Auth
2. Role
3. Course
4. Quiz
5. Question/Answer
6. Student quiz taking
7. Score calculation
8. Result storage

Can skip:

* Search/filter
* Very detailed result page
* Advanced UI
* Real quiz timer
* Email verification
* Password reset
* Advanced profile features

## 14. Development Rules

When coding future features:

* One prompt should handle one feature or one small phase.
* Do not modify unrelated files.
* Run migration/checks after each phase where relevant.
* Keep controllers readable.
* Keep complex logic clearly separated.
* Keep Blade views readable.
* Do not use React/Vue/Inertia.
* Do not use heavy permission packages.
* Do not hard-code demo data in views.
* Always validate form input.
* Always check admin/student access.
