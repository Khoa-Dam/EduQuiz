<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Answer;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Testing\File;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminQuizBuilderTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_open_builder_create_page(): void
    {
        $admin = User::factory()->admin()->create();
        Course::create(['title' => 'Laravel Course']);

        $this->actingAs($admin)
            ->get('/admin/quiz-builder/create')
            ->assertOk()
            ->assertSee('Quiz Builder')
            ->assertSee('Publish quiz');
    }

    public function test_admin_can_open_builder_edit_page(): void
    {
        $admin = User::factory()->admin()->create();
        $course = Course::create(['title' => 'Laravel Course']);
        $quiz = Quiz::create([
            'course_id' => $course->id,
            'title' => 'Draft Quiz',
            'status' => 'inactive',
        ]);

        $this->actingAs($admin)
            ->get("/admin/quiz-builder/{$quiz->id}/edit")
            ->assertOk()
            ->assertSee('Draft Quiz')
            ->assertSee('Publish quiz');
    }

    public function test_admin_can_save_incomplete_quiz_as_draft(): void
    {
        $admin = User::factory()->admin()->create();
        $course = Course::create(['title' => 'Laravel Course']);

        $this->actingAs($admin)
            ->post('/admin/quiz-builder', [
                'intent' => 'draft',
                'course_mode' => 'existing',
                'course_id' => $course->id,
                'title' => 'Draft Quiz',
                'description' => 'Work in progress.',
                'duration_minutes' => 15,
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('quizzes', [
            'course_id' => $course->id,
            'title' => 'Draft Quiz',
            'status' => 'inactive',
        ]);
    }

    public function test_admin_can_create_course_and_publish_complete_quiz_from_builder(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->post('/admin/quiz-builder', [
                'intent' => 'publish',
                'course_mode' => 'new',
                'course_title' => 'Laravel Basics',
                'course_description' => 'Intro course.',
                'title' => 'MVC Quiz',
                'description' => 'Check MVC concepts.',
                'duration_minutes' => 20,
                'questions' => [
                    [
                        'question_text' => 'What does MVC stand for?',
                        'points' => 2,
                        'answers' => [
                            ['answer_text' => 'Model View Controller', 'is_correct' => '1'],
                            ['answer_text' => 'Main View Component'],
                        ],
                    ],
                ],
            ])
            ->assertRedirect();

        $course = Course::where('title', 'Laravel Basics')->firstOrFail();
        $quiz = Quiz::where('title', 'MVC Quiz')->firstOrFail();

        $this->assertSame($course->id, $quiz->course_id);
        $this->assertSame('active', $quiz->status);
        $this->assertDatabaseHas('questions', [
            'quiz_id' => $quiz->id,
            'question_text' => 'What does MVC stand for?',
            'points' => 2,
        ]);
        $this->assertDatabaseHas('answers', [
            'answer_text' => 'Model View Controller',
            'is_correct' => true,
        ]);
    }

    public function test_builder_rejects_publish_when_question_has_too_few_answers(): void
    {
        Storage::fake('public');
        $admin = User::factory()->admin()->create();
        $course = Course::create(['title' => 'Laravel Course']);

        $this->actingAs($admin)
            ->post('/admin/quiz-builder', [
                'intent' => 'publish',
                'course_mode' => 'existing',
                'course_id' => $course->id,
                'title' => 'Incomplete Quiz',
                'cover_image' => $this->fakePng('failed-cover.png'),
                'questions' => [
                    [
                        'question_text' => 'Only one answer?',
                        'points' => 1,
                        'answers' => [
                            ['answer_text' => 'Correct', 'is_correct' => '1'],
                        ],
                    ],
                ],
            ])
            ->assertSessionHasErrors('publish');

        $this->assertDatabaseMissing('quizzes', [
            'title' => 'Incomplete Quiz',
            'status' => 'active',
        ]);
        $this->assertSame([], Storage::disk('public')->allFiles('quizzes'));
    }

    public function test_builder_rejects_publish_when_question_has_no_correct_answer(): void
    {
        $admin = User::factory()->admin()->create();
        $course = Course::create(['title' => 'Laravel Course']);

        $this->actingAs($admin)
            ->post('/admin/quiz-builder', [
                'intent' => 'publish',
                'course_mode' => 'existing',
                'course_id' => $course->id,
                'title' => 'No Correct Answer Quiz',
                'questions' => [
                    [
                        'question_text' => 'No correct answer?',
                        'points' => 1,
                        'answers' => [
                            ['answer_text' => 'Wrong one'],
                            ['answer_text' => 'Wrong two'],
                        ],
                    ],
                ],
            ])
            ->assertSessionHasErrors('publish');
    }

    public function test_admin_can_publish_and_unpublish_ready_quiz(): void
    {
        $admin = User::factory()->admin()->create();
        $course = Course::create(['title' => 'Laravel Course']);
        $quiz = Quiz::create([
            'course_id' => $course->id,
            'title' => 'Ready Quiz',
            'status' => 'inactive',
        ]);
        $question = Question::create([
            'quiz_id' => $quiz->id,
            'question_text' => 'Ready question',
            'points' => 1,
        ]);
        Answer::create(['question_id' => $question->id, 'answer_text' => 'Correct', 'is_correct' => true]);
        Answer::create(['question_id' => $question->id, 'answer_text' => 'Wrong', 'is_correct' => false]);

        $this->actingAs($admin)
            ->post("/admin/quizzes/{$quiz->id}/publish")
            ->assertRedirect();

        $this->assertSame('active', $quiz->refresh()->status);

        $this->actingAs($admin)
            ->post("/admin/quizzes/{$quiz->id}/unpublish")
            ->assertRedirect();

        $this->assertSame('inactive', $quiz->refresh()->status);
    }

    public function test_failed_builder_update_keeps_old_image_and_removes_new_upload(): void
    {
        Storage::fake('public');

        $admin = User::factory()->admin()->create();
        [$quiz, $question, $correctAnswer, $wrongAnswer] = $this->readyQuiz('Image Safe Quiz');
        $oldPath = $this->fakePng('old-cover.png')->store('quizzes', 'public');
        $quiz->update(['cover_image_path' => $oldPath]);

        $this->actingAs($admin)
            ->put("/admin/quiz-builder/{$quiz->id}", [
                'intent' => 'publish',
                'course_mode' => 'existing',
                'course_id' => $quiz->course_id,
                'title' => 'Image Safe Quiz',
                'cover_image' => $this->fakePng('new-cover.png'),
                'questions' => [
                    [
                        'id' => $question->id,
                        'question_text' => $question->question_text,
                        'points' => 1,
                        'answers' => [
                            ['id' => $correctAnswer->id, 'answer_text' => 'Correct', 'is_correct' => '1'],
                        ],
                    ],
                ],
            ])
            ->assertSessionHasErrors('publish');

        Storage::disk('public')->assertExists($oldPath);
        $this->assertSame($oldPath, $quiz->refresh()->cover_image_path);
        $this->assertCount(1, Storage::disk('public')->allFiles('quizzes'));
    }

    public function test_saving_active_ready_quiz_keeps_it_active(): void
    {
        $admin = User::factory()->admin()->create();
        [$quiz, $question, $correctAnswer, $wrongAnswer] = $this->readyQuiz('Active Quiz');
        $quiz->update(['status' => 'active']);

        $this->actingAs($admin)
            ->put("/admin/quiz-builder/{$quiz->id}", [
                'intent' => 'save',
                'course_mode' => 'existing',
                'course_id' => $quiz->course_id,
                'title' => 'Updated Active Quiz',
                'questions' => [
                    [
                        'id' => $question->id,
                        'question_text' => $question->question_text,
                        'points' => 1,
                        'answers' => [
                            ['id' => $correctAnswer->id, 'answer_text' => 'Correct', 'is_correct' => '1'],
                            ['id' => $wrongAnswer->id, 'answer_text' => 'Wrong'],
                        ],
                    ],
                ],
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('quizzes', [
            'id' => $quiz->id,
            'title' => 'Updated Active Quiz',
            'status' => 'active',
        ]);
    }

    public function test_move_to_draft_makes_active_quiz_inactive(): void
    {
        $admin = User::factory()->admin()->create();
        [$quiz, $question, $correctAnswer, $wrongAnswer] = $this->readyQuiz('Draftable Quiz');
        $quiz->update(['status' => 'active']);

        $this->actingAs($admin)
            ->put("/admin/quiz-builder/{$quiz->id}", [
                'intent' => 'draft',
                'course_mode' => 'existing',
                'course_id' => $quiz->course_id,
                'title' => 'Draftable Quiz',
                'questions' => [
                    [
                        'id' => $question->id,
                        'question_text' => $question->question_text,
                        'points' => 1,
                        'answers' => [
                            ['id' => $correctAnswer->id, 'answer_text' => 'Correct', 'is_correct' => '1'],
                            ['id' => $wrongAnswer->id, 'answer_text' => 'Wrong'],
                        ],
                    ],
                ],
            ])
            ->assertRedirect();

        $this->assertSame('inactive', $quiz->refresh()->status);
    }

    private function readyQuiz(string $title): array
    {
        $course = Course::create(['title' => 'Laravel Course']);
        $quiz = Quiz::create([
            'course_id' => $course->id,
            'title' => $title,
            'status' => 'inactive',
        ]);
        $question = Question::create([
            'quiz_id' => $quiz->id,
            'question_text' => 'Ready question',
            'points' => 1,
        ]);
        $correctAnswer = Answer::create(['question_id' => $question->id, 'answer_text' => 'Correct', 'is_correct' => true]);
        $wrongAnswer = Answer::create(['question_id' => $question->id, 'answer_text' => 'Wrong', 'is_correct' => false]);

        return [$quiz, $question, $correctAnswer, $wrongAnswer];
    }

    private function fakePng(string $name): File
    {
        return File::createWithContent(
            $name,
            base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAwMCAO+/p9sAAAAASUVORK5CYII=')
        );
    }
}
