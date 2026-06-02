<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\User;
use App\Services\LearningProgressService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LearningProgressServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_progress_summary_calculates_xp_level_and_streaks(): void
    {
        $student = User::factory()->student()->create();
        $course = Course::create(['title' => 'Progress Course']);
        $quiz = Quiz::create(['course_id' => $course->id, 'title' => 'Progress Quiz']);

        foreach ([3 => 25, 2 => 35, 1 => 90] as $daysAgo => $xp) {
            QuizAttempt::create([
                'user_id' => $student->id,
                'quiz_id' => $quiz->id,
                'score' => 1,
                'total_questions' => 1,
                'correct_answers' => 1,
                'xp_earned' => $xp,
                'started_at' => now()->subDays($daysAgo),
                'submitted_at' => now()->subDays($daysAgo),
            ]);
        }

        $summary = app(LearningProgressService::class)->summaryForUser($student);

        $this->assertSame(150, $summary['totalXp']);
        $this->assertSame(2, $summary['level']);
        $this->assertSame(3, $summary['currentStreak']);
        $this->assertSame(3, $summary['longestStreak']);
        $this->assertSame(3, $summary['attempts']);
    }
}
