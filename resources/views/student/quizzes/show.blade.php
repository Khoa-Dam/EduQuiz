<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-sm font-bold text-emerald-700">{{ $quiz->course->title }}</p>
            <h2 class="mt-1 text-2xl font-black tracking-tight text-slate-950">{{ $quiz->title }}</h2>
        </div>
    </x-slot>

    <div class="eq-page">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 eq-alert-success">{{ session('success') }}</div>
            @endif

            <section class="eq-panel">
                <div class="eq-panel-body">
                    <p class="eq-badge">{{ $quiz->course->title }}</p>
                    <h3 class="mt-4 text-3xl font-black tracking-tight text-slate-950">{{ $quiz->title }}</h3>
                    <p class="mt-3 max-w-3xl text-sm leading-6 text-slate-600">{{ $quiz->description ?: 'No description provided.' }}</p>

                    <dl class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div class="eq-stat-card">
                            <dt class="text-sm font-bold text-slate-500">Questions</dt>
                            <dd class="mt-2 text-3xl font-black tabular-nums text-slate-950">{{ $quiz->questions->count() }}</dd>
                        </div>
                        <div class="eq-stat-card">
                            <dt class="text-sm font-bold text-slate-500">Duration</dt>
                            <dd class="mt-2 text-xl font-black text-slate-950">{{ $quiz->duration_minutes ? $quiz->duration_minutes.' minutes' : 'No time limit' }}</dd>
                        </div>
                    </dl>

                    <div class="mt-6 flex flex-col gap-3 border-t border-slate-100 pt-5 sm:flex-row sm:items-center sm:justify-between">
                        <a href="{{ route('courses.show', $quiz->course) }}" class="eq-link">Back to course</a>
                        <a href="{{ route('quizzes.start', $quiz) }}" class="eq-btn-primary">Start Quiz</a>
                    </div>
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
