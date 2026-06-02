<?php

namespace Database\Seeders;

use App\Models\Answer;
use App\Models\Course;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(['email' => 'admin@example.com'], [
            'name' => 'Admin User',
            'password' => Hash::make('password'),
            'role' => User::ROLE_ADMIN,
        ]);

        User::updateOrCreate(['email' => 'student@example.com'], [
            'name' => 'Student User',
            'password' => Hash::make('password'),
            'role' => User::ROLE_STUDENT,
        ]);

        $laravel = Course::updateOrCreate(['title' => 'Laravel Fundamentals'], [
            'description' => 'Learn routes, controllers, Blade views, and Eloquent basics.',
            'status' => 'active',
        ]);

        $database = Course::updateOrCreate(['title' => 'Database Design Basics'], [
            'description' => 'Practice relational schema design, keys, and simple data integrity.',
            'status' => 'active',
        ]);

        $laravelQuiz = Quiz::updateOrCreate([
            'course_id' => $laravel->id,
            'title' => 'Laravel MVC Quiz',
        ], [
            'description' => 'A short quiz about Laravel MVC fundamentals.',
            'duration_minutes' => 15,
            'status' => 'active',
        ]);

        $databaseQuiz = Quiz::updateOrCreate([
            'course_id' => $database->id,
            'title' => 'Relational Database Quiz',
        ], [
            'description' => 'A short quiz about tables, keys, and relationships.',
            'duration_minutes' => 10,
            'status' => 'active',
        ]);

        $this->seedQuestion($laravelQuiz, 'Which layer handles HTTP requests in Laravel MVC?', [
            ['Controllers', true],
            ['Migrations', false],
            ['Seeders', false],
            ['Factories', false],
        ]);

        $this->seedQuestion($laravelQuiz, 'Which Laravel feature renders server-side HTML templates?', [
            ['Blade', true],
            ['Vue', false],
            ['React', false],
            ['Inertia', false],
        ]);

        $this->seedQuestion($databaseQuiz, 'What does a foreign key usually represent?', [
            ['A relationship to another table', true],
            ['A CSS class name', false],
            ['A password hash', false],
            ['A queue name', false],
        ]);

        $this->seedQuestion($databaseQuiz, 'Which field is normally unique for user login?', [
            ['Email', true],
            ['Role', false],
            ['Created date', false],
            ['Remember token', false],
        ]);
    }

    /**
     * @param array<int, array{0: string, 1: bool}> $answers
     */
    private function seedQuestion(Quiz $quiz, string $text, array $answers): void
    {
        $question = Question::updateOrCreate([
            'quiz_id' => $quiz->id,
            'question_text' => $text,
        ], [
            'points' => 1,
        ]);

        foreach ($answers as [$answerText, $isCorrect]) {
            Answer::updateOrCreate([
                'question_id' => $question->id,
                'answer_text' => $answerText,
            ], [
                'is_correct' => $isCorrect,
            ]);
        }
    }
}
