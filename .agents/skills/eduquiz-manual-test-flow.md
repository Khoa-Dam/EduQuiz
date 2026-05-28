# EduQuiz Manual Test Flow

## Purpose

Manual test checklist before final submission or after major phases.

## When to use

Use in:

* Phase 13: Manual testing
* Before recording the demo video
* Before final GitHub push

## Test Flow

### Auth

* [ ] Register student account.
* [ ] Login student.
* [ ] Logout.
* [ ] Login admin.

### Role

* [ ] Student cannot access `/admin`.
* [ ] Admin can access `/admin/dashboard`.
* [ ] Dashboard matches user role.

### Admin Flow

* [ ] Admin creates course.
* [ ] Admin updates course.
* [ ] Admin creates quiz for course.
* [ ] Admin creates question for quiz.
* [ ] Admin creates answers for question.
* [ ] Admin marks correct answer.

### Student Flow

* [ ] Student views course list.
* [ ] Student views course detail.
* [ ] Student views quiz.
* [ ] Student takes quiz.
* [ ] Student submits quiz.
* [ ] Student views result.
* [ ] Student views attempt history.

### Admin Result Flow

* [ ] Admin views attempt list.
* [ ] Admin views attempt detail.
* [ ] User, quiz, and score display correctly.

### Build Check

* [ ] `php artisan route:list`
* [ ] `php artisan migrate`
* [ ] `php artisan test`
* [ ] `npm run build`

## Output expected

Project is ready for demo and submission.
