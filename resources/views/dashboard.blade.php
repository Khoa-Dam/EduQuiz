<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-sm font-semibold text-emerald-700">Student workspace</p>
            <h2 class="mt-1 text-2xl font-black tracking-tight text-slate-950">
                Student Dashboard
            </h2>
        </div>
    </x-slot>

    <div class="eq-page">
        <div class="eq-container">
            <section class="eq-hero-panel">
                <div class="grid gap-8 lg:grid-cols-[1.2fr_0.8fr] lg:items-center">
                    <div>
                        <p class="eq-badge">Welcome back, {{ Auth::user()->name }}</p>
                        <h3 class="mt-5 text-3xl font-black tracking-tight text-slate-950 sm:text-4xl">
                            Continue learning and keep your quiz history clear.
                        </h3>
                        <p class="mt-4 max-w-2xl text-sm leading-6 text-slate-600">
                            Browse active courses, start available quizzes, and review submitted attempts with score details.
                        </p>
                        <div class="mt-6 flex flex-col gap-3 sm:flex-row">
                            <a href="{{ route('courses.index') }}" class="eq-btn-primary">Browse Courses</a>
                            <a href="{{ route('attempts.index') }}" class="eq-btn-secondary">View Quiz History</a>
                        </div>
                    </div>

                    <div class="grid gap-3 sm:grid-cols-3 lg:grid-cols-1">
                        <div class="eq-stat-card">
                            <p class="text-sm font-semibold text-slate-500">Active courses</p>
                            <p class="mt-2 text-3xl font-black tabular-nums text-slate-950">{{ $stats['activeCourses'] }}</p>
                        </div>
                        <div class="eq-stat-card">
                            <p class="text-sm font-semibold text-slate-500">Active quizzes</p>
                            <p class="mt-2 text-3xl font-black tabular-nums text-slate-950">{{ $stats['activeQuizzes'] }}</p>
                        </div>
                        <div class="eq-stat-card">
                            <p class="text-sm font-semibold text-slate-500">My attempts</p>
                            <p class="mt-2 text-3xl font-black tabular-nums text-slate-950">{{ $stats['attempts'] }}</p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="mt-6 grid gap-4 md:grid-cols-3">
                <a href="{{ route('courses.index') }}" class="eq-card">
                    <p class="text-sm font-bold text-emerald-700">Browse Courses</p>
                    <h3 class="mt-2 text-xl font-bold text-slate-950">Find the next quiz</h3>
                    <p class="mt-2 eq-muted">See active courses and open available quizzes.</p>
                </a>
                <a href="{{ route('attempts.index') }}" class="eq-card">
                    <p class="text-sm font-bold text-emerald-700">View Quiz History</p>
                    <h3 class="mt-2 text-xl font-bold text-slate-950">Review saved results</h3>
                    <p class="mt-2 eq-muted">Check your scores, correct answers, and submitted date.</p>
                </a>
                <a href="{{ route('courses.index') }}" class="eq-card">
                    <p class="text-sm font-bold text-emerald-700">Continue Learning</p>
                    <h3 class="mt-2 text-xl font-bold text-slate-950">
                        {{ $latestAttempt ? $latestAttempt->quiz->course->title : 'Start with a course' }}
                    </h3>
                    <p class="mt-2 eq-muted">
                        {{ $latestAttempt ? 'Last submitted quiz: '.$latestAttempt->quiz->title : 'Choose a course and complete your first quiz.' }}
                    </p>
                </a>
            </section>
        </div>
    </div>
</x-app-layout>
