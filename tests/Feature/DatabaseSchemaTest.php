<?php

namespace Tests\Feature;

use App\Models\Answer;
use App\Models\Course;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\QuizAttemptAnswer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class DatabaseSchemaTest extends TestCase
{
    use RefreshDatabase;

    public function test_core_quiz_tables_exist_with_expected_columns(): void
    {
        $this->assertTrue(Schema::hasColumn('users', 'avatar_path'));

        $this->assertTrue(Schema::hasColumns('courses', [
            'id',
            'title',
            'description',
            'status',
            'created_at',
            'updated_at',
        ]));

        $this->assertTrue(Schema::hasColumns('quizzes', [
            'id',
            'course_id',
            'title',
            'description',
            'cover_image_path',
            'duration_minutes',
            'status',
            'created_at',
            'updated_at',
        ]));

        $this->assertTrue(Schema::hasColumns('questions', [
            'id',
            'quiz_id',
            'question_text',
            'image_path',
            'points',
            'created_at',
            'updated_at',
        ]));

        $this->assertTrue(Schema::hasColumns('answers', [
            'id',
            'question_id',
            'answer_text',
            'is_correct',
            'created_at',
            'updated_at',
        ]));

        $this->assertTrue(Schema::hasColumns('quiz_attempts', [
            'id',
            'user_id',
            'quiz_id',
            'score',
            'total_questions',
            'correct_answers',
            'xp_earned',
            'started_at',
            'submitted_at',
            'created_at',
            'updated_at',
        ]));

        $this->assertTrue(Schema::hasColumns('quiz_attempt_answers', [
            'id',
            'quiz_attempt_id',
            'question_id',
            'answer_id',
            'is_correct',
            'created_at',
            'updated_at',
        ]));
    }

    public function test_model_relationships_work(): void
    {
        $user = User::factory()->student()->create();
        $course = Course::create([
            'title' => 'Laravel Basics',
            'description' => 'Introductory Laravel course.',
        ]);
        $quiz = Quiz::create([
            'course_id' => $course->id,
            'title' => 'Laravel Intro Quiz',
            'duration_minutes' => 15,
        ]);
        $question = Question::create([
            'quiz_id' => $quiz->id,
            'question_text' => 'What pattern does Laravel commonly use?',
            'points' => 2,
        ]);
        $answer = Answer::create([
            'question_id' => $question->id,
            'answer_text' => 'MVC',
            'is_correct' => true,
        ]);
        $attempt = QuizAttempt::create([
            'user_id' => $user->id,
            'quiz_id' => $quiz->id,
            'score' => 2,
            'total_questions' => 1,
            'correct_answers' => 1,
            'started_at' => now(),
            'submitted_at' => now(),
        ]);
        $attemptAnswer = QuizAttemptAnswer::create([
            'quiz_attempt_id' => $attempt->id,
            'question_id' => $question->id,
            'answer_id' => $answer->id,
            'is_correct' => true,
        ]);

        $this->assertTrue($course->quizzes->contains($quiz));
        $this->assertTrue($quiz->questions->contains($question));
        $this->assertTrue($question->answers->contains($answer));
        $this->assertTrue($user->quizAttempts->contains($attempt));
        $this->assertTrue($quiz->attempts->contains($attempt));
        $this->assertTrue($attempt->attemptAnswers->contains($attemptAnswer));
        $this->assertTrue($attemptAnswer->question->is($question));
        $this->assertTrue($attemptAnswer->answer->is($answer));
    }

    public function test_course_delete_cascades_to_quiz_content(): void
    {
        $course = Course::create(['title' => 'Cascade Course']);
        $quiz = Quiz::create(['course_id' => $course->id, 'title' => 'Cascade Quiz']);
        $question = Question::create(['quiz_id' => $quiz->id, 'question_text' => 'Cascade question']);
        $answer = Answer::create(['question_id' => $question->id, 'answer_text' => 'Cascade answer']);

        $course->delete();

        $this->assertDatabaseMissing('quizzes', ['id' => $quiz->id]);
        $this->assertDatabaseMissing('questions', ['id' => $question->id]);
        $this->assertDatabaseMissing('answers', ['id' => $answer->id]);
    }
}
