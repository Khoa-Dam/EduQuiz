<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\CourseController as AdminCourseController;
use App\Http\Controllers\Admin\QuizController as AdminQuizController;
use App\Http\Controllers\Admin\QuestionController as AdminQuestionController;
use App\Http\Controllers\Admin\AnswerController as AdminAnswerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Student\CourseController as StudentCourseController;
use App\Http\Controllers\Student\QuizAttemptController as StudentQuizAttemptController;
use App\Http\Controllers\Student\QuizAttemptHistoryController as StudentQuizAttemptHistoryController;
use App\Http\Controllers\Student\QuizController as StudentQuizController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', DashboardController::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function (): void {
        Route::get('/dashboard', AdminDashboardController::class)->name('dashboard');
        Route::resource('courses', AdminCourseController::class);
        Route::resource('quizzes', AdminQuizController::class);
        Route::resource('questions', AdminQuestionController::class);
        Route::resource('answers', AdminAnswerController::class);
    });

Route::middleware('auth')->group(function () {
    Route::get('/courses', [StudentCourseController::class, 'index'])->name('courses.index');
    Route::get('/courses/{course}', [StudentCourseController::class, 'show'])->name('courses.show');
    Route::get('/quizzes/{quiz}', [StudentQuizController::class, 'show'])->name('quizzes.show');
    Route::get('/quizzes/{quiz}/start', [StudentQuizController::class, 'start'])->name('quizzes.start');
    Route::post('/quizzes/{quiz}/submit', [StudentQuizAttemptController::class, 'store'])->name('quizzes.submit');
    Route::get('/my-attempts', [StudentQuizAttemptHistoryController::class, 'index'])->name('attempts.index');
    Route::get('/my-attempts/{attempt}', [StudentQuizAttemptHistoryController::class, 'show'])->name('attempts.show');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
