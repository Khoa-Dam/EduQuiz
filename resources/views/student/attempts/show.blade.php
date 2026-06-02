<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-sm font-bold text-emerald-700">Attempt Result</p>
            <h2 class="mt-1 text-2xl font-black tracking-tight text-slate-950">{{ $attempt->quiz->title }}</h2>
        </div>
    </x-slot>

    <div class="eq-page">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 eq-alert-success">{{ session('success') }}</div>
            @endif

            <section class="eq-student-hero eq-result-hero mb-5" data-gsap-hero>
                <div class="eq-student-hero-body">
                    <div>
                        <p class="text-sm font-bold text-emerald-200">Level {{ $progress['level'] }} · {{ $attempt->quiz->course->title }}</p>
                        <h3 class="mt-3 text-4xl font-black tracking-tight text-white sm:text-5xl">{{ $attempt->quiz->title }}</h3>
                        <p class="mt-4 text-base font-bold text-emerald-50/85">Attempt Result</p>
                        <div class="mt-6 grid gap-3 sm:grid-cols-3">
                            <div class="eq-game-chip">
                                <span>Score</span>
                                <strong data-gsap-score>{{ $attempt->score }}</strong>
                            </div>
                            <div class="eq-game-chip">
                                <span>XP earned</span>
                                <strong>+{{ $attempt->xp_earned }}</strong>
                            </div>
                            <div class="eq-game-chip">
                                <span>Streak</span>
                                <strong>{{ $progress['currentStreak'] }}d</strong>
                            </div>
                        </div>
                    </div>
                    <div class="eq-media-frame hidden aspect-[4/3] lg:block">
                        @if ($attempt->quiz->coverImageUrl())
                            <img src="{{ $attempt->quiz->coverImageUrl() }}" alt="Cover image for {{ $attempt->quiz->title }}">
                        @else
                            <div class="eq-media-fallback h-full">
                                <span class="eq-media-fallback-mark">{{ $attempt->score }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </section>

            <section class="eq-panel">
                <div class="eq-panel-body">
                    <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                        <div class="eq-stat-card">
                            <dt class="text-sm font-bold text-slate-500">Score</dt>
                            <dd class="mt-2 text-3xl font-black tabular-nums text-slate-950" data-gsap-score>{{ $attempt->score }}</dd>
                        </div>
                        <div class="eq-stat-card">
                            <dt class="text-sm font-bold text-slate-500">Correct</dt>
                            <dd class="mt-2 text-3xl font-black tabular-nums text-slate-950">{{ $attempt->correct_answers }} / {{ $attempt->total_questions }}</dd>
                        </div>
                        <div class="eq-stat-card">
                            <dt class="text-sm font-bold text-slate-500">XP earned</dt>
                            <dd class="mt-2 text-3xl font-black tabular-nums text-emerald-700">+{{ $attempt->xp_earned }}</dd>
                        </div>
                        <div class="eq-stat-card">
                            <dt class="text-sm font-bold text-slate-500">Submitted</dt>
                            <dd class="mt-2 text-sm font-black text-slate-950">{{ $attempt->submitted_at?->format('Y-m-d H:i') }}</dd>
                        </div>
                    </dl>

                    <div class="mt-8">
                        <h4 class="text-xl font-black text-slate-950">Answer detail</h4>
                        <div class="mt-3 grid gap-4">
                            @foreach ($attempt->attemptAnswers as $attemptAnswer)
                                <div class="eq-result-row" data-gsap-reveal>
                                    @if ($attemptAnswer->question->imageUrl())
                                        <div class="eq-question-media">
                                            <img src="{{ $attemptAnswer->question->imageUrl() }}" alt="Image for reviewed question">
                                        </div>
                                    @endif
                                    <div class="p-5">
                                        <p class="font-bold text-slate-950">{{ $attemptAnswer->question->question_text }}</p>
                                        <p class="mt-2 text-sm text-slate-700">Your answer: {{ $attemptAnswer->answer->answer_text }}</p>
                                        <p class="mt-2 inline-flex rounded-xl px-2.5 py-1 text-xs font-black {{ $attemptAnswer->is_correct ? 'bg-emerald-50 text-emerald-800' : 'bg-red-50 text-red-800' }}">
                                            {{ $attemptAnswer->is_correct ? 'Correct' : 'Incorrect' }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="mt-6 flex flex-col gap-3 border-t border-slate-100 pt-4 sm:flex-row sm:items-center sm:justify-between">
                        <a href="{{ route('attempts.index') }}" class="eq-link">Back to my attempts</a>
                        <a href="{{ route('courses.show', $attempt->quiz->course) }}" class="eq-btn-secondary">Find another mission</a>
                    </div>
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
