<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-sm font-semibold text-emerald-700">{{ $quiz->course->title }}</p>
            <h2 class="mt-1 text-2xl font-black tracking-tight text-slate-950">{{ $quiz->title }}</h2>
        </div>
    </x-slot>

    <div class="eq-page">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 eq-alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="eq-panel">
                <div class="eq-panel-body">
                    <p class="eq-badge">{{ $quiz->course->title }}</p>
                    <p class="mt-5 text-base leading-7 text-slate-700">{{ $quiz->description ?: 'No description provided.' }}</p>

                    <dl class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div class="eq-stat-card">
                            <dt class="text-sm font-semibold text-slate-500">Questions</dt>
                            <dd class="mt-2 text-3xl font-black tabular-nums text-slate-950">{{ $quiz->questions->count() }}</dd>
                        </div>
                        <div class="eq-stat-card">
                            <dt class="text-sm font-semibold text-slate-500">Duration</dt>
                            <dd class="mt-2 text-xl font-bold text-slate-950">{{ $quiz->duration_minutes ? $quiz->duration_minutes.' minutes' : 'No time limit' }}</dd>
                        </div>
                    </dl>

                    <div class="mt-6 flex items-center justify-between border-t border-slate-100 pt-5">
                        <a href="{{ route('courses.show', $quiz->course) }}" class="eq-link">
                            Back to course
                        </a>
                        <a href="{{ route('quizzes.start', $quiz) }}" class="eq-btn-primary">
                            Start Quiz
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
