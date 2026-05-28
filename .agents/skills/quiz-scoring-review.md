# Quiz Scoring Review

## Purpose

Checklist for reviewing quiz taking and scoring logic.

## When to use

Use in:

* Phase 8: Quiz taking and scoring
* Phase 9: Student result history
* Phase 10: Admin attempt review

## Checklist

### Submit

* [ ] Student can submit only active quizzes.
* [ ] Request answers are valid.
* [ ] Each question reads the selected answer correctly.
* [ ] `answer_id` is not trusted unless it belongs to the question.

### Scoring

* [ ] Correct answers add points.
* [ ] Wrong answers add no points.
* [ ] `correct_answers` is correct.
* [ ] `total_questions` is correct.
* [ ] `score` is correct.
* [ ] Missing question points default to 1.

### Storage

* [ ] `quiz_attempt` uses correct `user_id`.
* [ ] `quiz_attempt` uses correct `quiz_id`.
* [ ] `submitted_at` is saved.
* [ ] Each `quiz_attempt_answer` is saved.
* [ ] `is_correct` is saved per question.

### Authorization

* [ ] Student can view only own attempts.
* [ ] Admin can view all attempts.

## Output expected

Scoring is correct, attempt data is complete, and basic authorization is safe.
