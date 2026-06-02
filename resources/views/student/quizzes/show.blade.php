<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-sm font-bold text-violet-700">{{ $quiz->course->title }}</p>
            <h2 class="mt-1 text-2xl font-black tracking-tight text-slate-950">{{ $quiz->title }}</h2>
        </div>
    </x-slot>

    <div class="eq-page">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 eq-alert-success">{{ session('success') }}</div>
            @endif

            <section class="eq-student-hero" data-gsap-hero>
                <div class="eq-student-hero-body">
                    <div>
                        <p class="text-sm font-bold text-violet-700">{{ $quiz->course->title }}</p>
                        <h3 class="mt-3 text-4xl font-black tracking-tight text-slate-950 sm:text-5xl">{{ $quiz->title }}</h3>
                        <p class="mt-4 max-w-2xl text-base leading-7 text-slate-600">{{ $quiz->description ?: 'No description provided.' }}</p>
                    </div>
                    <div class="eq-media-frame aspect-[4/3]">
                        @if ($quiz->coverImageUrl())
                            <img src="{{ $quiz->coverImageUrl() }}" alt="Cover image for {{ $quiz->title }}">
                        @else
                            <div class="eq-media-fallback h-full">
                                <span class="eq-media-fallback-mark">EduQuiz</span>
                            </div>
                        @endif
                    </div>
                </div>
            </section>

            <section class="mt-5 eq-panel">
                <div class="eq-panel-body">
                    <div class="mb-5 rounded-3xl bg-violet-600 p-5 text-white shadow-lg shadow-violet-300/40">
                        <p class="text-xs font-black uppercase tracking-[0.14em] text-violet-100">Mission briefing</p>
                        <div class="mt-4 grid gap-3 sm:grid-cols-3">
                            <div>
                                <p class="text-3xl font-black tabular-nums">{{ $quiz->questions->count() }}</p>
                                <p class="mt-1 text-xs font-bold text-violet-100">questions</p>
                            </div>
                            <div>
                                <p class="text-3xl font-black tabular-nums">{{ $quiz->duration_minutes ?: 'No limit' }}</p>
                                <p class="mt-1 text-xs font-bold text-violet-100">{{ $quiz->duration_minutes ? 'minutes' : 'no time limit' }}</p>
                            </div>
                            <div>
                                <p class="text-3xl font-black tabular-nums">{{ 20 + ($quiz->questions->count() * 15) + 40 }}</p>
                                <p class="mt-1 text-xs font-bold text-violet-100">max XP</p>
                            </div>
                        </div>
                    </div>

                    <dl class="eq-metric-strip">
                        <div class="eq-metric">
                            <dt class="text-sm font-bold text-slate-500">Questions</dt>
                            <dd class="mt-2 text-3xl font-black tabular-nums text-slate-950">{{ $quiz->questions->count() }}</dd>
                        </div>
                        <div class="eq-metric">
                            <dt class="text-sm font-bold text-slate-500">Duration</dt>
                            <dd class="mt-2 text-xl font-black text-slate-950">{{ $quiz->duration_minutes ? $quiz->duration_minutes.' minutes' : 'No time limit' }}</dd>
                        </div>
                        <div class="eq-metric">
                            <dt class="text-sm font-bold text-slate-500">Ready</dt>
                            <dd class="mt-2 text-xl font-black text-slate-950">Instant feedback</dd>
                        </div>
                    </dl>

                    <div class="mt-6 flex flex-col gap-3 border-t border-slate-100 pt-5 sm:flex-row sm:items-center sm:justify-between">
                        <a href="{{ route('courses.show', $quiz->course) }}" class="eq-link">Back to course</a>
                        <a href="{{ route('quizzes.start', $quiz) }}" class="eq-btn-primary">Start Quiz - mission</a>
                    </div>
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
