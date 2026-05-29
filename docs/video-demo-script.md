# EduQuiz Video Demo Script

## Goal

Record a 3-5 minute demo showing the main EduQuiz features: admin content management, student quiz taking, scoring, attempt history, and admin result review.

## Demo Accounts

Use the seeded demo accounts:

| Role | Email | Password |
| --- | --- | --- |
| Admin | `admin@example.com` | `password` |
| Student | `student@example.com` | `password` |

## Recording Checklist

- App server running with `php artisan serve`
- Frontend assets running with `npm run dev` or already built with `npm run build`
- Database migrated with `php artisan migrate`
- Demo data seeded with `php artisan db:seed`
- Browser ready at `http://127.0.0.1:8000`
- Admin account ready
- Student account ready
- Browser zoom and screen size readable for recording
- Any private local files or terminals hidden before recording

## Demo Flow

1. Project introduction
2. Tech stack summary
3. Admin login
4. Admin dashboard
5. Admin reviews or creates course
6. Admin reviews or creates quiz
7. Admin reviews or creates questions and answers
8. Student login
9. Student views courses
10. Student opens quiz
11. Student submits quiz
12. Student views score/history
13. Admin views attempts/results
14. Closing summary

## Suggested Narration

### 1. Project Introduction

"This is EduQuiz, a mini quiz LMS built with Laravel for a pre-test project. It supports student quiz taking and admin quiz management."

### 2. Tech Stack Summary

"The project uses Laravel, Laravel Breeze Blade authentication, MySQL, Eloquent relationships, Blade views, Tailwind CSS, Vite, and PHPUnit tests."

### 3. Admin Login

"First, I will log in as the admin using the seeded demo account."

Actions:
- Open `/login`.
- Log in with `admin@example.com` and `password`.

### 4. Admin Dashboard

"The admin dashboard gives access to course, quiz, question, answer, and attempt management."

Actions:
- Show `/admin/dashboard`.
- Point out the admin navigation.

### 5. Admin Reviews or Creates Course

"Courses are the main learning containers. The admin can create, update, view, and delete courses."

Actions:
- Open `/admin/courses`.
- Show seeded courses such as `Laravel Fundamentals`.
- If time allows, create a short demo course.

### 6. Admin Reviews or Creates Quiz

"Each quiz belongs to a course and has a title, description, duration, and status."

Actions:
- Open `/admin/quizzes`.
- Show an existing quiz such as `Laravel MVC Quiz`.
- If time allows, create or edit a quiz.

### 7. Admin Reviews or Creates Questions and Answers

"Questions belong to quizzes, and each question has answer choices. The app enforces that a question with answers keeps at least one correct answer."

Actions:
- Open `/admin/questions`.
- Show an existing question.
- Open answers for the question.
- Show one correct answer and one incorrect answer.

### 8. Student Login

"Next, I will log out and log in as a student."

Actions:
- Log out.
- Log in with `student@example.com` and `password`.

### 9. Student Views Courses

"Students can browse active courses and see available quizzes."

Actions:
- Open `/courses`.
- Open a course detail page.

### 10. Student Opens Quiz

"The student can open a quiz and start answering questions."

Actions:
- Open a quiz detail page.
- Click the start quiz action.

### 11. Student Submits Quiz

"The student selects one answer for each question and submits the quiz."

Actions:
- Select answers.
- Submit the quiz.

### 12. Student Views Score and History

"After submission, EduQuiz calculates the score, saves the attempt, and shows the result. Students can also review their attempt history."

Actions:
- Show the result page.
- Open `/my-attempts`.
- Open the attempt detail.

### 13. Admin Views Attempts and Results

"Finally, the admin can review student attempts, including student information, quiz information, score, and selected answers."

Actions:
- Log out as student.
- Log in as admin.
- Open `/admin/attempts`.
- Open an attempt detail page.

### 14. Closing Summary

"This demo covered the main requirements: authentication, admin and student roles, CRUD management, relationships, quiz scoring, student history, admin result review, seeded demo data, and automated tests."

## Backup Plan

If live create or edit actions take too long:

- Use seeded data from `php artisan db:seed`.
- Show existing course: `Laravel Fundamentals`.
- Show existing quiz: `Laravel MVC Quiz`.
- Show existing questions and answers.
- Focus on the main flow: admin review, student quiz taking, score result, and admin attempt review.
- Mention that CRUD actions are covered by the UI and automated tests.

## Final Submission Checklist

- GitHub repo link ready
- Video file or video link ready
- README checked
- Tests passing
- Build passing
- Demo accounts verified
- Demo script reviewed before recording

